<?php

namespace Laravel\Reverb\Servers\Twilio\Concerns;

use GuzzleHttp\Psr7\Message;
use GuzzleHttp\Psr7\Response;
use Laravel\Reverb\Servers\Twilio\Http\Connection;

trait ClosesConnections
{
    /**
     * Close the connection.
     */
    protected function close(Connection $connection, int $statusCode = 400, string $message = '', array $headers = []): void
    {
        $response = new Response($statusCode, $headers, $message);

        $connection->send(Message::toString($response));

        $connection->close();
    }
}
