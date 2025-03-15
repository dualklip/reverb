<?php

namespace Laravel\Reverb\Protocols\Twilio\Http\Controllers;

use Laravel\Reverb\Servers\Twilio\Http\Connection;
use Laravel\Reverb\Servers\Twilio\Http\Response;
use Psr\Http\Message\RequestInterface;

class HealthCheckController extends Controller
{
    /**
     * Handle the request.
     */
    public function __invoke(RequestInterface $request, Connection $connection): Response
    {
        return new Response((object) ['health' => 'OK']);
    }
}
