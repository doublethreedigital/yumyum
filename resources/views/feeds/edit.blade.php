@extends('statamic::layout')
@section('title', 'Edit Feed: ' . $feed->name())
@section('wrapper_class', 'max-w-xl')

@section('content')
    <form action="{{ $feed->updateUrl() }}" method="POST">
        @csrf

        <header class="mb-3">
            <div class="flex items-center justify-between">
                <h1>Edit Feed: {{ $feed->name() }}</h1>
                <button type="submit" class="btn-primary">Save</button>
            </div>
        </header>

        <div class="publish-form card p-0 flex flex-wrap">
            <div class="form-group w-full">
                <label class="block">Name</label>
                <input type="text" name="name" autofocus="autofocus" class="input-text" value="{{ $feed->name() }}">
            </div>

            <div class="w-full border-t border-gray-100 py-3">
                <div class="content px-3">
                    <h2 class="mb-1">Source</h2>
                    <p class="max-w-md">Configure where you'd like your feed to come from and we'll do the rest.</p>
                </div>

                <div class="flex flex-wrap">
                    <div class="form-group w-1/2">
                        <label class="block">Type</label>
                        <select name="source[type]" class="input-text" value="{{ $feed->source()['type'] }}">
                            <option value="rss">RSS</option>
                            <option value="json">JSON</option>
                        </select>
                    </div>

                    <div class="form-group w-1/2">
                        <label class="block">Source</label>
                        <input type="url" name="source[url]" class="input-text font-mono" placeholder="https://some.random.site/feed.json" value="{{ $feed->source()['url'] }}">
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
                        <select name="destination[type]" class="input-text" value="{{ $feed->destination()['type'] }}" onchange="updateDestinationInputs()">
                            <option value="entries">Entries</option>
                            <option value="terms">Terms</option>
                        </select>
                    </div>

                    <div id="destination-collection" class="form-group w-1/2">
                        <label class="block">Collection</label>
                        <select name="destination[collection]" class="input-text" value="{{ isset($feed->destination()['collection']) ? $feed->destination()['collection'] : '' }}">
                            @foreach(\Statamic\Facades\Collection::all() as $collection)
                                <option value="{{ $collection->handle() }}">{{ $collection->title() }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="destination-taxonomy" class="form-group w-1/2">
                        <label class="block">Taxonomy</label>
                        <select name="destination[taxonomy]" class="input-text" value="{{ isset($feed->destination()['taxonomy']) ? $feed->destination()['taxonomy'] : '' }}">
                            @foreach(\Statamic\Facades\Taxonomy::all() as $taxonomy)
                                <option value="{{ $taxonomy->handle() }}">{{ $taxonomy->title() }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        document.addEventListener('load', updateDestinationInputs())

        function updateDestinationInputs() {
            let destinationType = document.getElementsByName('destination[type]')[0].value

            document.getElementById('destination-collection').classList.add('hidden')
            document.getElementById('destination-taxonomy').classList.add('hidden')

            if (destinationType == 'entries') {
                document.getElementById('destination-collection').classList.remove('hidden')
            }

            if (destinationType == 'terms') {
                document.getElementById('destination-taxonomy').classList.remove('hidden')
            }
        }
    </script>
@endsection
