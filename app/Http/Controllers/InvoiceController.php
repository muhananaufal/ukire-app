<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function download(Order $order)
    {
        // Pastikan pengguna hanya bisa mengunduh fakturnya sendiri
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $pdf = Pdf::loadView('invoices.order', compact('order'));
        return $pdf->download('invoice-ukire-' . $order->id . '.pdf');
    }
}
