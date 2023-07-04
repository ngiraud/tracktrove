<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="flex-1 text-2xl leading-10 font-semibold text-slate-800 dark:text-slate-200">
                {{ __('Bibliothèque de :username : :name', ['username' => $library->user->name, 'name' => $library->name]) }}
            </h2>

            <div class="ml-4">
                <form method="POST" action="{{ route($followedLibraries->contains($library) ? 'libraries.unfollow' : 'libraries.follow', $library) }}">
                    @csrf

                    <x-primary-button>
                        @if($followedLibraries->contains($library))
                            {{ __('Ne plus suivre') }}<span class="sr-only">, {{ $library->name }}</span>
                        @else
                            {{ __('Suivre') }}<span class="sr-only">, {{ $library->name }}</span>
                        @endif
                    </x-primary-button>
                </form>
            </div>
        </div>

        <x-session-status class="mt-4" :status="session('status')"/>
    </x-slot>

    <div class="space-y-6">
        <div class="p-4 sm:p-6 bg-white dark:bg-slate-800 shadow sm:rounded-lg">
            <section class="space-y-6">
                <header>
                    <h2 class="text-lg font-medium text-slate-900 dark:text-slate-100">
                        {{ __('Albums') }}
                    </h2>
                </header>

                <x-albums.filters :artists="$albums->pluck('artist')"
                                  route="libraries.show"
                                  :route-params="['library' => $library]"
                />

                <div class="overflow-x-auto">
                    <div class="inline-block min-w-full py-2 align-middle">
                        <table class="min-w-full divide-y divide-slate-300">
                            <thead>
                            <tr>
                                <th scope="col" class="sticky bg-white top-0 z-10 py-3 pr-2 pl-4 text-left text-xs font-medium uppercase tracking-wide text-slate-500 sm:pl-1">
                                    <span class="sr-only">{{ __('Image') }}</span>
                                </th>
                                <th scope="col" class="sticky top-0 z-10 px-2 py-3 text-left text-xs font-medium uppercase tracking-wide text-slate-500">
                                    {{ __('Nom') }}
                                </th>
                                <th scope="col" class="sticky top-0 z-10 px-2 py-3 text-left text-xs font-medium uppercase tracking-wide text-slate-500">
                                    {{ __('Artiste') }}
                                </th>
                                <th scope="col" class="sticky top-0 z-10 px-2 py-3 text-left text-xs font-medium uppercase tracking-wide text-slate-500">
                                    {{ __('Date de sortie') }}
                                </th>
                                <th scope="col" class="sticky top-0 z-10 px-2 py-3 text-left text-xs font-medium uppercase tracking-wide text-slate-500">
                                    {{ __('Type') }}
                                </th>
                                <th scope="col" class="sticky top-0 z-10 pr-4 pl-2 py-2 text-left text-xs font-medium uppercase tracking-wide text-slate-500 sm:pr-1">
                                    {{ __('Genres') }}
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white">
                            @forelse($albums as $album)
                                <tr class="even:bg-slate-50 hover:bg-slate-100 transition-colors">
                                    <td class="whitespace-nowrap pr-2 pl-4 text-sm font-medium text-slate-900 py-2 sm:pl-1">
                                        @isset($album->cover)
                                            <img src="{{ $album->cover }}" class="h-11 w-11"/>
                                        @endisset
                                    </td>
                                    <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-slate-900">
                                        {{ $album->name }}
                                    </td>
                                    <td class="whitespace-nowrap px-2 py-2 text-sm text-slate-500">
                                        {{ $album->artist->name }}
                                    </td>
                                    <td class="whitespace-nowrap px-2 py-2 text-sm text-slate-500">
                                        {{ str($album->released_at->isoFormat('MMM YYYY'))->ucfirst() }}
                                    </td>
                                    <td class="whitespace-nowrap px-2 py-2 text-sm text-slate-500">
                                        {{ $album->type->name }}
                                    </td>
                                    <td class="whitespace-nowrap pr-4 pl-2 py-2 text-sm text-slate-500 sm:pr-1">
                                        {!! $album->genres->pluck('name')->implode("<br/>") !!}
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

                {{ $albums->onEachSide(2)->links() }}
            </section>
        </div>
    </div>
</x-app-layout>
