<?php

namespace App\Service;


use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiService
{
    private $apiBaseUrl;
    private $client;

    public function __construct(HttpClientInterface $client, string $apiBaseUrl)
    {
        $this->client = $client;
        $this->apiBaseUrl = $apiBaseUrl;
    }

    public function getAlliances()
    {
        $response = $this->client->request('GET', $this->apiBaseUrl. '/alliances/');

        return $response->toArray();
    }

    public function getAllianceId($allianceId)
    {
        $response = $this->client->request('GET', $this->apiBaseUrl. '/alliances/'. $allianceId);

        return $response->toArray();
    }

    public function getAllianceCorporations($allianceId)
    {
        $response = $this->client->request('GET', $this->apiBaseUrl. '/alliances/'. $allianceId. '/corporations/');

        return $response->toArray();
    }
}