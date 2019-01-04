<?php declare(strict_types = 1);

namespace calibrate\caliwatch\client;

/**
 * Contains helper functions that can be used over different frameworks.
 */
class DefaultClient extends ClientBase
{

    /**
     * Send the contents of the composer.lock file.
     *
     * @param string $lockfileContents
     *   The contents of the composer.lock file.
     */
    public function sendComposerData(string $lockfileContents) : void
    {
        $contents = ['event' => 'php:send-composer-versions', 'value' => $lockfileContents];
        $this->sendArbitraryJson('/api/event', $contents);
    }

    /**
     * Send an event when the cron is started.
     */
    public function sendCronStartedEvent() : void
    {
        $contents = ['event' => 'php:cron-ran', 'value' => (string) time()];
        $this->sendArbitraryJson('/api/event', $contents);
    }

    /**
     * Send a trigger when a fatal error is registred.
     */
    public function sendFatalErrorTrigger(string $message) : void
    {
        $contents = ['event' => 'php:error-message', 'value' => $message];
        $this->sendArbitraryJson('/api/trigger', $contents);
    }
}
