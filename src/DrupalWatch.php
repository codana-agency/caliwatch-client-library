<?php

declare(strict_types=1);

namespace calibrate\caliwatch\client;

/**
 * Contains the Drupal specific functions.
 */
class DrupalWatch extends DefaultClient {

  /**
   * Send an event when the maintenance mode is turned on.
   */
  public function sendMaintenanceModeOnEvent() : void {}

  /**
   * Send an event when the maintenance mode is turned off.
   */
  public function sendMaintenanceModeOffEvent() : void {}

  /**
   * Send an event when the config is imported.
   *
   * This is usually the same as when we deploy, but not always.
   */
  public function sendConfigImportedEvent() : void {}
}

