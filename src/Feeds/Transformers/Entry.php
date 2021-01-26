<?php

namespace DoubleThreeDigital\Feeder\Feeds\Transformers;

class Entry
{
    // TODO: interface

    protected $item;

    public function __construct($item)
    {
        $this->item = $item;
    }

    public function toArray(): array
    {
        return [
            'title'     => $this->item['title'],
            'content'   => $this->item['summary'],
            'date'      => \Carbon\Carbon::parse($this->item['date']),
        ];
    }
}
