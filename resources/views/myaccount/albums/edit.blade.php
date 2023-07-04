<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="flex-1 text-2xl leading-10 font-semibold text-slate-800 dark:text-slate-200">
                {{ __("Édition de l'album :name", ['name' => $album->name]) }}
            </h2>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="p-4 sm:p-6 bg-white dark:bg-slate-800 shadow sm:rounded-lg">
            @include('myaccount.albums.partials.form')
        </div>

        @isset($album)
            @isset($album->tracks)
                <div class="p-4 sm:p-8 bg-white dark:bg-slate-800 shadow sm:rounded-lg">
                    @include('myaccount.albums.partials.tracks')
                </div>
            @endisset

            <div class="p-4 sm:p-8 bg-white dark:bg-slate-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('myaccount.albums.partials.delete-album-form')
                </div>
            </div>
        @endisset
    </div>
</x-app-layout>

