<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl leading-10 font-semibold text-slate-800 dark:text-slate-200">
            {{ __('Bibliothèques') }}
        </h2>

        <x-session-status class="mt-4" :status="session('status')"/>
    </x-slot>

    <div class="space-y-6">
        <div class="flow-root overflow-x-auto border-b border-slate-200 bg-white p-4 shadow dark:bg-slate-800 sm:rounded-lg sm:p-6 lg:min-h-[500px]">
            <x-libraries.filters :libraries="$libraries"></x-libraries.filters>

            <div class="mt-6 overflow-x-auto">
                <div class="inline-block min-w-full py-2 align-middle">
                    <table class="min-w-full divide-y divide-slate-300">
                        <thead>
                        <tr>
                            <th scope="col" class="sticky top-0 z-10 py-3 pr-2 pl-4 text-left text-xs font-medium uppercase tracking-wide text-slate-500 sm:pl-1">
                                {{ __('Nom') }}
                            </th>
                            <th scope="col" class="sticky top-0 z-10 px-2 py-3 text-left text-xs font-medium uppercase tracking-wide text-slate-500">
                                {{ __('Utilisateur') }}
                            </th>
                            <th scope="col" class="sticky top-0 z-10 px-2 py-3 text-left text-xs font-medium uppercase tracking-wide text-slate-500">
                                {{ __('Description') }}
                            </th>
                            <th scope="col" class="sticky top-0 z-10 px-2 py-3 text-left text-xs font-medium uppercase tracking-wide text-slate-500">
                                {{ __('# albums') }}
                            </th>
                            <th scope="col" class="sticky top-0 z-10 px-2 py-3 text-left text-xs font-medium uppercase tracking-wide text-slate-500">
                                {{ __('# followers') }}
                            </th>
                            <th scope="col" class="relative sticky top-0 z-10 py-3 pr-4 pl-3 sm:pr-1">
                                <span class="sr-only">{{ __('Suivre') }}</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white">
                        @forelse($libraries as $library)
                            <tr class="even:bg-slate-50 hover:bg-slate-100 transition-colors">
                                <td class="whitespace-nowrap pr-2 pl-4 text-sm font-medium text-slate-900 py-3.5 sm:pl-1">
                                    {{ $library->name }}
                                </td>
                                <td class="whitespace-nowrap px-2 py-2 text-sm text-slate-500">
                                    {{ $library->user->name }}
                                </td>
                                <td class="whitespace-nowrap px-2 py-2 text-sm text-slate-500">
                                    {{ str($library->description)->words(10) }}
                                </td>
                                <td class="whitespace-nowrap px-2 py-2 text-sm text-slate-500">
                                    {{ $library->albums_count ?? 0 }}
                                </td>
                                <td class="whitespace-nowrap px-2 py-2 text-sm text-slate-500">
                                    {{ $library->followers_count ?? 0 }}
                                </td>
                                <td class="relative whitespace-nowrap space-x-2 pr-4 pl-3 text-right text-sm font-medium py-3.5 sm:pr-1">
                                    <a href="{{ route('libraries.show', $library) }}" class="text-sky-600 hover:text-sky-900">
                                        {{ __('Détail') }}
                                    </a>

                                    <form method="POST" action="{{ route($followedLibraries->contains($library) ? 'libraries.unfollow' : 'libraries.follow', $library) }}">
                                        @csrf

                                        <button class="text-sky-600 hover:text-sky-900">
                                            @if($followedLibraries->contains($library))
                                                {{ __('Ne plus suivre') }}<span class="sr-only">, {{ $library->name }}</span>
                                            @else
                                                {{ __('Suivre') }}<span class="sr-only">, {{ $library->name }}</span>
                                            @endif
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

            {{ $libraries->onEachSide(2)->links() }}
        </div>
    </div>
</x-app-layout>
