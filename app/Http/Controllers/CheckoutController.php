<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{

    public function index()
    {
        $selectedItemIds = session('selected_cart_items', []);
        if (empty($selectedItemIds)) {
            return redirect()->route('cart.index')->with('info', 'Pilih item di keranjang terlebih dahulu.');
        }

        $cartItems = collect(\Cart::getContent())->whereIn('id', $selectedItemIds);

        return view('checkout.index', compact('cartItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'shipping_address' => 'required|string',
            'phone' => 'required|string|max:20',
        ]);

        $selectedItemIds = session('selected_cart_items', []);
        $cartItems = collect(\Cart::getContent())->whereIn('id', $selectedItemIds);

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('info', 'Tidak ada item yang dipilih untuk checkout.');
        }

        DB::beginTransaction();
        try {
            $gross_amount = $cartItems->sum(fn($item) => $item->price * $item->quantity);

            $order = Order::create([
                'user_id' => auth()->id(),
                'recipient_name' => $request->name,
                'total_price' => $gross_amount * 100,
                'status' => 'unpaid',
                'shipping_address' => $request->shipping_address,
                'phone' => preg_replace('/[^0-9]/', '', $request->phone),
            ]);

            foreach ($cartItems as $item) {
                $order->items()->create([
                    'product_id' => $item->id,
                    'quantity' => (int) $item->quantity,
                    'price' => (int) $item->price * 100,
                ]);
            }

            $snapToken = $this->getSnapTokenForOrder($order);
            $order->update(['snap_token' => $snapToken]);

            DB::commit();

            foreach ($selectedItemIds as $itemId) {
                \Cart::remove($itemId);
            }
            session()->forget('selected_cart_items');

            return view('checkout.payment', compact('snapToken', 'order'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Checkout Store Failed: " . $e->getMessage());
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }

    public function retryPayment(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        try {
            $snapToken = $this->getSnapTokenForOrder($order);
            $order->update(['snap_token' => $snapToken]);
            return response()->json(['status' => 'token_generated', 'snap_token' => $snapToken]);
        } catch (\Exception $e) {
            Log::error("Retry Payment Failed for Order #{$order->id}: " . $e->getMessage());
            return response()->json(['error' => 'Gagal membuat sesi pembayaran. Silakan hubungi dukungan.'], 500);
        }
    }

    private function getSnapTokenForOrder(Order $order): string
    {
        $order->load('user', 'items.product');

        $item_details = [];
        foreach ($order->items as $item) {
            $item_details[] = [
                'id'       => (string) $item->product_id,
                'price'    => (int) ($item->price / 100),
                'quantity' => (int) $item->quantity,
                'name'     => $item->product->name,
            ];
        }

        $recipientName = $order->recipient_name ?? $order->user->name;
        $customer_name_parts = explode(' ', $recipientName, 2);
        $phone = $order->phone ?? '081234567890';

        $params = [
            'transaction_details' => [
                'order_id' => (string) $order->id . '-' . time(),
                'gross_amount' => (int) ($order->total_price / 100),
            ],
            'customer_details' => [
                'first_name' => $customer_name_parts[0],
                'last_name' => $customer_name_parts[1] ?? '',
                'email' => $order->user->email,
                'phone' => $phone,
            ],
            'item_details' => array_values($item_details),
        ];

        $serverKey = config('midtrans.server_key');
        $url = config('midtrans.is_production')
            ? 'https://app.midtrans.com/snap/v1/transactions'
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

        $response = Http::withOptions(['verify' => config_path('ssl/cacert.pem')])
            ->withBasicAuth($serverKey, '')
            ->withHeaders(['Accept' => 'application/json'])
            ->post($url, $params);

        if ($response->failed()) {
            throw new \Exception('Gagal berkomunikasi dengan Midtrans: ' . $response->body());
        }

        $body = $response->json();
        if (empty($body['token'])) {
            throw new \Exception('Token Snap tidak ditemukan dalam respons Midtrans.');
        }

        return $body['token'];
    }

    public function success(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        return view('checkout.success', compact('order'));
    }
}
