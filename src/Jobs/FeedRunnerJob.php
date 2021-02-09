<?php

namespace DoubleThreeDigital\YumYum\Jobs;

use Carbon\Carbon;
use DoubleThreeDigital\YumYum\Feeds\Feed;
use DoubleThreeDigital\YumYum\Feeds\Sources\RSS;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Statamic\Facades\Entry as EntryFacade;
use Illuminate\Support\Str;
use Statamic\Facades\Collection;
use Statamic\Facades\Term as TermFacade;

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
        $items = resolve($this->feed->sourceParser(), [
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
                    return;
                }

                $entry = EntryFacade::make()
                    ->collection($this->feed->destination()['collection'])
                    ->slug(Str::slug($item['title']))
                    ->data($item);

                if (Collection::findByHandle($this->feed->destination()['collection'])->dated() && isset($item['date'])) {
                    $entry->remove('date');
                    $entry->date(Carbon::parse($item['date'])->format('Y-m-d-Hi'));
                }

                $entry->save();

                $this->saved[] = $entry->reference();
            });
        }

        if ($this->feed->destination()['type'] == 'terms') {
            $items->each(function ($item) {
                $existingTerm = TermFacade::findBySlug(Str::slug($item['title']), $this->feed->destination()['taxonomy']);

                if ($existingTerm) {
                    return;
                }

                $term = TermFacade::make()
                    ->taxonomy($this->feed->destination()['taxonomy'])
                    ->slug(Str::slug($item['title']))
                    ->data($item);

                $term->save();

                $this->saved[] = $term->reference();
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
