<?php declare(strict_types = 1);

namespace calibrate\caliwatch\client\Command;

/**
 * Class SendPing
 */
class SendPing
{

    /**
     * Class constructor.
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
        $this->watchClient->sendEvent('ping', date('Y-m-d'));
    }
}
