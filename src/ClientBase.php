<?php

declare(strict_types=1);

namespace calibrate\caliwatch\client;

use \GuzzleHttp\Client;

/**
 * Contains the base implementations to send data to caliwatch.
 */
abstract class ClientBase {

  /**
   * The guzzle client.
   *
   * @var \GuzzleHttp\Client
   */
  private $guzzle;

  /**
   * Creates a new instance of this class.
   *
   * @param string $token
   *   The caliwatch token for this site instance.
   */
  public function __construct(string $token) {
    $this->guzzle = new Client([
      'base_uri' => 'http://caliwatch-2.calidev.in/',
      'timeout' => 0,
      'allow_redirects' => FALSE,
      'headers' => ['Caliwatch-Token' => $token],
    ]);
  }

  /**
   * Sends a trigger to caliwatch.
   *
   * These triggers can be sent directly to slack and should be used for
   * notifications only, try to limit the amount of triggers to reduce
   * notification fatigue.
   *
   * @param string $message
   *   The message to send.
   * @param string $type
   *   The severity/type of trigger to log in caliwatch. Will determine what
   *   color/icon will be used in slack for example. Possible values are:
   *   success|info|warning|error|critical|reminder.
   *   Defaults to error.
   */
  public function sendTrigger(string $message, string $type = 'error') : void {
    $contents = [
      'type' => $type,
      'message' => $message,
    ];
    $this->guzzle->post('/api/trigger', ['body' => json_encode($contents)]);
  }

  /**
   * Send an event to caliwatch.
   *
   * Events are things that are monitored and can trigger automatic slack
   * messages/notifications. These are all handled by the caliwatch server.
   *
   * @param string $eventName
   *   The name of the event we're updating for.
   * @param string $value
   *   The value of this event, as a string.
   */
  public function sendEvent(string $eventName, string $value) : void {
    $contents = [
      'event' => $eventName,
      'value' => $value,
    ];
    $this->guzzle->post('/api/event', ['body' => json_encode($contents)]);
  }

  /**
   * Send the contents of the composer.lock file.
   *
   * @param string $lockfileContents
   *   The contents of the composer.lock file.
   */
  public function sendComposerData(string $lockfileContents) : void {
    $contents = ['event' => 'php:composer-lock', 'value' => $lockfileContents];
    $this->guzzle->post('/api/event', ['body' => json_encode($contents)]);
  }

  /**
   * Send arbitrary data as json to an endpoint on the backend.
   *
   * @param string $endpoint
   *    The name of the endpoint to send data to.
   * @param array $json
   *    The array data to send, will be json_encoded before sending.
   */
  public function sendArbitraryJson(string $endpoint, array $json = []) : void {
    $this->guzzle->post($endpoint, json_encode($json));
  }

}
