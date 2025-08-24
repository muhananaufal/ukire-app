<section class="bg-white border border-red-300 shadow-sm rounded-xl p-6 md:p-8 space-y-6">
    <header>
        <h2 class="text-lg font-bold text-red-700">
            Hapus Akun
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen.
        </p>
    </header>

    <button 
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="inline-flex items-center justify-center rounded-md bg-red-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-500 transition-colors"
    >Hapus Akun</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                Apakah Anda yakin ingin menghapus akun Anda?
            </h2>

            <p class="mt-2 text-sm text-gray-600">
                Silakan masukkan kata sandi Anda untuk mengonfirmasi penghapusan akun secara permanen.
            </p>

            <div class="mt-6">
                {{-- Menggunakan floating input di dalam modal --}}
                <x-forms.floating-input name="password" label="Kata Sandi" type="password" required />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <button type="button" class="text-gray-600 hover:text-gray-900" x-on:click="$dispatch('close')">
                    Batal
                </button>

                <button type="submit" class="ms-3 inline-flex items-center justify-center rounded-md bg-red-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-500 transition-colors">
                    Hapus Akun
                </button>
            </div>
        </form>
    </x-modal>
</section>