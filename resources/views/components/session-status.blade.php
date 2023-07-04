@props(['status', 'type' => 'success'])

@php
    $typeClasses = match($type) {
        'success' => 'bg-green-500 dark:bg-green-400',
        'error' => 'bg-red-500 dark:bg-red-400',
        default => 'bg-blue-500 dark:bg-blue-400',
    };
@endphp

@if ($status)
    <div {{ $attributes->merge(['class' => 'px-4 py-4 rounded-md shadow font-medium text-sm text-white '.$typeClasses]) }}>
        {{ $status }}
    </div>
@endif
