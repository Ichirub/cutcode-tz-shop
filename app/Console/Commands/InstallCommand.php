<?php

namespace App\Console\Commands;

use App\Traits\Commands\StopOnProd;
use Illuminate\Console\Command;

class InstallCommand extends Command
{
    use StopOnProd;

    protected $signature = 'shop:install';

    protected $description = 'Installation';

    public function handle(): int
    {
        $this->stopIfProd();

        $this->call('storage:link');
        $this->call('migrate');

        return Command::SUCCESS;
    }
}
