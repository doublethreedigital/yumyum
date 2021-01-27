<?php

namespace DoubleThreeDigital\Feeder\Feeds\Formats;

use Illuminate\Support\Collection;

class RSS
{
    // TODO: interface

    protected $source;

    public function __construct(string $source)
    {
        $this->source = $source;
    }

    public function handle(): Collection
    {
        $items = [];

        try {
            $file = file_get_contents($this->source);
            $feed = simplexml_load_string($file);
        } catch (\Exception $e) {
            throw new \Exception("There was an issue parsing the RSS feed provided. ({$this->source})");
        }

        if (isset($feed->channel->item)) {
            foreach ($feed->channel->item as $item) {
                $items[] = $item;
            }
        }

        if (isset($feed->channel->entry)) {
            foreach ($feed->channel->entry as $item) {
                $items[] = $item;
            }
        }

        if (isset($feed->feed->item)) {
            foreach ($feed->feed->item as $item) {
                $items[] = $item;
            }
        }

        if (isset($feed->feed->entry)) {
            foreach ($feed->feed->entry as $item) {
                $items[] = $item;
            }
        }

        return collect($items)
            ->map(function ($item) {
                return [
                    'title'     => (string) $item->title,
                    'url'       => (string) $item->link,
                    'summary'   => (string) strip_tags($item->description) ?? strip_tags($item->summary) ?? '',
                    'date'      => (string) $item->pubDate ?? $item->updated ?? now()->isoFormat(),
                ];
            });
    }
}
