@extends('statamic::layout')
@section('title', 'Add Feed')
@section('wrapper_class', 'max-w-xl')

@section('content')
    <form action="{{ cp_route('yumyum.feeds.store') }}" method="POST">
        @csrf

        <header class="mb-3">
            <div class="flex items-center justify-between">
                <h1>Add Feed</h1>
                <button type="submit" class="btn-primary">Create</button>
            </div>
        </header>

        <div class="publish-form card p-0 flex flex-wrap">
            <div class="form-group w-full">
                <label class="block">Name</label>
                <input type="text" name="name" autofocus="autofocus" class="input-text">
            </div>

            <div class="w-full border-t border-gray-100 py-3">
                <div class="content px-3">
                    <h2 class="mb-1">Source</h2>
                    <p class="max-w-md">Configure where you'd like your feed to come from and we'll do the rest.</p>
                </div>

                <div class="flex flex-wrap">
                    <div class="form-group w-1/2">
                        <label class="block">Type</label>
                        <select name="type" class="input-text" value="rss">
                            <option value="rss">RSS</option>
                        </select>
                    </div>

                    <div class="form-group w-1/2">
                        <label class="block">Source</label>
                        <input type="url" name="source" class="input-text font-mono" placeholder="https://some.random.site/feed.json">
                    </div>
                </div>
            </div>

            <div class="w-full border-t border-gray-100 py-3">
                <div class="content px-3">
                    <h2 class="mb-1">Destination</h2>
                    <p class="max-w-md">And now you can configure where you'd like it to go. To entries, maybe a taxonomy, an Eloquent-y thing? We can do it.</p>
                </div>

                <div class="flex flex-wrap">
                    <div class="form-group w-1/2">
                        <label class="block">Type</label>
                        <select name="destination[type]" class="input-text" value="entries">
                            <option value="entries">Entries</option>
                        </select>
                    </div>

                    <div class="form-group w-1/2">
                        <label class="block">Collection</label>
                        <select name="destination[collection]" class="input-text" value="pages">
                            @foreach(\Statamic\Facades\Collection::all() as $collection)
                                <option value="{{ $collection->handle() }}">{{ $collection->title() }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
