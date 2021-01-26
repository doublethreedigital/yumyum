<?php

namespace DoubleThreeDigital\Feeder\Http\Controllers;

use DoubleThreeDigital\Feeder\Facades\Feed;
use DoubleThreeDigital\Feeder\Jobs\FeedRunnerJob;

class RunFeedController
{
    public function run($feed)
    {
        $feed = Feed::find($feed);

        FeedRunnerJob::dispatch($feed);

        return back();
    }
}
