<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center-justify-between">
            <h2 class="flex-1 text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Mes albums') }}
            </h2>

            <div class="ml-4">
                <a href="{{ route('myaccount.albums.create') }}"
                   class="inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white dark:focus:bg-white dark:focus:ring-offset-gray-800 dark:active:bg-gray-300"
                >
                    {{ __('Ajouter un album') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            <div class="flow-root overflow-x-auto border-b border-gray-200 bg-white p-4 shadow dark:bg-gray-800 sm:rounded-lg sm:p-6 lg:min-h-[500px]">
                <x-albums.filters :artists="$artists"></x-albums.filters>

                <div class="-mx-4 -my-2 mt-6 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead>
                            <tr>
                                <th scope="col" class="sticky top-0 z-10 py-3 pr-3 pl-4 text-left text-xs font-medium uppercase tracking-wide text-gray-500 sm:pl-1">
                                    {{ __('Nom') }}
                                </th>
                                <th scope="col" class="sticky top-0 z-10 px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">
                                    {{ __('Artiste') }}
                                </th>
                                <th scope="col" class="sticky top-0 z-10 px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">
                                    {{ __('Date de sortie') }}
                                </th>
                                <th scope="col" class="sticky top-0 z-10 px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">
                                    {{ __('Type') }}
                                </th>
                                <th scope="col" class="sticky top-0 z-10 px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">
                                    {{ __('Genres') }}
                                </th>
                                <th scope="col" class="relative sticky top-0 z-10 py-3 pr-4 pl-3 sm:pr-1">
                                    <span class="sr-only">{{ __('Modifier') }}</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white">
                            @forelse($albums as $album)
                                <tr class="even:bg-gray-50 hover:bg-gray-100 transition-colors">
                                    <td class="whitespace-nowrap pr-3 pl-4 text-sm font-medium text-gray-900 py-3.5 sm:pl-1">
                                        {{ $album->name }}
                                    </td>
                                    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">
                                        {{ $album->artist->name }}
                                    </td>
                                    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">
                                        {{ $album->released_at->diffForHumans() }}
                                    </td>
                                    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">
                                        {{ $album->type->name }}
                                    </td>
                                    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">
                                        {!! $album->genres->pluck('name')->implode("<br/>") !!}
                                    </td>
                                    <td class="relative whitespace-nowrap pr-4 pl-3 text-right text-sm font-medium py-3.5 sm:pr-1">
                                        <a href="{{ route('myaccount.albums.edit', $album) }}" class="text-indigo-600 hover:text-indigo-900">
                                            {{ __('Modifier') }}<span class="sr-only">, {{ $album->name }}</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr class="even:bg-gray-50">
                                    <td class="whitespace-nowrap px-2 py-6 text-center text-sm font-medium text-gray-900" colspan="6">
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
    </div>
</x-app-layout>
