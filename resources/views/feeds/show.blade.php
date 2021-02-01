@extends('statamic::layout')
@section('title', $feed->name())
@section('wrapper_class', 'max-w-xl')

@section('content')
    <header class="mb-3">
        <div class="flex items-center justify-between">
            <h1>{{ $feed->name() }}</h1>
            <a href="{{ $feed->editUrl() }}">Edit</a>
        </div>
    </header>

    <div class="content">
        <h2 class="mb-1">Recent Runs</h2>
    </div>

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
@endsection
