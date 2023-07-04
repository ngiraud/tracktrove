<section>
    <header>
        <h2 class="text-lg font-medium text-slate-900 dark:text-slate-100">
            {{ __('Chercher les informations avec Spotify') }}
        </h2>
    </header>

    @if(session('spotify-error'))
        <div class="mt-6 space-y-6">
            <x-session-status :status="__('Votre session Spotify a expiré. Vous devez regénérer un token.')"
                              type="error"
            />

            <x-spotify-link/>
        </div>
    @else
        <form method="post" action="{{ route('spotify.search') }}" class="mt-6 space-y-6">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-1">
                    <x-input-label for="name" :value="__('Nom de l\'album')"/>
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name') }}"/>
                    <x-input-error class="mt-2" :messages="$errors->spotifySearch->get('name')"/>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Chercher les informations') }}</x-primary-button>
            </div>
        </form>
    @endif

    @if(!empty(session('spotify.albums')))
        <div class="mt-6 overflow-x-auto max-h-96">
            <div class="inline-block min-w-full py-2 align-middle">
                <table class="min-w-full divide-y divide-slate-300">
                    <thead>
                    <tr>
                        <th scope="col" class="sticky bg-white top-0 z-10 py-3 pr-2 pl-4 text-left text-xs font-medium uppercase tracking-wide text-slate-500 sm:pl-1">
                            <span class="sr-only">{{ __('Image') }}</span>
                        </th>
                        <th scope="col" class="sticky bg-white top-0 z-10 px-2 py-3 text-left text-xs font-medium uppercase tracking-wide text-slate-500">
                            {{ __('Nom') }}
                        </th>
                        <th scope="col" class="sticky bg-white top-0 z-10 px-2 py-3 text-left text-xs font-medium uppercase tracking-wide text-slate-500">
                            {{ __('Artiste') }}
                        </th>
                        <th scope="col" class="sticky bg-white top-0 z-10 px-2 py-3 text-left text-xs font-medium uppercase tracking-wide text-slate-500">
                            {{ __('# Tracks') }}
                        </th>
                        <th scope="col" class="sticky bg-white top-0 z-10 px-2 py-3 text-left text-xs font-medium uppercase tracking-wide text-slate-500">
                            {{ __('Date de sortie') }}
                        </th>
                        <th scope="col" class="sticky bg-white top-0 z-10 px-2 py-3 text-left text-xs font-medium uppercase tracking-wide text-slate-500">
                            {{ __('Type') }}
                        </th>
                        <th scope="col" class="relative sticky bg-white top-0 z-10 py-3 pr-4 pl-2 sm:pr-1">
                            <span class="sr-only">{{ __('Ajouter') }}</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white">
                    @forelse(session('spotify.albums') as $album)
                        <tr class="even:bg-slate-50 hover:bg-slate-100 transition-colors">
                            <td class="whitespace-nowrap pr-2 pl-4 text-sm font-medium text-slate-900 py-2 sm:pl-1">
                                @php($image = Arr::get($album->images, 0)?->url)

                                @if(!empty($image))
                                    <img src="{{ $image }}" class="h-11 w-11"/>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-slate-900">
                                {{ $album->name }}
                            </td>
                            <td class="whitespace-nowrap px-2 py-2 text-sm text-slate-500">
                                {{ Arr::get($album->artists, 0)?->name }}
                            </td>
                            <td class="whitespace-nowrap px-2 py-2 text-sm text-slate-500">
                                {{ $album->totalTracks }}
                            </td>
                            <td class="whitespace-nowrap px-2 py-2 text-sm text-slate-500">
                                {{ str(Date::parse($album->releaseDate)->isoFormat('MMM YYYY'))->ucfirst() }}
                            </td>
                            <td class="whitespace-nowrap px-2 py-2 text-sm text-slate-500">
                                {{ str($album->albumType)->ucfirst() }}
                            </td>
                            <td class="relative whitespace-nowrap pr-4 pl-2 text-right text-sm font-medium py-2 sm:pr-1">
                                <form method="POST" action="{{ route('spotify.store', $album->id) }}">
                                    @csrf

                                    <button type="submit" class="text-sky-600 hover:text-sky-900">
                                        {{ __('Ajouter') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr class="even:bg-slate-50">
                            <td class="whitespace-nowrap px-2 py-6 text-center text-sm font-medium text-slate-900" colspan="6">
                                {{ __('Aucun résultat') }}
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endisset
</section>
