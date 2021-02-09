<?php

namespace DoubleThreeDigital\YumYum\Console\Commands;

use DoubleThreeDigital\YumYum\Facades\Feed;
use DoubleThreeDigital\YumYum\Jobs\FeedRunnerJob;
use Illuminate\Console\Command;
use Statamic\Console\RunsInPlease;

class RunCommand extends Command
{
    use RunsInPlease;

    protected $name = 'yumyum:run';

    public function handle()
    {
        Feed::all()
            ->each(function ($feed) {
                $this->info("Running {$feed->name()}");

                FeedRunnerJob::dispatch($feed);
            });
    }
}
