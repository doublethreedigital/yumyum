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
                ->route('yumyum.feeds.index')
                ->icon('<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" viewBox="0 0 140 140" width="140" height="140"><g transform="matrix(5.833333333333333,0,0,5.833333333333333,0,0)"><path d="M0.723 12.000 A11.250 11.250 0 1 0 23.223 12.000 A11.250 11.250 0 1 0 0.723 12.000 Z" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path><path d="M8.223 12.000 A3.750 3.750 0 1 0 15.723 12.000 A3.750 3.750 0 1 0 8.223 12.000 Z" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path><path d="M8.353,12.983A4.5,4.5,0,0,1,.807,10.619" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path><path d="M23.139,10.619a4.5,4.5,0,0,1-7.546,2.364" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path><path d="M13.473 5.250 A1.500 1.500 0 1 0 16.473 5.250 A1.500 1.500 0 1 0 13.473 5.250 Z" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path><path d="M19.473,8.625A.375.375,0,1,1,19.1,9a.375.375,0,0,1,.375-.375" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path><path d="M8.973,4.125A.375.375,0,1,1,8.6,4.5a.375.375,0,0,1,.375-.375" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path><path d="M5.223,7.875a.375.375,0,1,1-.375.375.375.375,0,0,1,.375-.375" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path></g></svg>');
        });
    }
}
