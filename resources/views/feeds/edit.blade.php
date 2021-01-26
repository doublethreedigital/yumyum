@extends('statamic::layout')
@section('title', 'Edit Feed')
@section('wrapper_class', 'max-w-xl')

@section('content')
    <form class="magic-form-builder" action="{{ $feed->updateUrl() }}" method="POST">
        @csrf

        <header class="mb-3">
            <div class="flex items-center justify-between">
                <h1>Edit Feed</h1>
                <button type="submit" class="btn-primary">Save</button>
            </div>
        </header>

        <div class="publish-form card p-0 flex flex-wrap">
            <div class="form-group w-1/2">
                <label class="block">Name</label>
                <input type="text" name="name" autofocus="autofocus" class="input-text" value="{{ $feed->name() }}">
            </div>

            <div class="form-group w-1/2">
                <label class="block">Source</label>
                <input type="url" name="source" class="input-text font-mono" value="{{ $feed->source() }}">
            </div>

            <div class="form-group w-1/2">
                <label class="block">Type</label>
                <select name="type" class="input-text" value="{{ $feed->type() }}">
                    <option value="rss">RSS</option>
                </select>
            </div>
        </div>
    </form>
@endsection
