<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full px-3 py-1 text-xs font-medium ' . $bgColor . ' ' . $textColor]) }}>
    {{ Str::ucfirst($status) }}
</span>