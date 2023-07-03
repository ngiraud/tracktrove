<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')"/>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('E-mail')"/>
            <x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"/>
            <x-input-error :messages="$errors->get('email')" class="mt-2"/>
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Mot de passe')"/>

            <x-text-input id="password" class="mt-1 block w-full"
                          type="password"
                          name="password"
                          required autocomplete="current-password"/>

            <x-input-error :messages="$errors->get('password')" class="mt-2"/>
        </div>

        <div class="mt-4 block">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                       class="rounded border-slate-300 text-sky-600 shadow-sm focus:ring-sky-500 dark:border-slate-700 dark:bg-slate-900 dark:focus:ring-sky-600 dark:focus:ring-offset-slate-800"
                       name="remember">
                <span class="ml-2 text-sm text-slate-600 dark:text-slate-400">{{ __('Se souvenir de moi') }}</span>
            </label>
        </div>

        <div class="mt-4 flex items-center justify-between">
            @if (Route::has('password.request'))
                <a class="rounded-md text-sm text-slate-600 underline hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 dark:text-slate-400 dark:hover:text-slate-100 dark:focus:ring-offset-slate-800"
                   href="{{ route('password.request') }}">
                    {{ __('Mot de passe oublié ?') }}
                </a>
            @endif

            <x-primary-button class="ml-6">
                {{ __('Se connecter') }}
            </x-primary-button>
        </div>

        <div class="mt-8">
            <div
                class="relative w-full text-center text-slate-400 uppercase text-sm font-semibold tracking-wide before:block before:absolute before:inset-0 before:mt-2 before:h-px before:w-full before:bg-slate-400"
            >
                <span class="bg-white relative px-4">
                    {{ __('Ou') }}
                </span>
            </div>

            <div class="mt-8">
                <a href="{{ route('register') }}"
                   class="flex items-center justify-center px-4 py-2 bg-sky-800 dark:bg-sky-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-slate-800 uppercase tracking-widest hover:bg-sky-700 dark:hover:bg-white focus:bg-sky-700 dark:focus:bg-white active:bg-sky-900 dark:active:bg-sky-300 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 dark:focus:ring-offset-sky-800 transition ease-in-out duration-150"
                >
                    {{ __('Créer un compte') }}
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>
