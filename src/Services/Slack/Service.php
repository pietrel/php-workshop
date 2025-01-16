<?php

namespace Workshop\Services\Slack;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Service
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $_ENV['SLACK_URL'],
        ]);
    }

    /**
     * @throws GuzzleException
     */
    public function send(string $message): bool
    {
        $response = $this->client->post('', [
            'json' => [
                'text' => $message,
            ],
        ]);

        return ($response->getStatusCode() == 200);
    }
}
