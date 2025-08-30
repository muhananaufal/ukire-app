<x-guest-layout>
    <div class="grid grid-cols-1 lg:grid-cols-2 min-h-screen">
        <div class="hidden lg:block relative">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1519947486511-46149fa0a254?q=80&w=1974" class="w-full h-full object-cover" alt="Detail furnitur kayu dengan latar belakang yang tenang">
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/70 to-transparent flex items-end p-12">
                <div>
                    <h2 class="text-3xl font-bold text-white leading-tight">"Kesederhanaan adalah sofistikasi tertinggi."</h2>
                    <p class="mt-4 text-lg text-white/80">- Leonardo da Vinci</p>
                </div>
            </div>
        </div>

        <div class="flex flex-col justify-center items-center p-6 sm:p-12 lg:p-16 bg-white">
            <div class="w-full max-w-md">
                <a href="/" class="inline-block mb-8">
                    <img src="{{ asset('image/logo.png') }}" alt="Logo Ukire" class="h-8" />
                </a>

                <h1 class="text-3xl font-bold text-gray-900">Lupa Kata Sandi?</h1>
                <p class="mt-2 text-gray-600">
                    Tidak masalah. Cukup masukkan alamat email Anda dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.
                </p>

                <div class="mt-6">
                    <x-auth-session-status class="mb-4" :status="session('status')" />
                </div>

                <form method="POST" action="{{ route('password.email') }}" class="mt-6">
                    @csrf

                    <div>
                        <x-forms.floating-input type="email" name="email" label="Alamat Email" :value="old('email')" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-8">
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center rounded-md bg-gray-900 px-8 py-3 text-sm font-semibold text-white shadow-sm hover:bg-gray-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-900 transition-colors">
                            Kirim Tautan Atur Ulang
                        </button>
                    </div>

                    <p class="mt-8 text-center text-sm text-gray-600">
                        Ingat kata sandi Anda?
                        <a href="{{ route('login') }}" class="font-medium text-amber-600 hover:text-amber-500">
                            Kembali ke halaman Masuk
                        </a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>