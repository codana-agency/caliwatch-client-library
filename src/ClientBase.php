<?php declare(strict_types=1);

namespace calibrate\caliwatch\client;

use calibrate\caliwatch\client\Exception\InvalidTokenException;
use GuzzleHttp\Client;

/**
 * Contains the base implementations to send data to caliwatch.
 */
abstract class ClientBase
{

    /**
     * The guzzle client.
     *
     * @var \GuzzleHttp\Client
     */
    private $guzzle;

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
    public function sendTrigger(string $message, string $type = 'error') : void
    {
        $contents = ['type' => $type, 'message' => $message];
        $this->sendArbitraryJson('/api/trigger', $contents);
    }

    /**
     * Send an event to caliwatch.
     *
     * Events are things that are monitored and can trigger automatic slack
     * messages/notifications. These are all handled by the caliwatch server.
     *
     * @param string $eventName
     *   The name of the event we're updating for.
     * @param mixed $value
     *   The value of this event.
     */
    public function sendEvent(string $eventName, $value) : void
    {
        $contents = ['event' => $eventName, 'value' => $value];
        $this->sendArbitraryJson('/api/event', $contents);
    }

    /**
     * Send arbitrary data as json to an endpoint on the backend.
     *
     * @param string $endpoint
     *   The name of the endpoint to send data to.
     * @param array $json
     *   The array data to send, will be json_encoded before sending.
     */
    public function sendArbitraryJson(string $endpoint, array $json = []) : void
    {
        try {
          $this->getTransport()
            ->post($endpoint, ['body' => json_encode($json)]);
        } catch (\Exception $e) {
          // When an exception happens, we should just silently fail instead of
          // letting the exception bubble up.
        }
    }

    /**
     * Gets the transport (guzzle), for sending data to remote.
     *
     * Throws an error when CALIWATCH_TOKEN can not be found in the environment
     * variables. For settings this token, open settings.local.php (or another
     * settings file) and use `putenv('CALIWATCH_TOKEN=token');` to set the
     * token.
     */
    protected function getTransport() : Client
    {
        // Guzzle has already been created and statically cached, so return it.
        if ($this->guzzle !== null) {
            return $this->guzzle;
        }

        $token = getenv('CALIWATCH_TOKEN');
        if ($token === false || strlen($token) === 0) {
            throw new InvalidTokenException("No CALIWATCH_TOKEN found in environment variables, use putenv to set one");
        }
        $this->guzzle = new Client([
            'base_uri' => 'http://caliwatch-2.calidev.in/',
            'timeout' => 0,
            'allow_redirects' => false,
            'headers' => ['Caliwatch-Token' => $token],
        ]);

        return $this->guzzle;
    }
}
