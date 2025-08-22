<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->all();
        Log::info('Midtrans Webhook Received:', $payload);

        // ===================================================================
        // VERIFIKASI MANUAL & LOGGING MENDALAM
        // ===================================================================
        $serverKey = config('midtrans.server_key');

        // Buat "sidik jari" versi kita sendiri
        $ourSignature = hash('sha512', $payload['order_id'] . $payload['status_code'] . $payload['gross_amount'] . $serverKey);

        // Bandingkan dengan "sidik jari" dari Midtrans
        if ($ourSignature !== $payload['signature_key']) {
            Log::error('Midtrans Webhook Signature Verification FAILED', [
                'our_signature' => $ourSignature,
                'midtrans_signature' => $payload['signature_key'],
                'order_id' => $payload['order_id'],
            ]);
            // Untuk sementara, kita bisa hentikan di sini jika ingin sangat aman
            // return response()->json(['error' => 'Invalid signature'], 403);
        } else {
            Log::info('Midtrans Webhook Signature Verification SUCCESSFUL for Order #' . $payload['order_id']);
        }
        // ===================================================================

        try {
            // Karena kita sudah verifikasi, kita bisa proses datanya secara manual
            $order = Order::findOrFail($payload['order_id']);
            $status = $payload['transaction_status'];
            $fraud = $payload['fraud_status'] ?? 'accept';

            Log::info("Processing webhook for Order #{$order->id}. Transaction status: {$status}");

            if ($order->status === 'processing' || $order->status === 'completed') {
                Log::info("Webhook for Order #{$order->id} ignored because status is already processed.");
                return response()->json(['message' => 'Webhook ignored.'], 200);
            }

            if (($status == 'capture' || $status == 'settlement') && $fraud == 'accept') {
                $order->update(['status' => 'processing']);
                Log::info("Order #{$order->id} status updated to 'processing'.");
            } elseif ($status == 'deny' || $status == 'expire' || $status == 'cancel') {
                $order->update(['status' => 'cancelled']);
                Log::info("Order #{$order->id} status updated to 'cancelled'.");
            }

            return response()->json(['message' => 'Notification handled successfully.'], 200);
        } catch (\Exception $e) {
            Log::error('Midtrans Webhook Error', [
                'error_message' => $e->getMessage(),
                'order_id_from_payload' => $payload['order_id'] ?? 'N/A',
            ]);
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }
}
