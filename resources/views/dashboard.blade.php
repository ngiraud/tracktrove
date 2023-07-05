<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl leading-10 font-semibold text-slate-800 dark:text-slate-200">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="space-y-10">
        <dl class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                <dt class="truncate text-sm font-medium text-slate-500">
                    {{ __('Bibliothèques suivies') }}
                </dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-slate-900">
                    {{ $followingCount ?? 0 }}
                </dd>
            </div>
            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                <dt class="truncate text-sm font-medium text-slate-500">
                    {{ __('Suivent ma bibliothèque') }}
                </dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-slate-900">
                    {{ $followersCount ?? 0 }}
                </dd>
            </div>
            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                <dt class="truncate text-sm font-medium text-slate-500">
                    {{ __('Albums ajoutés') }}
                </dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-slate-900">
                    {{ $albumsCount ?? 0 }}
                </dd>
            </div>
        </dl>

        <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
            <dt class="truncate text-lg font-medium text-slate-900 font-bold">
                {{ __('Top albums') }}
            </dt>
            <dd class="mt-4 max-h-80 overflow-y-auto">
                <div class="grid grid-cols-2 gap-4">
                    @foreach($topAlbums as $album)
                        <div class="flex items-center space-x-2 rounded-md py-2 px-2 cursor-default group group:hover:bg-slate-50 hover:bg-slate-50">
                            <div class="h-14 w-14 rounded-md overflow-hidden bg-slate-100 text-slate-500 flex items-center justify-center text-lg">
                                @isset($album->cover)
                                    <img src="{{ $album->cover }}"
                                         alt="{{ $album->name }}"
                                         class="h-full w-full object-cover"
                                    >
                                @else
                                    {{ str($album->name)[0] }}
                                @endisset
                            </div>

                            <div class="flex-1 flex flex-col space-y-0.5">
                                <span>{{ $album->name }}</span>
                                <span class="text-slate-500">{{ $album->artist->name }}</span>
                            </div>

                            <div>
                                @if($albumIds?->contains($album->id))
                                    <form method="POST" action="{{ route('myaccount.albums.destroy', $album) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="text-xs text-sky-600 hover:text-sky-900"
                                                title="{{ __('Enlever de ma bibliothèque') }}"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15"/>
                                            </svg>
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('myaccount.albums.addToLibrary', $album) }}" class="text-xs text-sky-600 hover:text-sky-900"
                                       title="{{ __('Ajouter à ma bibliothèque') }}"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </dd>
        </div>
    </div>
</x-app-layout>
