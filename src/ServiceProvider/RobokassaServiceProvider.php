<?php

declare(strict_types=1);

namespace Hiap\Robokassa\ServiceProvider;

use Hiap\Robokassa\Factory\RobokassaFactory;
use Hiap\Robokassa\Robokassa;
use Illuminate\Support\ServiceProvider;

/**
 * Class RobokassaServiceProvider
 * @package App\Util
 */
class RobokassaServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../../config/robokassa.php' => config_path('robokassa.php'),
        ], 'config');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(Robokassa::class, function ($app) {
            return RobokassaFactory::build();
        });
        $this->mergeConfigFrom(__DIR__.'/../../config/robokassa.php', 'robokassa');
        $this->publishes([__DIR__.'/../../config/robokassa.php' => config_path('robokassa.php')], 'config');
    }
}
