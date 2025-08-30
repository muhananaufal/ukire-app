<x-checkout-layout>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
        <div class="max-w-2xl mx-auto mb-12">
            <ol class="flex items-center w-full">
                <li
                    class="flex w-full items-center text-amber-600 after:content-[''] after:w-full after:h-1 after:border-b after:border-amber-100 after:border-4 after:inline-block">
                    <span
                        class="flex items-center justify-center w-10 h-10 bg-amber-100 rounded-full lg:h-12 lg:w-12 shrink-0">
                        <svg class="w-4 h-4 text-amber-600 lg:w-6 lg:h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.052-.143z" />
                        </svg>
                    </span>
                </li>
                <li
                    class="flex w-full items-center text-amber-600 after:content-[''] after:w-full after:h-1 after:border-b after:border-amber-100 after:border-4 after:inline-block">
                    <span
                        class="flex items-center justify-center w-10 h-10 bg-amber-100 rounded-full lg:h-12 lg:w-12 shrink-0">
                        <svg class="w-4 h-4 text-amber-600 lg:w-6 lg:h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.052-.143z" />
                        </svg>
                    </span>
                </li>
                <li class="flex items-center">
                    <span
                        class="flex items-center justify-center w-10 h-10 bg-amber-500 text-white rounded-full lg:h-12 lg:w-12 shrink-0">
                        <span class="font-bold">3</span>
                    </span>
                </li>
            </ol>
            <div class="grid grid-cols-3 text-center text-sm font-semibold mt-2">
                <span class="text-gray-500">Keranjang</span>
                <span class="text-gray-500">Pengiriman</span>
                <span class="text-amber-600">Pembayaran</span>
            </div>
        </div>

        <div class="max-w-lg mx-auto bg-white border border-gray-200 rounded-lg shadow-sm p-8 text-center">
            <h1 class="text-2xl font-bold text-gray-900">Selesaikan Pembayaran Anda</h1>
            <p class="mt-2 text-gray-600">Pesanan Anda hampir selesai. Silakan lanjutkan untuk memilih metode pembayaran
                yang aman.</p>
            <div class="mt-6 border-t border-b py-4 space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Nomor Pesanan:</span>
                    <span class="font-medium text-gray-900">#{{ $order->id }}</span>
                </div>
                <div class="flex justify-between text-lg font-bold">
                    <span class="text-gray-900">Total Pembayaran:</span>
                    <span class="text-amber-600">Rp {{ number_format($order->total_price / 100, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="mt-8">
                <button id="pay-button"
                    class="w-full inline-flex items-center justify-center rounded-md bg-gray-900 px-8 py-4 text-base font-semibold text-white shadow-sm hover:bg-gray-700 transition-colors">
                    Bayar Sekarang
                </button>
            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('catalog.index') }}"
                    class="text-sm font-medium text-gray-600 hover:text-amber-600 transition-colors">
                    &larr; Kembali ke Katalog
                </a>
            </div>

            <div class="mt-6 flex items-center justify-center space-x-2 text-gray-500">
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z"
                        clip-rule="evenodd" />
                </svg>
                <span class="text-sm font-medium">Transaksi Aman via Midtrans</span>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
        </script>
        <script type="text/javascript">
            document.getElementById('pay-button').onclick = function() {
                this.disabled = true;
                this.textContent = 'Memuat...';

                snap.pay('{{ $snapToken }}', {
                    onSuccess: function(result) {
                        window.location.href = '{{ route('checkout.success', $order) }}'
                    },
                    onPending: function(result) {
                        alert("Menunggu pembayaran Anda!");
                        document.getElementById('pay-button').disabled = false;
                        document.getElementById('pay-button').textContent = 'Bayar Sekarang';
                    },
                    onError: function(result) {
                        alert("Pembayaran gagal!");
                        document.getElementById('pay-button').disabled = false;
                        document.getElementById('pay-button').textContent = 'Bayar Sekarang';
                    },
                    onClose: function() {
                        document.getElementById('pay-button').disabled = false;
                        document.getElementById('pay-button').textContent = 'Bayar Sekarang';
                    }
                })
            };
        </script>
    @endpush
</x-checkout-layout>
