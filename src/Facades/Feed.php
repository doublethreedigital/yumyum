<?php

namespace DoubleThreeDigital\Feeder\Facades;

use DoubleThreeDigital\Feeder\Contracts\Stache\FeedRepository;
use Illuminate\Support\Facades\Facade;

class Feed extends Facade
{
    protected static function getFacadeAccessor()
    {
        return FeedRepository::class;
    }
}
