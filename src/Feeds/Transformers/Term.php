<?php

namespace DoubleThreeDigital\YumYum\Feeds\Transformers;

use DoubleThreeDigital\YumYum\Contracts\Transformer as Contract;

class Term implements Contract
{
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
