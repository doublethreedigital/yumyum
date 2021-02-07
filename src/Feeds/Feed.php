<?php

namespace DoubleThreeDigital\YumYum\Feeds;

use DoubleThreeDigital\YumYum\Facades\Feed as FeedFacade;
use Statamic\Data\ContainsData;
use Statamic\Data\ExistsAsFile;
use Statamic\Data\TracksQueriedColumns;
use Statamic\Facades\Stache;
use Statamic\Support\Traits\FluentlyGetsAndSets;
use Illuminate\Support\Str;

class Feed
{
    use FluentlyGetsAndSets, ExistsAsFile, TracksQueriedColumns, ContainsData;

    protected $id;
    protected $name;
    protected $source;
    protected $destination;
    protected $runs;

    public function __construct()
    {
        $this->data = collect();
        $this->supplements = collect();
    }

    public function id($id = null)
    {
        return $this->fluentlyGetOrSet('id')->args(func_get_args());
    }

    public function name($name = null)
    {
        return $this->fluentlyGetOrSet('name')->args(func_get_args());
    }

    public function source($source = null)
    {
        return $this->fluentlyGetOrSet('source')->args(func_get_args());
    }

    public function destination($destination = null)
    {
        return $this->fluentlyGetOrSet('destination')->args(func_get_args());
    }

    public function runs($runs = null)
    {
        return $this
            ->fluentlyGetOrSet('runs')
            ->setter(function ($value) {
                return collect($value)
                    ->sortByDesc('date')
                    ->take(10)
                    ->values()
                    ->toArray();
            })
            ->getter(function ($value) {
                if (is_null($value)) {
                    return [];
                }

                return $value;
            })
            ->args(func_get_args());
    }

    public function sourceParser()
    {
        if ($this->source()['type'] == 'rss') {
            return Sources\RSS::class;
        }

        if ($this->source()['type'] == 'json') {
            return Sources\JSON::class;
        }

        return null;
    }

    public function transformer()
    {
        if ($transformer = $this->data()->get('transformer')) {
            return $transformer;
        }

        if ($this->destination()['type'] == 'entries') {
            return Transformers\Entry::class;
        }

        return null;
    }

    public function save()
    {
        FeedFacade::save($this);

        return true;
    }

    public function delete()
    {
        FeedFacade::delete($this);

        return true;
    }

    public function path()
    {
        return Stache::store('feeder')->directory() . Str::slug($this->name()) . '.yaml';
    }

    public function fileData()
    {
        return [
            'id'          => $this->id(),
            'name'        => $this->name(),
            'source'      => $this->source(),
            'destination' => $this->destination(),
            'runs'        => $this->runs(),
        ];
    }

    public function value($key)
    {
        return $this->get($key);
    }

    public function get($key, $fallback = null)
    {
        return $this->$key() ?? $fallback;
    }

    public function showUrl()
    {
        return cp_route('yumyum.feeds.show', [
            'feed' => $this->id(),
        ]);
    }

    public function editUrl()
    {
        return cp_route('yumyum.feeds.edit', [
            'feed' => $this->id(),
        ]);
    }

    public function updateUrl()
    {
        return cp_route('yumyum.feeds.update', [
            'feed' => $this->id(),
        ]);
    }

    public function runUrl()
    {
        return cp_route('yumyum.feeds.run', [
            'feed' => $this->id(),
        ]);
    }

    public function deleteUrl()
    {
        return cp_route('yumyum.feeds.destroy', [
            'feed' => $this->id(),
        ]);
    }
}
