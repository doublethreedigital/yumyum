<?php

namespace DoubleThreeDigital\YumYum\Feeds\Sources;

use DoubleThreeDigital\YumYum\Contracts\Format as Contract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class JSON implements Contract
{
    protected $source;

    public function __construct(array $source)
    {
        $this->source = $source;
    }

    public function handle(): Collection
    {
        $response = Http::get($this->source['url']);

        return collect($response->json());
    }
}
