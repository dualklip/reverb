<?php

namespace Laravel\Reverb\Protocols\Twilio\Http\Controllers;

use Laravel\Reverb\Protocols\Twilio\MetricsHandler;
use Laravel\Reverb\Servers\Twilio\Http\Connection;
use Laravel\Reverb\Servers\Twilio\Http\Response;
use Psr\Http\Message\RequestInterface;
use React\Promise\PromiseInterface;

class ChannelController extends Controller
{
    /**
     * Handle the request.
     */
    public function __invoke(RequestInterface $request, Connection $connection, string $appId, string $channel): PromiseInterface
    {
        $this->verify($request, $connection, $appId);

        return app(MetricsHandler::class)->gather($this->application, 'channel', [
            'channel' => $channel,
            'info' => isset($this->query['info']) ? $this->query['info'].',occupied' : 'occupied',
        ])->then(fn ($channel) => new Response((object) $channel));
    }
}
