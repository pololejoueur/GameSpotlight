<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CheapSharkApiService
{
    private const BASE_URL = 'https://www.cheapshark.com/api/1.0';

    public function __construct(private HttpClientInterface $client) {}

    public function getTopDeals(int $limit = 10): array
    {
        $response = $this->client->request('GET', self::BASE_URL . '/deals', [
            'query' => [
                'pageSize' => $limit,
                'sortBy' => 'Deal Rating',
            ],
        ]);

        return $response->toArray();
    }

    public function searchGames(string $title): array
    {
        $response = $this->client->request('GET', self::BASE_URL . '/games', [
            'query' => ['title' => $title],
        ]);

        return $response->toArray();
    }
}
