<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class InventaryService
{
    private ?HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param array $data
     * @return array
     * @throws DecodingExceptionInterface
     * @throws TransportExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     */
    public function createSaleOrder(array $data): array
    {
        $url = $_ENV['INVENTARY_URL'].'/saleOrder/create';

        $token = $this->inventoryLogin();

        $response = $this->client->request('POST', $url, [
            'timeout' => 10,
            'headers' => [
                'Authorization: Bearer '.$token['access_token'],
            ],
            'json' => $data,
        ]);

        return $response->toArray();
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    public function inventoryLogin(): array
    {

        $url = $_ENV['INVENTARY_URL'].'/login';

        $response = $this->client->request('POST', $url, [
            'timeout' => 10,
            'body' => ['email' => $_ENV['INVENTARY_USERNAME'], 'password' => $_ENV['INVENTARY_PASSWORD']],
        ]);

        return $response->toArray();

    }

    /** @noinspection PhpUnhandledExceptionInspection */
    public function confirmOrder($oInventaryId): array
    {

        $url = $_ENV['INVENTARY_URL'].'/saleOrder/confirm/'.$oInventaryId;

        $token = $this->inventoryLogin();

        $response = $this->client->request('GET', $url, [
            'timeout' => 10,
            'headers' => [
                'Authorization: Bearer '.$token['access_token'],
            ],
        ]);

        return $response->toArray();

    }
}