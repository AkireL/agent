<?php

namespace App\SDK\Services\Ollama;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class OllamaClient
{
    private Client $guzzleClient;

    public function __construct(
        private readonly string $host,
        string $apiKey = '',
    )
    {
        $this->guzzleClient = new Client([
            'base_uri' => "$host/api/",
            'headers' => [
                'Authorization' => "Bearer $apiKey",
            ],
        ]);
    }

    public function isRunning(): bool
    {
        try {
            $client = new Client(['base_uri' => $this->host]);
            $res = $client->get('/');
            $content = $res->getBody()->getContents();

            return $content === 'Ollama is running';
        } catch (GuzzleException $ex) {
            return false;
        }
    }

    public function get($endpoint, $parameters = [], $parseJson = true)
    {
        $response = $this->guzzleClient->get($endpoint, [
            'query' => $parameters,
        ]);

        if (!$parseJson) return $response;

        return json_decode($response->getBody(), true);
    }

    public function post($endpoint, $parameters = [], $stream = false, $parseJson = true)
    {
        $response = $this->guzzleClient->post($endpoint, [
            'json' => [
                ...$parameters,
                'stream' => $stream,
            ],
            'stream' => $stream,
        ]);

        if ($stream || !$parseJson) return $response;

        return json_decode($response->getBody(), true);
    }
}
