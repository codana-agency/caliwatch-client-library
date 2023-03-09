<?php

declare(strict_types=1);

namespace calibrate\caliwatch\client\Console;

use calibrate\caliwatch\client\Command\SendPing;
use calibrate\caliwatch\client\DefaultClient;
use Illuminate\Console\Command;

class SendPingCommand extends Command
{
    protected $signature = "caliwatch:send-ping";

    protected $description = "Sends ping to caliwatch";

    public function handle(): void
    {
        $client = new DefaultClient();
        $sendPing = new SendPing($client);
        $sendPing->executeCommand();
    }
}