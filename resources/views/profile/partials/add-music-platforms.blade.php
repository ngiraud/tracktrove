<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-slate-900 dark:text-slate-100">
            {{ __('Lier une plateforme musicale') }}
        </h2>

        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
            {{ __("Dans cet espace vous pouvez lier votre compte Spotify, vous permettant ainsi de rechercher du contenu plus facilement.") }}
        </p>
    </header>

    <div class="flex items-center gap-4">
        <x-spotify-link/>

        @if (session('status') === 'music-platform-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-slate-600 dark:text-slate-400"
            >{{ __('Votre compte Spotify a bien été lié.') }}</p>
        @endif
    </div>
</section>

@isset($user->spotify_token)
    <div class="flex flex-col justify-center text-sm text-slate-600 dark:text-slate-400 text-ellipsis overflow-hidden">
        {{ __('Votre token : :token', ['token' => $user->spotify_token]) }}
    </div>
@endisset
