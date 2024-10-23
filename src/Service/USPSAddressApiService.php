<?php

namespace App\Service;

use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class USPSAddressApiService extends USPSTokenApiService
{

    private $addressApiUrl;

    public function __construct(HttpClientInterface $client, CacheInterface $cache)
    {
        parent::__construct($client, $cache);
        $this->addressApiUrl = $_ENV['USPS_ADDRESS_URL'];
    }


    public function getAddress(array $address): array
    {
        $queryParams = array_filter([
            'firm' => $address['firm'] ?? null,
            'streetAddress' => $address['streetAddress'] ?? null,
            'secondaryAddress' => $address['secondaryAddress'] ?? null,
            'city' => $address['city'] ?? null,
            'state' => $address['state'] ?? null,
            'urbanization' => $address['urbanization'] ?? null,
            'ZIPCode' => $address['ZIPCode'] ?? null,
            'ZIPPlus4' => $address['ZIPPlus4'] ?? null
        ], function($value) {
            return !is_null($value) && $value !== ''; // Excluir valores vacíos
        });

        $queryString = http_build_query($queryParams);

        try {
            // Realizar la solicitud GET
            $response = $this->client->request('GET', $this->addressApiUrl . '/address?' . $queryString, [
                'headers' => $this->getAuthHeaders(),
            ]);

            return $response->toArray();
        } catch (ClientExceptionInterface $e) {
            // Manejar errores 4xx (como 400 Bad Request)
            return [
                'error' => 'Solicitud incorrecta: ' . $e->getMessage(),
                'status_code' => $e->getCode(),
            ];
        } catch (TransportExceptionInterface $e) {
            // Manejar errores de transporte (problemas con la conexión, etc.)
            return [
                'error' => 'Error de transporte: ' . $e->getMessage(),
                'status_code' => $e->getCode(),
            ];
        }

        return $response->toArray();
    }


    public function getCityAndState(array $address): array
    {
        $queryParams = array_filter([
            'ZIPCode' => $address['ZIPCode'] ?? null,
        ], function($value) {
            return !is_null($value) && $value !== ''; // Excluir valores vacíos
        });

        $queryString = http_build_query($queryParams);

        try {
            // Realizar la solicitud GET
            $response = $this->client->request('GET', $this->addressApiUrl . '/city-state?' . $queryString, [
                'headers' => $this->getAuthHeaders(),
            ]);

            return $response->toArray();
        } catch (ClientExceptionInterface $e) {
            // Manejar errores 4xx (como 400 Bad Request)
            return [
                'error' => 'Solicitud incorrecta: ' . $e->getMessage(),
                'status_code' => $e->getCode(),
            ];
        } catch (TransportExceptionInterface $e) {
            // Manejar errores de transporte (problemas con la conexión, etc.)
            return [
                'error' => 'Error de transporte: ' . $e->getMessage(),
                'status_code' => $e->getCode(),
            ];
        }

        return $response->toArray();
    }


    public function getZipCode(array $address): array
    {
        $queryParams = array_filter([
            'firm' => $address['firm'] ?? null,
            'streetAddress' => $address['streetAddress'] ?? null,
            'secondaryAddress' => $address['secondaryAddress'] ?? null,
            'city' => $address['city'] ?? null,
            'state' => $address['state'] ?? null,
            'urbanization' => $address['urbanization'] ?? null,
            'ZIPCode' => $address['ZIPCode'] ?? null,
            'ZIPPlus4' => $address['ZIPPlus4'] ?? null
        ], function($value) {
            return !is_null($value) && $value !== ''; // Excluir valores vacíos
        });

        $queryString = http_build_query($queryParams);

        try {
            // Realizar la solicitud GET
            $response = $this->client->request('GET', $this->addressApiUrl . '/zipcode?' . $queryString, [
                'headers' => $this->getAuthHeaders(),
            ]);

            return $response->toArray();
        } catch (ClientExceptionInterface $e) {
            // Manejar errores 4xx (como 400 Bad Request)
            return [
                'error' => 'Solicitud incorrecta: ' . $e->getMessage(),
                'status_code' => $e->getCode(),
            ];
        } catch (TransportExceptionInterface $e) {
            // Manejar errores de transporte (problemas con la conexión, etc.)
            return [
                'error' => 'Error de transporte: ' . $e->getMessage(),
                'status_code' => $e->getCode(),
            ];
        }

        return $response->toArray();
    }
}
