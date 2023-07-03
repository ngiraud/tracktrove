@props([
    'align' => 'right',
    'width' => '48',
    'contentClasses' => 'rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white dark:bg-slate-700',
    'alignmentClasses' => 'rounded-md shadow-lg'
])

@php
    switch ($align) {
        case 'left':
            $alignmentClasses .= ' origin-top-left left-0';
            break;
        case 'top':
            $alignmentClasses .= ' origin-bottom bottom-0 mb-16';
            break;
        case 'right':
        default:
            $alignmentClasses .= ' origin-bottom-right right-0';
            break;
    }

    switch ($width) {
        case '48':
            $width = 'w-48';
            break;

        case '72':
            $width = 'w-72';
            break;

        case '96':
            $width = 'w-96';
            break;
    }
@endphp

<div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
    <div @click="open = ! open">
        {{ $trigger }}
    </div>

    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute z-50 mt-2 {{ $width }} {{ $alignmentClasses }}"
         style="display: none;"
         @click.outside="open = false"
    >
        <div class="{{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>
