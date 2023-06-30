<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            @isset($album)
                {{ __("Édition de l'album :name", ['name' => $album->name]) }}
            @else
                {{ __("Création d'un album") }}
            @endempty
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Informations') }}
                        </h2>
                    </header>

                    <form method="post" action="{{ is_null($album) ? route('admin.albums.store') : route('admin.albums.update', $album) }}" class="mt-6 space-y-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-1">
                                <x-input-label for="name" :value="__('Nom*')"/>
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $album?->name)" required autofocus/>
                                <x-input-error class="mt-2" :messages="$errors->get('name')"/>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="artist_id" :value="__('Artiste*')"/>
                                <select id="artist_id"
                                        name="artist_id"
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                >
                                    <option disabled selected>{{ __('Choisissez') }}</option>
                                    @foreach($artists as $artist)
                                        <option {{ $album?->artist->is($artist) ? 'selected="selected"' : '' }} value="{{ $artist->id }}">{{ $artist->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('artist_id')"/>
                            </div>

                            <div>
                                <x-input-label for="artist_name" :value="__('Ou ajouter un nouvel artiste')"/>
                                <x-text-input id="artist_name" name="artist_name" type="text" class="mt-1 block w-full" :value="old('artist_name')"/>
                                <x-input-error class="mt-2" :messages="$errors->get('artist_name')"/>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-1">
                                <x-input-label for="released_at" :value="__('Date de sortie*')"/>
                                <x-text-input id="released_at" name="released_at" type="date" class="mt-1 block w-full"
                                              :value="old('released_at', $album?->released_at->format('Y-m-d'))"
                                              required
                                />
                                <x-input-error class="mt-2" :messages="$errors->get('released_at')"/>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-1">
                                <x-input-label for="type" :value="__('Type*')"/>
                                <select id="type"
                                        name="type"
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                >
                                    <option disabled selected>{{ __('Choisissez') }}</option>
                                    @foreach(\App\Enums\AlbumType::cases() as $type)
                                        <option {{ $type === $album?->type ? 'selected="selected"' : '' }} value="{{ $type->value }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('type')"/>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>

                            @if (session('status') === 'album-updated')
                                <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-gray-600 dark:text-gray-400"
                                >{{ __('Saved.') }}</p>
                            @endif
                        </div>

                        @csrf

                        @isset($album)
                            @method('put')
                        @endisset
                    </form>
                </section>
            </div>

            @isset($album)
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('admin.albums.partials.delete-album-form')
                    </div>
                </div>
            @endisset
        </div>
    </div>
</x-app-layout>

