<?php

declare(strict_types=1);

namespace calibrate\caliwatch\client;

/**
 * Contains helper functions that can be used over different frameworks.
 */
class DefaultClient extends ClientBase {

  /**
   * Send an even when the cron is started.
   */
  public function sendCronStartedEvent() : void {}

  /**
   * Send a trigger when a fatal error is registred.
   */
  public function sendFatalErrorTrigger() : void {}

}
