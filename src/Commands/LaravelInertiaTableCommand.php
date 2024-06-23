<?php

namespace JAOcero\LaravelInertiaTable\Commands;

use Illuminate\Console\Command;

class LaravelInertiaTableCommand extends Command
{
    public $signature = 'laravel-inertia-table';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
