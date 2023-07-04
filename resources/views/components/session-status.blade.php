@props(['status' => '', 'type' => 'success'])

@php
    $typeClasses = match($type) {
        'success' => 'border-green-400 bg-green-50 text-green-700',
        'error' => 'border-red-400 bg-red-50 text-red-700',
        default => 'border-sky-400 bg-sky-50 text-sky-700',
    };
@endphp

@if ($status || !$slot->isEmpty())
    <div {{ $attributes->merge(['class' => 'border-2 px-4 py-4 rounded-md shadow font-medium text-sm '.$typeClasses]) }}>
        @if($slot->isEmpty())
            {{ $status }}
        @else
            {{ $slot }}
        @endisset
    </div>
@endif
