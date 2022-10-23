<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class RefreshCommand extends Command
{
    protected $signature = 'shop:refresh';

    protected $description = 'Refresh';

    public function handle()
    {
        if (app()->isProduction()) {
            return Command::FAILURE;
        }

        if (!$this->hasOption('not-remove-dirs')) {
            Storage::deleteDirectory('images/products');
        }

        $this->call('artisan migrate:fresh', ['--seed' => true]);

        return Command::SUCCESS;
    }
}
