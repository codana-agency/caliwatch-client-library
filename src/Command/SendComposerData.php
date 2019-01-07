<?php declare(strict_types = 1);

namespace calibrate\caliwatch\client\Command;

/**
 * Class SendComposerData
 */
class SendComposerData
{

    /**
     * SendComposerData constructor.
     */
    public function __construct($client)
    {
        $this->watchClient = $client;
    }

    /**
     * Execute command.
     */
    public function executeCommand()
    {
        $lockfile = __DIR__ . '/../../../../../composer.lock';
        $this->watchClient->sendComposerData(file_get_contents($lockfile));
    }
}
