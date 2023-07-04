<section>
    <header>
        <h2 class="text-lg font-medium text-slate-900 dark:text-slate-100">
            {{ __('Informations') }}
        </h2>
    </header>

    <form method="post" action="{{ route('myaccount.library.'.(is_null($library) ? 'store' : 'update')) }}" class="mt-6 space-y-6">
        <div>
            <x-input-label for="name" :value="__('Nom')"/>
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $library?->name)" autofocus/>
            <x-input-error class="mt-2" :messages="$errors->get('name')"/>
        </div>

        <div>
            <x-input-label for="description" :value="__('Description')"/>
            <textarea
                rows="6"
                class="w-full border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 focus:border-sky-500 dark:focus:border-sky-600 focus:ring-sky-500 dark:focus:ring-sky-600 rounded-md shadow-sm"
                name="description"
                id="description"
            >{{ old('description', $library?->description) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('description')"/>
        </div>

        <div x-data="{ showAlert: {{ ($library?->is_public ?? false) ? 'false' : 'true' }} }" class="space-y-4">
            <div class="flex items-center justify-between space-x-4">
                <x-input-label for="is_public" :value="__('Ma bibliothèque est publique')"/>

                <div class="flex items-center space-x-8">
                    <div class="flex items-center space-x-4">
                        <input id="is_public_yes" aria-describedby="library-is-public"
                               name="is_public"
                               type="radio"
                               value="1"
                               class="h-4 w-4 border-slate-300 text-sky-600 focus:ring-sky-600"
                               @change="showAlert = false"
                            @checked((bool)old('is_public', $library?->is_public ?? false) === true)
                        />

                        <label for="is_public_yes" class="font-medium text-slate-900">{{ __('Oui') }}</label>
                    </div>

                    <div class="flex items-center space-x-4">
                        <input id="is_public_no" aria-describedby="library-is-not-public"
                               name="is_public"
                               type="radio"
                               value="0"
                               class="h-4 w-4 border-slate-300 text-sky-600 focus:ring-sky-600"
                               @change="showAlert = true"
                            @checked((bool)old('is_public', $library?->is_public ?? false) === false)
                        />

                        <label for="is_public_no" class="font-medium text-slate-900">{{ __('Non') }}</label>
                    </div>
                </div>
            </div>

            <div x-show="showAlert" x-transition>
                <x-session-status type="info"
                                  class="flex items-center space-x-4"
                >
                    <span class="flex">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                        </svg>
                    </span>

                    <span class="block">
                        {{ __('Si votre bibliothèque devient privée, vous perdrez tous les followers associés.') }}
                    </span>
                </x-session-status>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Enregistrer') }}</x-primary-button>

            @if (session('status') === 'library-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-slate-600 dark:text-slate-400"
                >{{ __('Enregistré.') }}</p>
            @endif
        </div>

        @csrf

        @isset($library)
            @method('put')
        @endisset
    </form>
</section>
