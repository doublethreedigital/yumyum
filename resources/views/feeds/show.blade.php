@extends('statamic::layout')
@section('title', 'Feed: '.$feed->name())
@section('wrapper_class', 'max-w-xl')

@section('content')
    <header class="mb-3">
        <div class="flex items-center justify-between">
            <h1>Feed: {{ $feed->name() }}</h1>

            <div>
                <dropdown-list class="mr-1">
                    <dropdown-item :text="__('Run Feed')" redirect="{{ $feed->runUrl() }}"></dropdown-item>
                    <dropdown-item :text="__('Edit Feed')" redirect="{{ $feed->editUrl() }}"></dropdown-item>
                    <dropdown-item :text="__('Delete Feed')" class="warning" @click="$refs.deleter.confirm()">
                        <resource-deleter
                            ref="deleter"
                            resource-title="{{ $feed->name() }}"
                            route="{{ $feed->deleteUrl() }}"
                            :reload="true"
                            @deleted="document.getElementById('feed_{{ $feed->id() }}').remove()"
                        ></resource-deleter>
                    </dropdown-item>
                </dropdown-list>
            </div>
        </div>
    </header>

    <div class="content">
        <h2 class="mb-1">Recent Runs</h2>
    </div>

    @if(collect($feed->runs())->count() == 0)
        <div class="bg-white py-2 px-2 rounded w-full">
            <p>This feed has never ran. <a class="text-blue" href="{{ $feed->runUrl() }}">Run it now</a></p>
        </div>
    @else
        <table class="data-table bg-white rounded w-full">
            <thead>
                <tr>
                    <th>Date & Time</th>
                    <th>Items saved</th>
                </tr>
            </thead>
            <tbody>
                @foreach($feed->runs() as $run)
                    <tr>
                        <td>
                            <div class="little-dot mr-1 @if($run['result'] == 'success') bg-green @else bg-gray @endif"></div>
                            <a href="#">{{ \Carbon\Carbon::parse($run['date'])->format('Y-m-d H:i:s') }}</a>
                        </td>
                        <td>{{ collect($run['saved'])->count() }} item</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
