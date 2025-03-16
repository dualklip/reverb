<?php

namespace Laravel\Reverb;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Manager;
use Laravel\Reverb\Servers\Reverb\ReverbServerProvider;
use Laravel\Reverb\Servers\Twilio\TwilioServerProvider;

class ServerProviderManager extends Manager
{
    /**
     * Create a new server manager instance.
     */
    public function __construct(protected Application $app)
    {
        parent::__construct($app);
    }

    /**
     * Creates the Reverb driver.
     */
    public function createReverbDriver(): ReverbServerProvider
    {
        return new ReverbServerProvider(
            $this->app,
            $this->config->get('reverb.servers.reverb', [])
        );
    }

    /**
     * Creates the Twilio driver.
     */
    public function createTwilioDriver(): TwilioServerProvider
    {
        return new TwilioServerProvider(
            $this->app,
            $this->config->get('reverb.servers.twilio', [])
        );
    }

    /**
     * Get the default driver name.
     */
    public function getDefaultDriver(): string
    {
        return $this->config->get('reverb.default', 'reverb');
    }
}
