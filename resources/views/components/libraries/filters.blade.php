<form method="get" action="{{ route('libraries.index') }}" class="flex items-center justify-between space-x-4">
    <div class="max-w-lg flex-1">
        <div class="flex max-w-lg items-center space-x-4">
            <div class="flex-1">
                <x-text-input id="q" name="q"
                              type="text" class="w-full text-sm"
                              value="{{ request()->get('q') }}"
                              :placeholder="__('Rechercher...')"
                />
            </div>

            <div class="flex items-stretch space-x-2">
                <x-primary-button type="submit">
                    {{ __('Rechercher') }}
                </x-primary-button>

                <a href="{{ route('libraries.index', request()->only(['sort', 'direction'])) }}"
                   class="inline-flex items-center rounded-md border border-slate-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-slate-700 shadow-sm transition duration-150 ease-in-out h-[38px] hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 disabled:opacity-25 dark:border-slate-500 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700 dark:focus:ring-offset-slate-800">
                    {{ __('Effacer') }}
                </a>
            </div>
        </div>

        <x-input-error class="mt-2" :messages="$errors->get('q')"/>
    </div>

    <div>
        <x-dropdown align="right" width="96">
            <x-slot name="trigger">
                <button type="button"
                        class="inline-flex items-center rounded-md border border-slate-300 bg-white p-2 text-xs font-semibold uppercase tracking-widest text-slate-700 shadow-sm transition duration-150 ease-in-out hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 disabled:opacity-25 dark:border-slate-500 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700 dark:focus:ring-offset-slate-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z"/>
                    </svg>
                </button>
            </x-slot>

            <x-slot name="content">
                <div class="space-y-2 divide-y divide-slate-200">
                    <div class="space-y-4 px-4 py-4">
                        <div class="grid grid-cols-12 gap-2">
                            <x-input-label for="filters.artist" class="col-span-3 flex items-center" :value="__('Statut :')"/>

                            <div class="flex items-center justify-end col-span-9 space-x-2">
                                <select id="filters.status"
                                        name="filters[status]"
                                        class="mt-1 block flex-1 w-full border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 focus:border-sky-500 dark:focus:border-sky-600 focus:ring-sky-500 dark:focus:ring-sky-600 rounded-md shadow-sm"
                                >
                                    @foreach(['all' => __('Tous'), 'only-followed' => __('Seulement suivies'), 'except-followed' => __('Seulement non suivies')] as $key => $value)
                                        <option @selected(request()->string('filters.status')->value() === $key)
                                                value="{{ $key }}"
                                        >{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <x-input-error class="mt-2 col-span-12" :messages="$errors->get('filters.status')"/>
                        </div>

                        <div class="grid grid-cols-12 gap-2">
                            <x-input-label for="sort" class="col-span-3 flex items-center" :value="__('Trier par :')"/>
                            <div class="flex items-center justify-end col-span-9 space-x-2">
                                <select id="sort"
                                        name="sort"
                                        class="mt-1 block w-full border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 focus:border-sky-500 dark:focus:border-sky-600 focus:ring-sky-500 dark:focus:ring-sky-600 rounded-md shadow-sm"
                                >
                                    @foreach(['name' => __('Nom'), 'created_at' => __("Date d'ajout")] as $key => $value)
                                        <option @selected(request()->get('sort', 'name') === $key) value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <x-input-error class="mt-2 col-span-12" :messages="$errors->get('sort')"/>
                        </div>

                        <div class="grid grid-cols-12 gap-2">
                            <x-input-label for="direction" class="col-span-3 flex items-center" :value="__('Direction :')"/>
                            <div class="flex items-center justify-end col-span-9 space-x-2">
                                <select id="direction"
                                        name="direction"
                                        class="mt-1 block w-full border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 focus:border-sky-500 dark:focus:border-sky-600 focus:ring-sky-500 dark:focus:ring-sky-600 rounded-md shadow-sm"
                                >
                                    @foreach(['asc' => __('Ascendant'), 'desc' => __('Descendant')] as $key => $value)
                                        <option @selected(request()->get('direction', 'asc') === $key) value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <x-input-error class="mt-2 col-span-12" :messages="$errors->get('direction')"/>
                        </div>
                    </div>

                    <div class="flex items-stretch space-x-2 pt-5 pb-4 px-4">
                        <x-primary-button type="submit">
                            {{ __('Rechercher') }}
                        </x-primary-button>

                        <a href="{{ route('libraries.index', request()->only('q')) }}"
                           class="inline-flex items-center rounded-md border border-slate-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-slate-700 shadow-sm transition duration-150 ease-in-out h-[38px] hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 disabled:opacity-25 dark:border-slate-500 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700 dark:focus:ring-offset-slate-800">
                            {{ __('Effacer') }}
                        </a>
                    </div>
                </div>
            </x-slot>
        </x-dropdown>
    </div>
</form>
