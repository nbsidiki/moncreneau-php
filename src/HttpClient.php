<?php

namespace Moncreneau;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Moncreneau\Exceptions\MoncreneauException;

class HttpClient
{
    private Client $client;

    public function __construct(string $apiKey, string $baseUrl = 'https://mc-prd.duckdns.org/api/v1', int $timeout = 30)
    {
        $this->client = new Client([
            'base_uri' => rtrim($baseUrl, '/'),
            'timeout' => $timeout,
            'headers' => [
                'X-API-Key' => $apiKey,
                'Content-Type' => 'application/json',
                'User-Agent' => 'moncreneau-php/1.0.0',
            ],
        ]);
    }

    public function get(string $path, array $params = []): array
    {
        try {
            $response = $this->client->get($path, ['query' => $params]);
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            $this->handleError($e);
        }
    }

    public function post(string $path, array $data = []): array
    {
        try {
            $response = $this->client->post($path, ['json' => $data]);
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            $this->handleError($e);
        }
    }

    public function delete(string $path): void
    {
        try {
            $this->client->delete($path);
        } catch (RequestException $e) {
            if ($e->getResponse()->getStatusCode() !== 204) {
                $this->handleError($e);
            }
        }
    }

    private function handleError(RequestException $e): void
    {
        if ($e->hasResponse()) {
            $body = json_decode($e->getResponse()->getBody(), true);
            $error = $body['error'] ?? ['code' => 'UNKNOWN_ERROR', 'message' => 'An error occurred'];
            throw new MoncreneauException($error, $e->getResponse()->getStatusCode());
        }
        throw $e;
    }
}
