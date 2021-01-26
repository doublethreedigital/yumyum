<?php

namespace DoubleThreeDigital\Feeder;

use Statamic\Facades\CP\Nav;
use Statamic\Providers\AddonServiceProvider;
use Statamic\Stache\Stache;
use Statamic\Statamic;

class ServiceProvider extends AddonServiceProvider
{
    protected $routes = [
        'cp' => __DIR__.'/../routes/cp.php',
    ];

    public function boot()
    {
        parent::boot();

        Statamic::booted(function () {
            $this->app->bind(\DoubleThreeDigital\Feeder\Contracts\Stache\FeedRepository::class, function () {
                return new \DoubleThreeDigital\Feeder\Stache\Feeds\FeedRepository($this->app['stache']);
            });
        });

        $feedStore = new \DoubleThreeDigital\Feeder\Stache\Feeds\FeedStore();
        $feedStore->directory(base_path('content/feeds'));

        app(Stache::class)->registerStore($feedStore);

        Nav::extend(function ($nav) {
            $nav->content('Feeds')
                ->section('Feeder')
                ->route('feeder.feeds.index');
        });
    }
}
