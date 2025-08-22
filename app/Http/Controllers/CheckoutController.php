<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http; // <-- PENTING: Gunakan HTTP Client bawaan Laravel
use Illuminate\Support\Facades\Log;  // <-- PENTING: Gunakan Logger bawaan Laravel
use Midtrans\Transaction;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = \Cart::getContent();
        if (\Cart::isEmpty()) {
            return redirect()->route('catalog.index')->with('info', 'Your cart is empty.');
        }
        return view('checkout.index', compact('cartItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'shipping_address' => 'required|string',
            'phone' => 'required|string|max:20',
        ]);

        $cartItems = \Cart::getContent();
        if ($cartItems->isEmpty()) {
            return redirect()->route('catalog.index');
        }

        // Mulai transaksi database yang aman
        DB::beginTransaction();
        try {
            // Buat order dan item-nya terlebih dahulu
            $order = $this->createOrder($request, $cartItems);

            // Siapkan parameter untuk Midtrans
            $params = $this->buildMidtransParametersFromOrder($order);

            // Dapatkan Snap Token menggunakan method baru yang aman
            $snapToken = $this->requestSnapToken($params);

            // Update order dengan Snap Token
            $order->update(['snap_token' => $snapToken]);

            // Jika semua berhasil, commit transaksi dan bersihkan keranjang
            DB::commit();
            \Cart::clear();

            return view('checkout.payment', compact('snapToken', 'order'));
        } catch (\Exception $e) {
            // Jika terjadi error di titik mana pun, batalkan semua operasi database
            DB::rollBack();

            // Catat error yang detail untuk developer
            Log::error('Checkout Failed', [
                'error_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            // Tampilkan pesan yang ramah ke pengguna
            return redirect()->back()->with('error', 'We are sorry, but we could not process your order at this time. Please try again later.');
        }
    }

    public function success(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        return view('checkout.success', compact('order'));
    }

    /**
     * Method privat untuk membuat Order dan OrderItems.
     * Dibuat terpisah agar kode lebih bersih.
     */
    private function createOrder(Request $request, $cartItems): Order
    {
        $order = Order::create([
            'user_id' => auth()->id(),
            'total_price' => 0,
            'status' => 'unpaid',
            'shipping_address' => $request->shipping_address . ' | Phone: ' . $request->phone,
        ]);

        $gross_amount = 0;
        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id' => $item->id,
                'quantity' => (int) $item->quantity,
                'price' => (int) $item->price * 100,
            ]);
            $gross_amount += (int) $item->price * (int) $item->quantity;
        }

        $order->update(['total_price' => $gross_amount * 100]);
        return $order;
    }

    /**
     * Method baru untuk menangani permintaan pembayaran ulang.
     */
    public function retryPayment(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($order->status !== 'unpaid') {
            return response()->json([
                'status' => 'already_processed',
                'message' => 'This order has already been processed.'
            ]);
        }

        try {
            // LOGIKA BARU: Verifikasi status menggunakan method kustom kita
            $midtransStatus = $this->getMidtransStatus($order->id);

            if (in_array($midtransStatus['transaction_status'], ['capture', 'settlement'])) {
                $order->update(['status' => 'processing']);

                return response()->json([
                    'status' => 'paid_on_midtrans',
                    'message' => 'Payment found on Midtrans. Updating status.'
                ]);
            }

            // Jika belum lunas, lanjutkan proses pembuatan token baru
            $params = $this->buildMidtransParametersFromOrder($order);
            $snapToken = $this->requestSnapToken($params);
            $order->update(['snap_token' => $snapToken]);

            return response()->json(['status' => 'token_generated', 'snap_token' => $snapToken]);
        } catch (\Exception $e) {
            Log::error('Retry Payment Failed for Order #' . $order->id, ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Could not initiate payment.'], 500);
        }
    }

    /**
     * Method kustom baru untuk memeriksa status transaksi langsung ke API Midtrans.
     *
     * @param string|int $orderId
     * @return array
     * @throws \Exception
     */
    private function getMidtransStatus($orderId): array
    {
        $serverKey = config('midtrans.server_key');
        $url = config('midtrans.is_production')
            ? "https://api.midtrans.com/v2/{$orderId}/status"
            : "https://api.sandbox.midtrans.com/v2/{$orderId}/status";

        $response = Http::withOptions([
            'verify' => config_path('ssl/cacert.pem'),
        ])->withBasicAuth($serverKey, '')
            ->withHeaders(['Accept' => 'application/json'])
            ->get($url);

        if ($response->failed()) {
            Log::error('Midtrans Get Status Failed', [
                'order_id' => $orderId,
                'status_code' => $response->status(),
                'response_body' => $response->body()
            ]);
            throw new \Exception('Failed to get transaction status from Midtrans.');
        }

        return $response->json();
    }

    /**
     * Method privat untuk membangun parameter yang akan dikirim ke Midtrans.
     */
    private function buildMidtransParametersFromOrder(Order $order): array
    {
        $order->load('user', 'items.product'); // Pastikan semua relasi termuat

        $item_details = [];
        foreach ($order->items as $item) {
            $item_details[] = [
                'id'       => (string) $item->product_id,
                'price'    => (int) ($item->price / 100),
                'quantity' => (int) $item->quantity,
                'name'     => $item->product->name,
            ];
        }

        $customer_name_parts = explode(' ', $order->user->name, 2);

        return [
            'transaction_details' => [
                'order_id' => (string) $order->id,
                'gross_amount' => (int) ($order->total_price / 100),
            ],
            'customer_details' => [
                'first_name' => $customer_name_parts[0],
                'last_name' => $customer_name_parts[1] ?? '',
                'email' => $order->user->email,
                'phone' => preg_replace('/[^0-9]/', '', explode('| Phone: ', $order->shipping_address)[1] ?? ''),
            ],
            'item_details' => $item_details,
        ];
    }

    /**
     * Method privat untuk berkomunikasi langsung dengan API Midtrans.
     * Ini adalah inti dari error handling kita.
     */
    private function requestSnapToken(array $params): string
    {
        $serverKey = config('midtrans.server_key');
        $url = config('midtrans.is_production')
            ? 'https://app.midtrans.com/snap/v1/transactions'
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

        // Log data yang akan kita kirim
        Log::info('Requesting Snap Token to Midtrans', ['params' => $params]);

        $certificatePath = config('filesystems.certificate_path');

        $response = Http::withOptions([
            'verify' => $certificatePath,
        ])->withBasicAuth($serverKey, '')
            ->withHeaders(['Accept' => 'application/json'])
            ->post($url, $params);

        // Jika respons GAGAL (status code bukan 2xx)
        if ($response->failed()) {
            // Log respons error yang sebenarnya dari Midtrans
            Log::error('Midtrans API Request Failed', [
                'status_code' => $response->status(),
                'response_body' => $response->body()
            ]);
            // Lempar exception untuk menghentikan proses
            throw new \Exception('Failed to get Snap Token from Midtrans.');
        }

        $body = $response->json();

        // Log respons sukses
        Log::info('Midtrans API Request Success', ['response_body' => $body]);

        if (empty($body['token'])) {
            // Log jika token tidak ditemukan di respons
            Log::error('Midtrans Snap Token not found in response', ['response_body' => $body]);
            throw new \Exception('Snap Token not found in Midtrans response.');
        }

        return $body['token'];
    }
}
