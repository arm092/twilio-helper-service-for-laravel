<?php


namespace App\Helpers;


use App\Models\User;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

class TwilioSmsServiceHelper
{
    /** @var Client */
    private $client;

    /** @var TwilioSmsServiceHelper */
    private static $instance = null;

    /**
     * TwilioSmsServiceHelper constructor.
     * Create Client instance
     *
     * @param  string  $sid
     * @param  string  $token
     */
    public function __construct($sid, $token)
    {
        try {
            $this->client = new Client($sid, $token);
        } catch (\Twilio\Exceptions\ConfigurationException $exception) {
            Log::error($exception->getMessage());
            $this->client = null;
        }
    }

    /**
     * Initialisation of the class
     *
     * @return TwilioSmsServiceHelper
     */
    public static function init()
    {
        return self::$instance ?? (self::$instance = new TwilioSmsServiceHelper(config('services.twilio.sid'),
                config('services.twilio.token')));
    }

    /**
     * Get the instance of the class
     *
     * @return TwilioSmsServiceHelper|string|null
     * @throws \Twilio\Exceptions\ConfigurationException
     */
    public function getInstance()
    {
        return self::init();
    }

    /**
     * @param  User|string  $user
     * @param  string  $message
     *
     * @return bool
     */
    public function sms($user, $message)
    {
        if ($this->client) {
            $from = config('services.twilio.number');
            $to   = $user instanceof User ? $user->phone_number : str_replace(' ', '', $user);
            try {
                $this->client->messages->create($to, [
                    'from' => $from,
                    'body' => $message,
                ]);

                return true;
            } catch (\Twilio\Exceptions\TwilioException $exception) {
                Log::error($exception->getMessage());

                return false;
            }
        }

        return false;
    }
}
