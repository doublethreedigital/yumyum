<?php

namespace DoubleThreeDigital\YumYum\Stache\Feeds;

use DoubleThreeDigital\YumYum\Facades\Feed as FeedFacade;
use Illuminate\Support\Arr;
use Statamic\Facades\YAML;
use Statamic\Stache\Stores\BasicStore;

class FeedStore extends BasicStore
{
    public function key()
    {
        return 'feeder';
    }

    public function makeItemFromFile($path, $contents)
    {
        $data = YAML::file($path)->parse($contents);

        if (! $id = array_pull($data, 'id')) {
            $idGenerated = true;
            $id = app('stache')->generateId();
        }

        $form = FeedFacade::make()
            ->id($id)
            ->name(array_pull($data, 'name'))
            ->type(array_pull($data, 'type'))
            ->source(array_pull($data, 'source'))
            ->destination(array_pull($data, 'destination'))
            ->runs(array_pull($data, 'runs'))
            ->data(
                Arr::except($data, ['name', 'type', 'source', 'destination'])
            );

        if (isset($idGenerated)) {
            $form->save();
        }

        return $form;
    }
}
