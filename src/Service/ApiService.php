<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiService
{
	public function __construct(private HttpClientInterface $client) {}

    public function fetchQuizData(int $amount = 1): array
    {
        $url = sprintf('https://opentdb.com/api.php?amount=%d', $amount);

        $response = $this->client->request('GET', $url);

        $data = $response->toArray();

        return $data['results'] ?? [];
    }
}