<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="flex-1 text-2xl leading-10 font-semibold text-slate-800 dark:text-slate-200">
                {{ __('Mes albums') }}
            </h2>

            <div class="ml-4">
                <a href="{{ route('myaccount.albums.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-sky-800 dark:bg-sky-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-slate-800 uppercase tracking-widest hover:bg-sky-700 dark:hover:bg-white focus:bg-sky-700 dark:focus:bg-white active:bg-sky-900 dark:active:bg-sky-300 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 dark:focus:ring-offset-sky-800 transition ease-in-out duration-150"
                >
                    {{ __('Ajouter un album') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="flow-root overflow-x-auto border-b border-slate-200 bg-white p-4 shadow dark:bg-slate-800 sm:rounded-lg sm:p-6 lg:min-h-[500px]">
            <x-albums.filters :artists="$artists"></x-albums.filters>

            <div class="mt-6 overflow-x-auto">
                <div class="inline-block min-w-full py-2 align-middle">
                    <table class="min-w-full divide-y divide-slate-300">
                        <thead>
                        <tr>
                            <th scope="col" class="sticky top-0 z-10 py-3 pr-3 pl-4 text-left text-xs font-medium uppercase tracking-wide text-slate-500 sm:pl-1">
                                {{ __('Nom') }}
                            </th>
                            <th scope="col" class="sticky top-0 z-10 px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-slate-500">
                                {{ __('Artiste') }}
                            </th>
                            <th scope="col" class="sticky top-0 z-10 px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-slate-500">
                                {{ __('Date de sortie') }}
                            </th>
                            <th scope="col" class="sticky top-0 z-10 px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-slate-500">
                                {{ __('Type') }}
                            </th>
                            <th scope="col" class="sticky top-0 z-10 px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-slate-500">
                                {{ __('Genres') }}
                            </th>
                            <th scope="col" class="relative sticky top-0 z-10 py-3 pr-4 pl-3 sm:pr-1">
                                <span class="sr-only">{{ __('Modifier') }}</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white">
                        @forelse($albums as $album)
                            <tr class="even:bg-slate-50 hover:bg-slate-100 transition-colors">
                                <td class="whitespace-nowrap pr-3 pl-4 text-sm font-medium text-slate-900 py-3.5 sm:pl-1">
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
                                <td class="whitespace-nowrap px-2 py-2 text-sm text-slate-500">
                                    {!! $album->genres->pluck('name')->implode("<br/>") !!}
                                </td>
                                <td class="relative whitespace-nowrap pr-4 pl-3 text-right text-sm font-medium py-3.5 sm:pr-1">
                                    <a href="{{ route('myaccount.albums.edit', $album) }}" class="text-sky-600 hover:text-sky-900">
                                        {{ __('Modifier') }}<span class="sr-only">, {{ $album->name }}</span>
                                    </a>
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

            <div class="mt-4">
                {{ $albums->onEachSide(2)->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
