<?php

namespace App\Providers;

use App\Http\Kernel;
use App\Services\Faker\Image\FakerImageProvider;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Carbon\CarbonInterval;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if ($this->app->isLocal()) {
            $this->app->register(IdeHelperServiceProvider::class);
        }

        $this->app->singleton(Generator::class, function () {
            $faker = Factory::create(config('app.faker_locale'));
            $faker->addProvider(new FakerImageProvider($faker));

            return $faker;
        });
    }

    public function boot(): void
    {
        if (!$this->app->isProduction()) {
            Model::shouldBeStrict(true);
            return;
        }

        // @TODO Refactoring later
        $telegramLogger = function (string $msg, array $context = []) {
            logger()
                ->channel('telegram')
                ->debug($msg, $context);
        };

        /**
         * PRODUCTION
         */
        DB::listen(static function ($query) use ($telegramLogger) {
            // $query->sql | ->bindings | ->time
            if ($query->time > 500) {
                $telegramLogger('DB::listen' . $query->sql, $query->bindings);
            }
        });

        app(Kernel::class)->whenRequestLifecycleIsLongerThan(
            CarbonInterval::seconds(4),
            function () use ($telegramLogger) {
                $telegramLogger('whenRequestLifecycleIsLongerThan: ' . request()->url());
            }
        );
    }
}
