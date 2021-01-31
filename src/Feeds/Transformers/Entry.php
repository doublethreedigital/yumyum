<?php

namespace DoubleThreeDigital\YumYum\Feeds\Transformers;

class Entry
{
    // TODO: interface

    protected array $item;

    public function __construct(array $item)
    {
        $this->item = $item;
    }

    public function toArray(): array
    {
        return $this->item;
    }
}
