<?php

declare(strict_types=1);

namespace calibrate\caliwatch\client\Providers;

use calibrate\caliwatch\client\Console\InstallCaliwatchClientCommand;
use calibrate\caliwatch\client\Console\SendComposerDataCommand;
use calibrate\caliwatch\client\Console\SendPingCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;

final class CaliwatchClientServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'caliwatch');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('caliwatch.php'),
            ], 'config');

            $this->commands(
                commands: [
                    InstallCaliwatchClientCommand::class,
                    SendComposerDataCommand::class,
                    SendPingCommand::class
                ]
            );
        }
        $this->callAfterResolving(Schedule::class, function (Schedule $schedule) {
            $schedule->command('caliwatch:send-ping')->everyTwoHours();
        });
    }
}