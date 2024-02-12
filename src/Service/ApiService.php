<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiService
{
	private const API_URL = 'https://opentdb.com';
	private const CATEGORIES_ENDPOINT = '/api_category.php';
	private const QUIZ_DATA_ENDPOINT = '/api.php';

	public function __construct(private HttpClientInterface $client, private string $apiUrl = self::API_URL) {}

	private function performApiRequest(string $endpoint, array $params = []): array
	{
		$url = sprintf('%s%s', $this->apiUrl, $endpoint);

		try {
			$response = $this->client->request('GET', $url, ['query' => $params]);

			$data = $response->toArray();

			return $data ?? [];
		} catch (\Exception $e) {
			// @todo
			return [];
		}
	}

	public function fetchQuizCategories(): array
	{
		return $this->performApiRequest(self::CATEGORIES_ENDPOINT)['trivia_categories'];
	}

	public function fetchQuizData(int $amount = 1): array
	{
		return $this->performApiRequest(self::QUIZ_DATA_ENDPOINT, ['amount' => $amount])['results'];
	}
}