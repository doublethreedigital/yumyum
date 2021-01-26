@extends('statamic::layout')
@section('title', 'Feeds')

@section('content')
<div class="flex items-center justify-between mb-3">
    <h1 class="flex-1">Feeds</h1>

    <a class="btn-primary" href="{{ cp_route('feeder.feeds.create') }}">Add Feed</a>
</div>

@if ($feeds->count())
    <div class="card p-0">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Source</th>
                    <th class="actions-column"></th>
                </tr>
            </thead>

            <tbody>
                @foreach($feeds as $feed)
                    <tr id="feed_{{ $feed->id() }}">
                        <td>
                            <div class="flex items-center">
                                <a href="{{ $feed->showUrl() }}">{{ $feed->name() }}</a>
                            </div>
                        </td>
                        <td>{{ $feed->type() }} - {{ $feed->get('source') }}</td>
                        <td class="flex justify-end">
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
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- @if($forms->hasMorePages())
            <div class="w-full flex mt-3">
                <div class="flex-1"></div>

                <ul class="flex justify-center items-center list-reset">
                    @if($forms->previousPageUrl())
                        <li class="mx-1">
                            <a href="{{ $forms->previousPageUrl() }}"><span>&laquo;</span></a>
                        </li>
                    @endif

                    @foreach($forms->links()->elements[0] as $number => $link)
                        <li class="mx-1 @if($number === $forms->currentPage()) font-bold @endif">
                            <a href="{{ $link }}">{{ $number }}</a>
                        </li>
                    @endforeach

                    @if($forms->nextPageUrl())
                        <li class="mx-1">
                            <a href="{{ $forms->nextPageUrl() }}">
                                <span>»</span>
                            </a>
                        </li>
                    @endif
                </ul>

                <div class="flex flex-1">
                    <div class="flex-1"></div>
                </div>
            </div>
        @endif --}}
    </div>
@else
    @include('statamic::partials.create-first', [
        'resource' => 'Feed',
        'svg' => 'empty/collection',
        'route' => cp_route('feeder.feeds.create'),
    ])
@endif
@endsection
