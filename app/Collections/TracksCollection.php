<?php

namespace App\Collections;

use Carbon\CarbonInterval;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class TracksCollection extends Collection
{
    public function __construct($items = [])
    {
        parent::__construct($items);

        $this->formatDuration();
    }

    protected function formatDuration(): void
    {
        $this->items = Arr::map($this->items, fn(array $track) => [
            ...$track,
            ...['duration' => CarbonInterval::seconds($track['duration_ms'] / 1000)->cascade()->format('%i:%S')],
        ]);
    }
}
