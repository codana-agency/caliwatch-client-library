<?php declare(strict_types=1);

namespace calibrate\caliwatch\client;

/**
 * Contains helper functions that can be used over different frameworks.
 */
class DefaultClient extends ClientBase
{

    /**
     * Send the contents of the composer.lock file.
     *
     * @param  string  $lockfileContents
     *   The contents of the composer.lock file.
     */
    public function sendComposerData(string $lockfileContents): void
    {
        $contents = [
          'event' => 'php:send-composer-versions', 'value' => $lockfileContents,
        ];
        $this->sendArbitraryJson('/api/event', $contents);
    }

    /**
     * Send an event when the cron is started.
     */
    public function sendCronStartedEvent(): void
    {
        $contents = ['event' => 'php:cron-ran', 'value' => (string) time()];
        $this->sendArbitraryJson('/api/event', $contents);
    }

  /**
   * Send an event when a cron (job) is finished.
   *
   * Intended for Drupal with Ultimate Cron module.
   *
   * @param array $additional
   *   Additional data to send with the event.
   */
  public function sendCronFinishedEvent(array $additional): void
  {
    $contents = [
      'event' => 'php:ultimate-cron-ran',
      'value' => (string) time(),
      'additional' => $additional,
    ];
    $this->sendArbitraryJson('/api/event', $contents);
  }

    /**
     * Send a trigger when a fatal error is registred.
     *
     * @param string $message
     *   The error message that occurred, and that we should push to caliwatch.
     * @param int $level
     *   The severity level of the message.
     */
    public function sendFatalErrorTrigger(string $message, int $level): void
    {
        $contents = [
          'event' => 'php:error-message',
          'value' => $message,
          'severity' => $level,
        ];
        $this->sendArbitraryJson('/api/trigger', $contents);
    }

}
