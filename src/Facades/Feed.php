<?php

namespace DoubleThreeDigital\YumYum\Facades;

use DoubleThreeDigital\YumYum\Contracts\Stache\FeedRepository;
use Illuminate\Support\Facades\Facade;

class Feed extends Facade
{
    protected static function getFacadeAccessor()
    {
        return FeedRepository::class;
    }
}
