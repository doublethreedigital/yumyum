<?php

namespace DoubleThreeDigital\YumYum\Feeds\Sources;

use DoubleThreeDigital\YumYum\Contracts\Format as Contract;
use Illuminate\Support\Collection;
use SimpleXMLElement;

class RSS implements Contract
{
    protected $source;
    protected $colonSeparator = 'YUMCOOKIETIME';

    public function __construct(array $source)
    {
        $this->source = $source;
    }

    public function handle(): Collection
    {
        $items = [];

        try {
            $file = file_get_contents($this->source['url']);

            // When an RSS feed has a `:` in an attribute key, Simple XML will just ignore the
            // attributes altogether. This regex temporarily swaps it out before we parse the
            // feed and then it is swapped back in later on when we map it into a Collection.
            $file = preg_replace('~(</?|\s)([a-z0-9_]+):~is', "$1$2{$this->colonSeparator}", $file);

            $feed = simplexml_load_string($file);
        } catch (\Exception $e) {
            throw new \Exception("There was an issue parsing the RSS feed provided. ({$this->source['url']})");
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
                return collect((array) $item)->mapWithKeys(function ($value, $key) {
                    $key = str_replace($this->colonSeparator, ':', $key);

                    if ($value instanceof SimpleXMLElement) {
                        return [$key => (array) $value];
                    }

                    if (is_string($value)) {
                        return [$key => str_replace($this->colonSeparator, ':', $value)];
                    }

                    return null;
                })->toArray();
            });
    }
}
