<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Faktur Pesanan #{{ $order->id }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #333;
            font-size: 14px;
            line-height: 1.6;
        }

        .invoice-container {
            width: 100%;
            max-width: 800px;
            margin: auto;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table {
            margin-bottom: 40px;
        }

        .invoice-title {
            font-size: 36px;
            font-weight: bold;
            color: #333;
            margin: 0;
        }

        .details-table {
            margin-bottom: 50px;
        }

        .items-table {
            width: 100%;
        }

        .items-table .heading td {
            background: #F5F5F5;
            border-bottom: 2px solid #ddd;
            font-weight: bold;
            padding: 12px 8px;
            text-align: left;
        }

        .items-table .item td {
            border-bottom: 1px solid #eee;
            padding: 12px 8px;
        }

        .summary-table {
            width: 45%;
            margin-left: 55%;
            margin-top: 30px;
        }

        .summary-table td {
            padding: 8px;
        }

        .summary-table .total td {
            border-top: 2px solid #333;
            font-size: 18px;
            color: #c27803;
            /* A slightly darker, more premium amber */
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .brand-logo {
            font-size: 24px;
            font-weight: bold;
        }

        strong {
            color: #000;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <!-- Header -->
        <table class="header-table">
            <tr>
                <td class="brand-logo">
                    UKIRE
                </td>
                <td class="text-right">
                    <h1 class="invoice-title">FAKTUR</h1>
                    <p><strong>Nomor Pesanan:</strong> #{{ $order->id }}</p>
                    <p><strong>Tanggal Dibuat:</strong> {{ $order->created_at->format('d F Y') }}</p>
                    <p><strong>Waktu Dibuat:</strong> {{ $order->created_at->format('H:i:s') }}</p>
                </td>
            </tr>
        </table>

        <!-- Informasi Pelanggan & Pengiriman -->
        <table class="details-table">
            <tr>
                <td width="50%">
                    <strong>Ditagihkan Kepada:</strong><br>
                    {{ $order->user->name }}<br>
                    {{ $order->user->email }}
                </td>
                <td width="50%" class="text-right">
                    <strong>Dikirim Kepada:</strong><br>
                    {{ $order->recipient_name }}<br>
                    {{ $order->shipping_address }}<br>
                    {{ $order->phone }}
                </td>
            </tr>
        </table>

        <!-- Daftar Item -->
        <table class="items-table">
            <tr class="heading">
                <td class="text-left">Produk</td>
                <td class="text-center">Kuantitas</td>
                <td class="text-right">Harga Satuan</td>
                <td class="text-right">Subtotal</td>
            </tr>
            @foreach ($order->items as $item)
                <tr class="item">
                    <td>{{ $item->product->name }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">Rp {{ number_format($item->price / 100, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format(($item->price / 100) * $item->quantity, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </table>

        <!-- Ringkasan Total -->
        <table class="summary-table">
            <tr>
                <td class="text-right">Subtotal</td>
                <td class="text-right">Rp {{ number_format($order->total_price / 100, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="text-right">Pengiriman</td>
                <td class="text-right">Gratis</td>
            </tr>
            <tr class="total">
                <td class="text-right"><strong>Total</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($order->total_price / 100, 0, ',', '.') }}</strong>
                </td>
            </tr>
        </table>

        <!-- Footer Faktur -->
        <div class="footer">
            <p>Terima kasih telah berbelanja di Ukire.id!</p>
            <p>Jika ada pertanyaan mengenai faktur ini, silakan hubungi layanan pelanggan kami.</p>
        </div>
    </div>
</body>

</html>
