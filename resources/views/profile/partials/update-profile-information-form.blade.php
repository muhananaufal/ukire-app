<section class="bg-white border border-gray-200 shadow-sm rounded-xl">
    <div class="grid grid-cols-1 md:grid-cols-3">
        <div class="p-6 md:p-8 border-b md:border-b-0 md:border-r border-gray-200">
            <div class="flex flex-col items-center md:items-start text-center md:text-left">
                <div
                    class="flex-shrink-0 h-20 w-20 rounded-full bg-amber-500 text-white flex items-center justify-center text-3xl font-bold">
                    {{ Auth::user()->initials }}
                </div>
                <div class="mt-4">
                    <h2 class="text-xl font-bold text-gray-900">
                        {{ Auth::user()->name }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ Auth::user()->email }}
                    </p>
                </div>
            </div>
        </div>

        <div class="md:col-span-2 p-6 md:p-8">
            <h3 class="text-lg font-bold text-gray-900">
                Informasi Profil
            </h3>
            <p class="mt-1 text-sm text-gray-600">
                Perbarui informasi profil dan alamat email akun Anda.
            </p>

            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>

            <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                @csrf
                @method('patch')

                <div>
                    <x-forms.floating-input name="name" label="Nama" type="text" :value="old('name', $user->name)" required
                        autofocus />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <x-forms.floating-input name="email" label="Email" type="email" :value="old('email', $user->email)" required />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                        <div class="text-sm mt-2 text-gray-800">
                            Email Anda belum terverifikasi.
                            <button form="send-verification"
                                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                                Klik di sini untuk mengirim ulang email verifikasi.
                            </button>
                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 font-medium text-sm text-green-600">
                                    Tautan verifikasi baru telah dikirimkan ke email Anda.
                                </p>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-md bg-gray-900 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-gray-700 transition-colors">
                        Simpan Perubahan
                    </button>

                    @if (session('status') === 'profile-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600">Tersimpan.</p>
                    @endif
                </div>
            </form>
        </div>
    </div>
</section>
