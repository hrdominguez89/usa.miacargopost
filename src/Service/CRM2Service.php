<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CRM2Service
{
    public function __construct(private readonly HttpClientInterface $client, private readonly LoggerInterface $logger)
    {
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    public function patchCustomer(string $cId, array $data): array
    {
        try {

            $url = $_ENV['CRM2_URL'].'/customer/'.$cId;

            $response = $this->client->request('PATCH', $url, [
                'timeout' => 10,
                'headers' => [
                    'Authorization: Basic '.$_ENV['CRM2_AUTH_BASIC'],
                ],
                'json' => $data,
            ]);

            $this->logger->info('PATCH_CUSTOMER_TO_STORE_SUCCESS', [$response->getStatusCode(), $response->toArray()]);

            return [$response->getStatusCode(), $response->toArray()];

        } catch (\Exception|DecodingExceptionInterface|TransportExceptionInterface $e) {

            $this->logger->critical(
                'PATCH_CUSTOMER_TO_STORE_ERROR_CRITICAL_0', array_merge(['data_send' => $data, 'code' => $e->getCode(), 'message_error' => $e])
            );

            return [$e->getCode(), $e->getMessage()];
        }

    }

    /** @noinspection PhpUnhandledExceptionInspection */
    public function patchOrder($orderId, array $data): array
    {

        try {

            $url = $_ENV['CRM2_URL'].'/order/'.$orderId;

            $response = $this->client->request('PATCH', $url, [
                'timeout' => 10,
                'headers' => [
                    'Authorization: Basic '.$_ENV['CRM2_AUTH_BASIC'],
                ],
                'json' => $data,
                
            ]);

            $this->logger->info('PATCH_ORDEN_TO_STORE_SUCCESS', [$response->getStatusCode(), $response->toArray()]);

            return [$response->getStatusCode(), $response->toArray()];

        } catch (\Exception|DecodingExceptionInterface|TransportExceptionInterface $e) {

            $this->logger->critical(
                'PATCH_ORDEN_TO_STORE_ERROR_CRITICAL_0', array_merge(['data_send' => $data, 'code' => $e->getCode(), 'message_error' => $e])
            );

            return [$e->getCode(), $e->getMessage()];
        }

    }

    /** @noinspection PhpUnhandledExceptionInspection */
    public function getOrder($orderId): array
    {

        try {

            $url = $_ENV['CRM2_URL'].'/order/'.$orderId;

            $response = $this->client->request('GET', $url, [
                'timeout' => 10,
                'headers' => [
                    'Authorization: Basic '.$_ENV['CRM2_AUTH_BASIC'],
                ]
            ]);

            $this->logger->info('GET_ORDEN_TO_STORE_SUCCESS', [$response->getStatusCode(), $response->toArray()]);

            return [$response->getStatusCode(), $response->toArray()];

        } catch (\Exception|DecodingExceptionInterface|TransportExceptionInterface $e) {

            $this->logger->critical(
                'GET_ORDEN_TO_STORE_ERROR_CRITICAL_0', array_merge(['code' => $e->getCode(), 'message_error' => $e])
            );

            return [$e->getCode(), $e->getMessage()];
        }

    }

}