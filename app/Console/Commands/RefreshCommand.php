<?php

namespace App\Console\Commands;

use App\Traits\Commands\StopOnProd;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class RefreshCommand extends Command
{
    use StopOnProd;

    public const NOT_REMOVE_DIRS_OPTION = 'notRemoveDirs';
    public const NOT_FRESH_AND_SEED_DB_OPTION = 'notFreshAndSeedDb';

    protected $signature = 'shop:refresh ' .
    '{--R|' . self::NOT_REMOVE_DIRS_OPTION . ':Without remove dirs} ' .
    '{--F|' . self::NOT_FRESH_AND_SEED_DB_OPTION . ':Without migrate:fresh --seed}';

    protected $description = 'Refresh';

    public function handle(): int
    {
        $this->stopIfProd();

        foreach ($this->dirs() as $dir) {
            $this->removeDirs($dir['path'], $dir['skipMsg']);
        }

        $this->migrateWithSeed();

        return Command::SUCCESS;
    }

    private function migrateWithSeed(): void
    {
        if ($this->hasOption(self::NOT_FRESH_AND_SEED_DB_OPTION)) {
            $this->info('SKIP "migrate:fresh"');
        } else {
            $this->call('migrate:fresh', ['--seed' => true]);
        }
    }

    private function removeDirs(string $path, string $skipMsg): void
    {
        // @TODO Refactoring
        if ($this->hasOption(self::NOT_REMOVE_DIRS_OPTION)) {
            $this->info($skipMsg);
            return;
        }

        if (Storage::exists($path)) {
            if (Storage::deleteDirectory($path)) {
                $this->info('Dir: "' . $path . '" removed...');
            } else {
                $this->info('Dir: "' . $path . '" can\'t be removed...');
            }
        } else {
            $this->info('Dir: "' . $path . '" does\'t exists...');
        }
    }

    private function dirs(): array
    {
        return [
            [
                'path' => 'images/products',
                'skipMsg' => 'Skip REMOVE Product images dir'
            ],
            [
                'path' => 'images/brands',
                'skipMsg' => 'Skip REMOVE Brands images dir'
            ],
        ];
    }
}
