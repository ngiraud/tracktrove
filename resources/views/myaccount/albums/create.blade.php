<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="flex-1 text-2xl leading-10 font-semibold text-slate-800 dark:text-slate-200">
                {{ __("Création d'un album") }}
            </h2>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="p-4 sm:p-6 bg-white dark:bg-slate-800 shadow sm:rounded-lg">
            @include('myaccount.albums.partials.find-with-spotify')
        </div>

        <div class="p-4 sm:p-6 bg-white dark:bg-slate-800 shadow sm:rounded-lg">
            @include('myaccount.albums.partials.form')
        </div>
    </div>
</x-app-layout>

