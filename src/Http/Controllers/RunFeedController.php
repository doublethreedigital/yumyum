<?php

namespace DoubleThreeDigital\YumYum\Http\Controllers;

use DoubleThreeDigital\YumYum\Facades\Feed;
use DoubleThreeDigital\YumYum\Jobs\FeedRunnerJob;

class RunFeedController
{
    public function run($feed)
    {
        $feed = Feed::find($feed);

        FeedRunnerJob::dispatch($feed);

        return back();
    }
}
