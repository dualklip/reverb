<?php

namespace Laravel\Reverb\Protocols\Twilio\Http\Controllers;

use Laravel\Reverb\Protocols\Pusher\Concerns\InteractsWithChannelInformation;
use Laravel\Reverb\Protocols\Pusher\MetricsHandler;
use Laravel\Reverb\Servers\Twilio\Http\Connection;
use Laravel\Reverb\Servers\Twilio\Http\Response;
use Psr\Http\Message\RequestInterface;
use React\Promise\PromiseInterface;

class ChannelUsersController extends Controller
{
    use InteractsWithChannelInformation;

    /**
     * Handle the request.
     */
    public function __invoke(RequestInterface $request, Connection $connection, string $channel, string $appId): Response|PromiseInterface
    {
        $this->verify($request, $connection, $appId);

        $channel = $this->channels->find($channel);

        if (! $channel) {
            return new Response((object) [], 404);
        }

        if (! $this->isPresenceChannel($channel)) {
            return new Response((object) [], 400);
        }

        return app(MetricsHandler::class)
            ->gather($this->application, 'channel_users', ['channel' => $channel->name()])
            ->then(fn ($connections) => new Response(['users' => $connections]));
    }
}
