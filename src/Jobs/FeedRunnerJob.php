<?php

namespace DoubleThreeDigital\YumYum\Jobs;

use DoubleThreeDigital\YumYum\Feeds\Feed;
use DoubleThreeDigital\YumYum\Feeds\Sources\RSS;
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

    protected $result;
    protected $date;
    protected $saved;

    public function __construct(Feed $feed)
    {
        $this->feed = $feed;

        $this->result = 'failure';
        $this->date = now()->timestamp;
        $this->saved = [];
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
        if ($this->feed->destination()['type'] == 'entries') {
            $items->each(function ($item) {
                $existingEntry = EntryFacade::findBySlug(Str::slug($item['title']), $this->feed->destination()['collection']);

                if ($existingEntry) {
                    // TODO: Log "Can't process as entry already exists"
                    return;
                }

                $entry = EntryFacade::make()
                    ->collection($this->feed->destination()['collection'])
                    ->slug(Str::slug($item['title']))
                    ->data($item);

                $entry->save();

                $this->saved[] = $entry->reference();
            });
        }

        $this->result = true;

        $this->feed->runs(array_merge($this->feed->runs(), [
            [
                'result' => $this->result,
                'date'   => $this->date,
                'saved'  => $this->saved,
            ],
        ]))->save();
    }
}
