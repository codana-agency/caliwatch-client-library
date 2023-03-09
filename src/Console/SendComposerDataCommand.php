<?php

declare(strict_types=1);

namespace calibrate\caliwatch\client\Console;

use calibrate\caliwatch\client\Command\SendComposerData;
use calibrate\caliwatch\client\DefaultClient;
use Illuminate\Console\Command;

class SendComposerDataCommand extends Command
{
    protected $signature = "caliwatch:send-composer";

    protected $description = "Sends composer.lock data to caliwatch";

    public function handle(): void
    {
        $client = new DefaultClient();
        $sendComposerData = new SendComposerData($client);
        $sendComposerData->executeCommand();
    }
}