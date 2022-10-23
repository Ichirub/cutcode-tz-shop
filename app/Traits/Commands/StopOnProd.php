<?php

declare(strict_types=1);

namespace App\Traits\Commands;

use Illuminate\Console\Command;

trait StopOnProd
{
    protected function stopIfProd()
    {
        if (app()->isProduction()) {
            $this->alert($this->stopMessage());
            die(Command::FAILURE);
        }
    }

    protected function stopMessage(): string
    {
        return 'Can\'t use this command on PROD';
    }
}
