<?php

namespace DoubleThreeDigital\Feeder\Http\Controllers;

use DoubleThreeDigital\Feeder\Facades\Feed as FeedFacade;
use DoubleThreeDigital\Feeder\Feeds\Feed;
use Illuminate\Http\Request;
use Statamic\Facades\Stache;
use Statamic\Http\Controllers\CP\CpController;

class FeedController extends CpController
{
    public function index()
    {
        return view('feeder::feeds.index', [
            'feeds' => FeedFacade::all(),
        ]);
    }

    public function create()
    {
        return view('feeder::feeds.create');
    }

    public function store(Request $request)
    {
        $feed = FeedFacade::make()
            ->id(Stache::generateId())
            ->name($request->name)
            ->type($request->type)
            ->source($request->source);

        $feed->save();

        return redirect()->to($feed->showUrl());
    }

    public function show($feed)
    {
        $feed = FeedFacade::find($feed);

        return view('feeder::feeds.show', [
            'feed' => $feed,
        ]);
    }

    public function edit()
    {
        //
    }

    public function update()
    {
        //
    }

    public function destroy($feed)
    {
        FeedFacade::find($feed)->delete();

        return redirect()->to(cp_route('feeder.feeds.index'));
    }
}
