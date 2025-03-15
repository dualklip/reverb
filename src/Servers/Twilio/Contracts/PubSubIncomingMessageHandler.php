<?php

namespace Laravel\Reverb\Servers\Twilio\Contracts;

interface PubSubIncomingMessageHandler
{
    /**
     * Handle an incoming message from the PubSub provider.
     */
    public function handle(string $payload): void;
}
