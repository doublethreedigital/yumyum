@extends('statamic::layout')
@section('title', 'Feed')
@section('wrapper_class', 'max-w-xl')

@section('content')
    <header class="mb-3">
        <div class="flex items-center justify-between">
            <h1>{{ $feed->name() }}</h1>
            <h3>{{ $feed->source() }}</h3>
            <a href="{{ $feed->editUrl() }}">Edit</a>
        </div>
    </header>

    <p>TODO: error log</p>
    <p>TODO: show recent runs</p>
    <p>TODO: show recent saved entries</p>
@endsection
