<?php

namespace DoubleThreeDigital\YumYum\Contracts;

use Illuminate\Support\Collection;

interface Format
{
    public function handle(): Collection;
}
