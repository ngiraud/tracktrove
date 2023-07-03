@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'px-4 py-4 rounded-md shadow font-medium text-sm text-white bg-green-500 dark:bg-green-400']) }}>
        {{ $status }}
    </div>
@endif
