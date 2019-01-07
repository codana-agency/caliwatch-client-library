<?php declare(strict_types = 1);

namespace calibrate\caliwatch\client\Command;

/**
 * Class SendDrupalUsageData.
 */
class SendDrupalUsageData
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
    public function executeCommand(array $data)
    {
        $this->watchClient->sendDrupalUsageData($data);
    }
}
