<?php

namespace DoubleThreeDigital\YumYum\Http\Controllers;

use DoubleThreeDigital\YumYum\Facades\Feed as FeedFacade;
use Illuminate\Http\Request;
use Statamic\Facades\Stache;
use Statamic\Http\Controllers\CP\CpController;

class FeedController extends CpController
{
    public function index()
    {
        return view('yumyum::feeds.index', [
            'feeds' => FeedFacade::all(),
        ]);
    }

    public function create()
    {
        return view('yumyum::feeds.create');
    }

    public function store(Request $request)
    {
        $feed = FeedFacade::make()
            ->id(Stache::generateId())
            ->name($request->name)
            ->type($request->type)
            ->source($request->source)
            ->destination($request->destination);

        $feed->save();

        return redirect()->to($feed->showUrl());
    }

    public function show($feed)
    {
        $feed = FeedFacade::find($feed);

        return view('yumyum::feeds.show', [
            'feed' => $feed,
        ]);
    }

    public function edit($feed)
    {
        $feed = FeedFacade::find($feed);

        return view('yumyum::feeds.edit', [
            'feed' => $feed,
        ]);
    }

    public function update(Request $request, $feed)
    {
        $feed = FeedFacade::find($feed)
            ->name($request->name)
            ->type($request->type)
            ->source($request->source)
            ->destination($request->destination);

        $feed->save();

        return redirect()->to($feed->showUrl());
    }

    public function destroy($feed)
    {
        FeedFacade::find($feed)->delete();

        return redirect()->to(cp_route('yumyum.feeds.index'));
    }
}
