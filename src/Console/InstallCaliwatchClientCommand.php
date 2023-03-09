<?php

declare(strict_types=1);

namespace calibrate\caliwatch\client\Console;

use Illuminate\Console\Command;

class InstallCaliwatchClientCommand extends Command
{
    protected $signature = "caliwatch:install";

    protected $description = "Install the caliwatch client package";

    public function handle(): void
    {
        $this->info("Installing caliwatch client...");
        $this->info("Publishing caliwatch configuration...");

        $this->call('vendor:publish', [
            '--provider' => "calibrate\caliwatch\client\Providers\CaliwatchClientServiceProvider",
            '--tag' => "config"
        ]);

        $this->info("Installed caliwatch client...");
    }
}