@extends('statamic::layout')
@section('title', 'Feed')
@section('wrapper_class', 'max-w-xl')

@section('content')
    <div class="magic-form-builder">
        <header class="mb-3">
            <div class="flex items-center justify-between">
                <h1>Feed - {{ $feed->id() }}</h1>
            </div>
        </header>
    </div>
@endsection
