<?php
use Illuminate\Support\Facades\View;
?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('image/logokecil.svg') }}" type="image/svg+xml">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>


    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body x-data="{ atTop: true }" @scroll.window="atTop = (window.pageYOffset > 50) ? false : true"
    @cart-refreshed.window="AOS.refresh()"
    class="font-sans antialiased text-gray-900 bg-white flex flex-col min-h-screen">
    <x-partials.header />
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <x-partials.footer />

    @livewireScripts
    @stack('scripts')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
        });

        const swiper = new Swiper('.swiper-container', {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            slidesPerView: 1,
            spaceBetween: 30,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },

            on: {
                init: function() {
                    this.el.style.visibility = 'visible';
                },
            },
        });
    </script>
    <script>
        function payOrder(paymentUrl, successUrl, button) {
            button.disabled = true;
            button.textContent = 'Memproses...';

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(paymentUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Server responded with an error.');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                        button.disabled = false;
                        button.textContent = 'Lanjutkan Pembayaran';
                        return;
                    }

                    if (data.status === 'paid_on_midtrans' || data.status === 'already_processed') {
                        alert(data.message + ' Halaman akan dimuat ulang.');
                        window.location.reload();
                        return;
                    }

                    if (data.status === 'token_generated') {
                        snap.pay(data.snap_token, {
                            onSuccess: function(result) {
                                window.location.href = successUrl;
                            },
                            onPending: function(result) {
                                alert("Menunggu pembayaran Anda!");
                                window.location.reload();
                            },
                            onError: function(result) {
                                alert("Pembayaran gagal!");
                                button.disabled = false;
                                button.textContent = 'Lanjutkan Pembayaran';
                            },
                            onClose: function() {
                                button.disabled = false;
                                button.textContent = 'Lanjutkan Pembayaran';
                            }
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Tidak dapat memulai pembayaran. Silakan coba lagi nanti.');
                    button.disabled = false;
                    button.textContent = 'Lanjutkan Pembayaran';
                });
        }
    </script>

    @if (
        !request()->is('admin*') &&
            !request()->routeIs(['login', 'register', 'password.request']) &&
            !View::hasSection('hide_floating_whatsapp'))
        <a href="https://wa.me/{{ config('ukire.whatsapp_number') }}?text={{ urlencode('Halo Ukire, saya ingin bertanya...') }}"
            target="_blank"
            class="fixed bottom-6 right-6 z-40 bg-green-500 text-white p-4 rounded-full shadow-lg hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-slate-800 focus:ring-offset-2 focus:bg-slate-800 hover:outline-none hover:ring-2 hover:ring-green-500 hover:ring-offset-2 transition-transform duration-300 hover:scale-110"
            aria-label="Chat via WhatsApp">
            <svg xmlns="https://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 48 48"
                class="h-8 w-8">
                <path fill="#fff"
                    d="M4.9,43.3l2.7-9.8C5.9,30.6,5,27.3,5,24C5,13.5,13.5,5,24,5c5.1,0,9.8,2,13.4,5.6	C41,14.2,43,18.9,43,24c0,10.5-8.5,19-19,19c0,0,0,0,0,0h0c-3.2,0-6.3-0.8-9.1-2.3L4.9,43.3z">
                </path>
                <path fill="#fff"
                    d="M4.9,43.8c-0.1,0-0.3-0.1-0.4-0.1c-0.1-0.1-0.2-0.3-0.1-0.5L7,33.5c-1.6-2.9-2.5-6.2-2.5-9.6	C4.5,13.2,13.3,4.5,24,4.5c5.2,0,10.1,2,13.8,5.7c3.7,3.7,5.7,8.6,5.7,13.8c0,10.7-8.7,19.5-19.5,19.5c-3.2,0-6.3-0.8-9.1-2.3	L5,43.8C5,43.8,4.9,43.8,4.9,43.8z">
                </path>
                <path fill="#cfd8dc"
                    d="M24,5c5.1,0,9.8,2,13.4,5.6C41,14.2,43,18.9,43,24c0,10.5-8.5,19-19,19h0c-3.2,0-6.3-0.8-9.1-2.3	L4.9,43.3l2.7-9.8C5.9,30.6,5,27.3,5,24C5,13.5,13.5,5,24,5 M24,43L24,43L24,43 M24,43L24,43L24,43 M24,4L24,4C13,4,4,13,4,24	c0,3.4,0.8,6.7,2.5,9.6L3.9,43c-0.1,0.3,0,0.7,0.3,1c0.2,0.2,0.4,0.3,0.7,0.3c0.1,0,0.2,0,0.3,0l9.7-2.5c2.8,1.5,6,2.2,9.2,2.2	c11,0,20-9,20-20c0-5.3-2.1-10.4-5.8-14.1C34.4,6.1,29.4,4,24,4L24,4z">
                </path>
                <path fill="#40c351"
                    d="M35.2,12.8c-3-3-6.9-4.6-11.2-4.6C15.3,8.2,8.2,15.3,8.2,24c0,3,0.8,5.9,2.4,8.4L11,33l-1.6,5.8	l6-1.6l0.6,0.3c2.4,1.4,5.2,2.2,8,2.2h0c8.7,0,15.8-7.1,15.8-15.8C39.8,19.8,38.2,15.8,35.2,12.8z">
                </path>
                <path fill="#fff" fill-rule="evenodd"
                    d="M19.3,16c-0.4-0.8-0.7-0.8-1.1-0.8c-0.3,0-0.6,0-0.9,0	s-0.8,0.1-1.3,0.6c-0.4,0.5-1.7,1.6-1.7,4s1.7,4.6,1.9,4.9s3.3,5.3,8.1,7.2c4,1.6,4.8,1.3,5.7,1.2c0.9-0.1,2.8-1.1,3.2-2.3	c0.4-1.1,0.4-2.1,0.3-2.3c-0.1-0.2-0.4-0.3-0.9-0.6s-2.8-1.4-3.2-1.5c-0.4-0.2-0.8-0.2-1.1,0.2c-0.3,0.5-1.2,1.5-1.5,1.9	c-0.3,0.3-0.6,0.4-1,0.1c-0.5-0.2-2-0.7-3.8-2.4c-1.4-1.3-2.4-2.8-2.6-3.3c-0.3-0.5,0-0.7,0.2-1c0.2-0.2,0.5-0.6,0.7-0.8	c0.2-0.3,0.3-0.5,0.5-0.8c0.2-0.3,0.1-0.6,0-0.8C20.6,19.3,19.7,17,19.3,16z"
                    clip-rule="evenodd"></path>
            </svg>

        </a>
    @endif
</body>

</html>
