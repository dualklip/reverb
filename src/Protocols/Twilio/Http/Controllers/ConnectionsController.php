<?php

namespace Laravel\Reverb\Protocols\Twilio\Http\Controllers;

use Laravel\Reverb\Protocols\Twilio\MetricsHandler;
use Laravel\Reverb\Servers\Twilio\Http\Connection;
use Laravel\Reverb\Servers\Twilio\Http\Response;
use Psr\Http\Message\RequestInterface;
use React\Promise\PromiseInterface;

class ConnectionsController extends Controller
{
    /**
     * Handle the request.
     */
    public function __invoke(RequestInterface $request, Connection $connection, string $appId): PromiseInterface
    {
        $this->verify($request, $connection, $appId);

        return app(MetricsHandler::class)->gather($this->application, 'connections')
            ->then(fn ($connections) => new Response(['connections' => count($connections)]));
    }
}
