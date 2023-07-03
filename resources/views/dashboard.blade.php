<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl leading-10 font-semibold text-slate-800 dark:text-slate-200">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div>
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
    </div>
</x-app-layout>
