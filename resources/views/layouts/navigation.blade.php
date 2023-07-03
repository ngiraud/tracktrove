<div x-data="{ open: false }" class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
    <div class="flex grow flex-col gap-y-8 overflow-y-auto border-r border-slate-200 bg-white">
        <div class="flex items-center justify-center p-2">
            <a href="{{ route('dashboard') }}" class="py-2">
                <x-application-logo class="block h-16 w-auto fill-current text-sky-500 dark:text-sky-200"/>
            </a>
        </div>

        <nav class="flex flex-1 flex-col">
            <ul role="list" class="flex flex-1 flex-col gap-y-7">
                @isset(auth()->user()->library)
                    <li>
                        <div class="px-8 text-xs font-semibold leading-6 text-slate-400 uppercase">{{ __('Menu') }}</div>
                        <ul role="list" class="mt-2">
                            <li>
                                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                    {{ __('Dashboard') }}
                                </x-nav-link>
                            </li>
                            <li>
                                <x-nav-link :href="route('libraries.index')" :active="request()->routeIs('libraries.*')">
                                    {{ __('Bibliothèques') }}
                                </x-nav-link>
                            </li>
                        </ul>
                    </li>


                    <li>
                        <div class="px-8 text-xs font-semibold leading-6 text-slate-400 uppercase">{{ __('Bibliothèque') }}</div>
                        <ul role="list" class="mt-2">
                            <li>
                                <x-nav-link :href="route('myaccount.albums.index')" :active="request()->routeIs('myaccount.albums.*')">
                                    {{ __('Mes albums') }}
                                </x-nav-link>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="flex items-center justify-center">
                        <a href="{{ route('myaccount.library.create') }}"
                           class="inline-flex items-center px-4 py-2 bg-sky-800 dark:bg-sky-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-slate-800 uppercase tracking-widest hover:bg-sky-700 dark:hover:bg-white focus:bg-sky-700 dark:focus:bg-white active:bg-sky-900 dark:active:bg-sky-300 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 dark:focus:ring-offset-sky-800 transition ease-in-out duration-150"
                        >
                            {{ __('Créer ma bibliothèque') }}
                        </a>
                    </li>
                @endisset

                <li class="mt-auto">
                    <x-dropdown align="top" width="72" class="w-full" content-classes="border-t border-slate-200 py-1" alignment-classes="empty">
                        <x-slot name="trigger">
                            <button
                                @class([
                                    'border-r-4 flex w-full items-center gap-x-4 px-6 py-3 text-sm font-semibold leading-6 hover:bg-slate-50',
                                    'border-transparent text-slate-900' => !request()->routeIs('profile.edit') && !request()->routeIs('myaccount.library.edit'),
                                    'border-sky-600 text-sky-600' => request()->routeIs('profile.edit') || request()->routeIs('myaccount.library.edit')
                                ])
                            >
                                <span @class([
                                    'flex items-center justify-center h-8 w-8 rounded-full uppercase border',
                                    'text-slate-500 bg-slate-50 border-slate-400' => !request()->routeIs('profile.edit') && !request()->routeIs('myaccount.library.edit'),
                                    'text-sky-500 bg-sky-50 border-sky-400' => request()->routeIs('profile.edit') || request()->routeIs('myaccount.library.edit')
                                ])>
                                    {{ str(Auth::user()->name)[0] }}
                                </span>

                                <span class="sr-only">{{ __('Votre profil') }}</span>
                                <span aria-hidden="true">{{ Auth::user()->name }}</span>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="-my-1">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profil') }}
                                </x-dropdown-link>

                                @isset(auth()->user()->library)
                                    <x-dropdown-link :href="route('myaccount.library.edit')" :active="request()->routeIs('library.edit')">
                                        {{ auth()->user()->library->name }}
                                    </x-dropdown-link>
                                @endisset

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('logout')"
                                                     onclick="event.preventDefault();
                                                this.closest('form').submit();"
                                    >
                                        {{ __('Se déconnecter') }}
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </li>
            </ul>
        </nav>
    </div>
</div>
