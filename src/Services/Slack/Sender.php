<?php

namespace Workshop\Services\Slack;

use GuzzleHttp\Exception\GuzzleException;

class Sender
{
    public function __construct(private Service $service)
    {
    }

    /**
     * @throws GuzzleException
     */
    public function sendToSlack(string $message): bool
    {
        return $this->service->send($message);
    }
}
