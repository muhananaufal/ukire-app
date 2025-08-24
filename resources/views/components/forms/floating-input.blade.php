@props(['disabled' => false, 'type' => 'text', 'name', 'label'])

<div class="relative" x-data="{ show: false }">
    <input 
        {{ $disabled ? 'disabled' : '' }}
        {{-- Logika tipe dikontrol 100% oleh Alpine.js --}}
        :type="('{{ $type }}' === 'password' && show) ? 'text' : '{{ $type }}'"
        id="{{ $name }}"
        name="{{ $name }}"
        placeholder=" "
        {{ $attributes->merge(['class' => 'peer block w-full appearance-none rounded-md border border-gray-300 bg-gray-50 px-4 pt-6 pb-2 text-base text-gray-900 shadow-sm focus:border-amber-600 focus:outline-none focus:ring-0']) }}
    />
    <label 
        for="{{ $name }}" 
        class="absolute top-4 left-4 z-10 origin-[0] -translate-y-4 scale-75 transform text-base text-gray-500 duration-300 peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:-translate-y-4 peer-focus:scale-75 peer-focus:text-amber-600"
    >
        {{ $label }}
    </label>
    
    @if ($type === 'password')
    <div class="absolute inset-y-0 right-0 flex items-center pr-4">
        <button 
            type="button" 
            @click="show = !show" 
            class="text-gray-500 hover:text-gray-700 focus:outline-none"
        >
            <span class="sr-only">Show/hide password</span>
            
            {{-- Ikon mata terbuka --}}
            <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.432 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            
            {{-- Ikon mata tercoret --}}
            <svg x-show="show" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.243 4.243l-4.243-4.243" />
            </svg>
        </button>
    </div>
    @endif
</div>