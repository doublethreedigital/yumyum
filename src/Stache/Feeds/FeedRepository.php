<?php

namespace DoubleThreeDigital\Feeder\Stache\Feeds;

use DoubleThreeDigital\Feeder\Contracts\Stache\FeedRepository as Contract;
use DoubleThreeDigital\Feeder\Feeds\Feed;
use Statamic\Data\DataCollection;
use Statamic\Stache\Stache;

class FeedRepository implements Contract
{
    protected $stache;
    protected $store;

    public function __construct(Stache $stache)
    {
        $this->stache = $stache;
        $this->store = $stache->store('feeder');
    }

    public function all(): DataCollection
    {
        return $this->query()->get();
    }

    public function find($id): ?Feed
    {
        return $this->query()->where('id', $id)->first();
    }

    public function save($form)
    {
        $this->store->save($form);
    }

    public function delete($entry)
    {
        $this->store->delete($entry);
    }

    public function query()
    {
        return new FeedQueryBuilder($this->store);
    }

    public function make(): Feed
    {
        return new Feed();
    }
}
