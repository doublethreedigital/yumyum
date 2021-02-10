<?php

namespace DoubleThreeDigital\YumYum\Console\Commands;

use Statamic\Console\RunsInPlease;

class MakeTransformer extends GeneratorCommand
{
    use RunsInPlease;

    protected $name = 'statamic:yumyum:transformer';
    protected $description = 'Create a new transformer';
    protected $type = 'Transformer';
    protected $stub = 'transformer.php.stub';

    public function handle()
    {
        if (parent::handle() === false) {
            return false;
        }
    }
}
