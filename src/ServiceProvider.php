<?php

namespace DoubleThreeDigital\YumYum;

use Statamic\Facades\CP\Nav;
use Statamic\Providers\AddonServiceProvider;
use Statamic\Stache\Stache;

class ServiceProvider extends AddonServiceProvider
{
    protected $commands = [
        Console\Commands\RunCommand::class,
    ];

    protected $routes = [
        'cp' => __DIR__.'/../routes/cp.php',
    ];

    public function boot()
    {
        parent::boot();

        \Statamic\Statamic::booted(function () {
            $this->app->bind(\DoubleThreeDigital\YumYum\Contracts\Stache\FeedRepository::class, function () {
                return new \DoubleThreeDigital\YumYum\Stache\Feeds\FeedRepository($this->app['stache']);
            });
        });

        $feedStore = new \DoubleThreeDigital\YumYum\Stache\Feeds\FeedStore();
        $feedStore->directory(base_path('content/feeds'));

        app(Stache::class)->registerStore($feedStore);

        Nav::extend(function ($nav) {
            $nav->content('Feeds')
                ->section('YumYum')
                ->route('yumyum.feeds.index');
        });
    }
}
