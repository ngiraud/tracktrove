<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl leading-10 font-semibold text-slate-800 dark:text-slate-200">
            @isset($library)
                {{ __('Modifier ma bibliothèque : :name', ['name' => $library->name]) }}
            @else
                {{ __('Créer ma bibliothèque') }}
            @endisset
        </h2>
    </x-slot>

    <div class="space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-slate-800 shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('library.partials.form')
            </div>
        </div>

        @isset($library)
            <div class="p-4 sm:p-8 bg-white dark:bg-slate-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('library.partials.delete-library-form')
                </div>
            </div>
        @endisset
    </div>
</x-app-layout>
