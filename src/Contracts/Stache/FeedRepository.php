<?php

namespace DoubleThreeDigital\YumYum\Contracts\Stache;

interface FeedRepository
{
    public function all();

    public function find($id);

    public function make();

    public function query();

    public function save($feed);

    public function delete($feed);
}
