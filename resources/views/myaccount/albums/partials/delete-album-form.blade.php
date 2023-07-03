<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-slate-900 dark:text-slate-100">
            {{ __("Supprimer l'album") }}
        </h2>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-album-deletion')"
    >{{ __("Supprimer l'album") }}</x-danger-button>

    <x-modal name="confirm-album-deletion" :show="$errors->albumDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('myaccount.albums.destroy', $album) }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-slate-900 dark:text-slate-100">
                {{ __("Supprimer l'album ?") }}
            </h2>

            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                {{ __('Une fois votre album supprimé, toutes ses ressources et données seront définitivement supprimées.') }}
            </p>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('Supprimer') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
