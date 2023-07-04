<section>
    <header>
        <h2 class="text-lg font-medium text-slate-900 dark:text-slate-100">
            {{ __('Tracks') }}
        </h2>
    </header>

    <div class="mt-6 grid grid-cols-2 gap-4">
        @foreach($album->tracks as $track)
            <div class="flex items-center justify-between">
                <span class="flex text-sm self-start">
                    {{ $track['track_number'] }}.
                </span>
                <span class="ml-1 flex-1 flex text-sm text-left self-start">
                    {{ $track['name'] }}
                </span>
                <span class="ml-4 flex text-sm text-slate-500 self-start">
                    {{ $track['duration'] }}
                </span>
            </div>
        @endforeach
    </div>
</section>
