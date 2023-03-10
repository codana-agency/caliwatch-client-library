<?php declare(strict_types = 1);

namespace calibrate\caliwatch\client;

/**
 * Contains the Drupal specific functions.
 */
class DrupalWatch extends DefaultClient
{

    /**
     * Send an event when the maintenance mode is turned on.
     */
    public function sendMaintenanceModeOnEvent() : void
    {
        $this->sendEvent('drupal:maintenance-mode', 'on');
    }

    /**
     * Send an event when the maintenance mode is turned off.
     */
    public function sendMaintenanceModeOffEvent() : void
    {
        $this->sendEvent('drupal:maintenance-mode', 'off');
    }

    /**
     * Send an event when the config is imported.
     *
     * This is usually the same as when we deploy, but not always.
     */
    public function sendConfigImportedEvent() : void
    {
        $this->sendEvent('drupal:config-import', (string) time());
    }

    /**
     * Send an event with drupal data.
     *
     * @param array $data
     *   Send data about drupal usage.
     */
    public function sendDrupalUsageData(array $data = []) : void
    {
        $this->sendEvent('drupal:usage-data', $data);
    }

    /**
     * Sends a list of enabled modules for drupal 7.
     *
     * This is only used for drupal 7, for newer drupal versions, we can use the
     * more global sendComposerData method.
     *
     * @see ::sendComposerData
     *
     * @param array $modules
     *   An array of enabled modules.
     */
    public function sendDrupal7Modules(array $modules) : void
    {
        $this->sendEvent('drupal-7:modules', $modules);
    }
}
