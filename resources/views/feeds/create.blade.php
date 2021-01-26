@extends('statamic::layout')
@section('title', 'Add Feed')
@section('wrapper_class', 'max-w-xl')

@section('content')
    <form class="magic-form-builder" action="{{ cp_route('feeder.feeds.store') }}" method="POST">
        @csrf

        <header class="mb-3">
            <div class="flex items-center justify-between">
                <h1>Add Feed</h1>
                <button type="submit" class="btn-primary">Create</button>
            </div>
        </header>

        <div class="publish-form card p-0 flex flex-wrap">
            <div class="form-group w-1/2">
                <label class="block">Name</label>
                <input type="text" name="name" autofocus="autofocus" class="input-text">
            </div>

            <div class="form-group w-1/2">
                <label class="block">Source</label>
                <input type="url" name="source" class="input-text font-mono">
            </div>

            <div class="form-group w-1/2">
                <label class="block">Type</label>
                <select name="type" class="input-text">
                    <option value="rss">RSS</option>
                </select>
            </div>
        </div>

        <!-- <div class="content mt-5 mb-2">
            <h2>Fields</h2>
            <p class="max-w-lg">Configure the fields that will be used in this form. These are the fields that you'll be able to submit with your form. At some point, you'll also be able to configure form pages here.</p>
        </div> -->
    </form>
@endsection
