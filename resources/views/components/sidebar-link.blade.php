@props(['active', 'href'])

@php
$classes = ($active ?? false)
            ? 'flex items-center px-4 py-2 text-white bg-green-800 rounded-md transition-colors duration-200'
            : 'flex items-center px-4 py-2 text-green-50 hover:bg-green-800 hover:text-white rounded-md transition-colors duration-200';
@endphp

{{-- PERBAIKAN: Menambahkan atribut href ke dalam tag <a> --}}
<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
