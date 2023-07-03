@props(['active'])

@php
    $classes = ($active ?? false)
                ? 'px-8 py-3 transition-colors ease-in-out border-r-4 border-sky-600 text-sky-600 hover:text-sky-600 group flex gap-x-3 font-semibold hover:bg-slate-50'
                : 'px-8 py-3 transition-colors ease-in-out border-r-4 border-transparent text-slate-600 hover:text-sky-600 hover:bg-slate-50 group flex gap-x-3 font-semibold';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
