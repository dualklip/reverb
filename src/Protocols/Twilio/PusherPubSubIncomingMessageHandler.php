<?php

namespace Laravel\Reverb\Protocols\Twilio;

use Laravel\Reverb\Protocols\Twilio\Contracts\ChannelManager;
use Laravel\Reverb\Servers\Twilio\Contracts\PubSubIncomingMessageHandler;

class PusherPubSubIncomingMessageHandler implements PubSubIncomingMessageHandler
{
    /**
     * Handle an incoming message from the PubSub provider.
     */
    public function handle(string $payload): void
    {
        $event = json_decode($payload, associative: true, flags: JSON_THROW_ON_ERROR);

        $application = unserialize($event['application']);

        $except = isset($event['socket_id']) ?
            app(ChannelManager::class)->for($application)->connections()[$event['socket_id']] ?? null
            : null;

        match ($event['type'] ?? null) {
            'message' => EventDispatcher::dispatchSynchronously(
                $application,
                $event['payload'],
                $except?->connection()
            ),
            'metrics' => app(MetricsHandler::class)->publish(
                $application,
                $event['key'],
                $event['payload']['type'],
                $event['payload']['options'] ?? []
            ),
            'terminate' => collect(app(ChannelManager::class)->for($application)->connections())
                ->each(function ($connection) use ($event) {
                    if ((string) $connection->data()['user_id'] === $event['payload']['user_id']) {
                        $connection->disconnect();
                    }
                }),
            default => null,
        };
    }
}
