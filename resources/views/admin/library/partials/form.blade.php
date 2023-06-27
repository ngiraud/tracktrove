<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Informations') }}
        </h2>
    </header>

    <form method="post" action="{{ route(is_null($library) ? 'library.store' : 'library.update') }}" class="space-y-6">
        <div>
            <x-input-label for="name" :value="__('Nom')"/>
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $library?->name)" required autofocus/>
            <x-input-error class="mt-2" :messages="$errors->get('name')"/>
        </div>

        <div>
            <x-input-label for="description" :value="__('Description')"/>
            <textarea
                rows="6"
                class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                name="description"
                id="description"
            >{{ old('description', $library?->description) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('description')"/>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'library-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>

        @csrf

        @isset($library)
            @method('put')
        @endisset
    </form>
</section>
