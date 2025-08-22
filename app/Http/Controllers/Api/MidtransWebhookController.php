<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransWebhookController extends Controller
{
    public function handle()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');

        try {
            $notification = new Notification();

            $order = Order::findOrFail($notification->order_id);
            $status = $notification->transaction_status;
            $fraud = $notification->fraud_status;

            if ($status == 'capture' || $status == 'settlement') {
                if ($fraud == 'accept') {
                    $order->update(['status' => 'processing']);
                }
            } elseif ($status == 'pending') {
                // Masih menunggu pembayaran
            } elseif ($status == 'deny' || $status == 'expire' || $status == 'cancel') {
                $order->update(['status' => 'cancelled']);
            }

            return response()->json(['message' => 'Notification handled'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
