<?php

namespace DoubleThreeDigital\YumYum\Feeds\Sources;

use DoubleThreeDigital\YumYum\Contracts\Format as Contract;
use Illuminate\Support\Collection;
use SimpleXMLElement;

class RSS implements Contract
{
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
            ->map(function (SimpleXMLElement $item) {
                return collect((array) $item)->map(function ($value) {
                    if ($value instanceof SimpleXMLElement) {
                        return (array) $value;
                    }

                    return $value;
                })->toArray();
            });
    }
}
