<?php

namespace DoubleThreeDigital\Feeder\Jobs;

use DoubleThreeDigital\Feeder\Feeds\Feed;
use DoubleThreeDigital\Feeder\Feeds\Formats\RSS;
use DoubleThreeDigital\Feeder\Feeds\Transformers\Entry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Statamic\Facades\Entry as EntryFacade;
use Illuminate\Support\Str;

class FeedRunnerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    protected $feed;

    public function __construct(Feed $feed)
    {
        $this->feed = $feed;
    }

    public function handle()
    {
        // Parse feed
        $items = resolve(RSS::class, [
            'source' => $this->feed->source(),
        ])->handle();

        // Transform into array
        $items = $items->map(function ($item) {
            return resolve($this->feed->transformer(), [
                'item' => $item,
            ])->toArray();
        });

        // Save as entry, etc.
        $items->each(function ($item) {
            EntryFacade::make()
                ->collection('pages')
                ->slug(Str::slug($item['title']))
                ->data($item)
                ->save();
        });
    }
}
