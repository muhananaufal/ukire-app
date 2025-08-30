<x-guest-layout>
    <div class="grid grid-cols-1 lg:grid-cols-2 min-h-screen">
        <div class="hidden lg:block relative">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1616047006789-b7af5afb8c20?q=80&w=2080"
                    class="w-full h-full object-cover" alt="Detail kursi kayu dengan desain elegan">
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/70 to-transparent flex items-end p-12">
                <div>
                    <h2 class="text-3xl font-bold text-white leading-tight">"Desain yang baik adalah membuat dunia
                        sedikit lebih baik dari yang Anda temukan."</h2>
                    <p class="mt-4 text-lg text-white/80">- Dieter Rams</p>
                </div>
            </div>
        </div>

        <div class="flex flex-col justify-center items-center p-6 sm:p-12 lg:p-16 bg-white">
            <div class="w-full max-w-md">
                <a href="/" class="inline-block mb-8">
                    <img src="{{ asset('image/logo.png') }}" alt="Logo Ukire" class="h-8" />
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Buat Akun Baru</h1>
                <p class="mt-2 text-gray-600">Mulai perjalanan Anda bersama Ukire.</p>
                <div class="mt-8">
                    <a href="{{ route('login.google') }}"
                        class="w-full flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
                        <svg xmlns="https://www.w3.org/2000/svg" x="0px" y="0px" class="h-5 w-5 mr-3"
                            viewBox="0 0 48 48">
                            <path fill="#FFC107"
                                d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z">
                            </path>
                            <path fill="#FF3D00"
                                d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z">
                            </path>
                            <path fill="#4CAF50"
                                d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z">
                            </path>
                            <path fill="#1976D2"
                                d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z">
                            </path>
                        </svg> <span>Daftar dengan Google</span>
                    </a>
                </div>

                <div class="my-8 flex items-center">
                    <div class="flex-grow border-t border-gray-200"></div>
                    <span class="mx-4 flex-shrink text-sm font-semibold text-gray-400">ATAU DAFTAR DENGAN EMAIL</span>
                    <div class="flex-grow border-t border-gray-200"></div>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <x-forms.floating-input type="text" name="name" label="Nama Lengkap" :value="old('name')"
                                required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-forms.floating-input type="email" name="email" label="Alamat Email" :value="old('email')"
                                required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-forms.floating-input type="password" name="password" label="Kata Sandi" required />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div>
                            <x-forms.floating-input type="password" name="password_confirmation"
                                label="Konfirmasi Kata Sandi" required />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mt-8">
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center rounded-md bg-gray-900 px-8 py-3 text-sm font-semibold text-white shadow-sm hover:bg-gray-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-900 transition-colors">
                            Daftar
                        </button>
                    </div>

                    <p class="mt-8 text-center text-sm text-gray-600">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="font-medium text-amber-600 hover:text-amber-500">
                            Masuk di sini
                        </a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
