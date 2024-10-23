<?php

namespace App\Service;

use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class USPSDomesticPricesApiService extends USPSTokenApiService
{

    private $domesticPricesApiUrl;

    public function __construct(HttpClientInterface $client, CacheInterface $cache)
    {
        parent::__construct($client, $cache);
        $this->domesticPricesApiUrl = $_ENV['USPS_DOMESTIC_PRICES_URL'];
    }


    public function getBaseRates(array $data): array
    {

        if (isset($data['mailingDate']) && $data['mailingDate'] instanceof \DateTimeInterface) {
            $data['mailingDate'] = $data['mailingDate']->format('Y-m-d'); // Formato yyyy-mm-dd
        }

        // Filtrar los valores nulos del array
        $data = array_filter($data, function ($value) {
            return $value !== null;
        });


        try {
            // Hacer la solicitud POST con los datos proporcionados
            $response = $this->client->request('POST', $this->domesticPricesApiUrl . '/base-rates/search', [
                'headers' => $this->getAuthHeaders(),
                'json' => $data, // Los datos se envían como JSON en el cuerpo
            ]);

            return $response->toArray(); // Convertir la respuesta JSON a array PHP
        } catch (ClientExceptionInterface $e) {
            // Manejar errores de solicitud (errores 4xx como 400, 404, etc.)
            return [
                'error' => 'Solicitud incorrecta: ' . $e->getMessage(),
                'status_code' => $e->getCode(),
            ];
        } catch (TransportExceptionInterface $e) {
            // Manejar errores de transporte (problemas de conexión, etc.)
            return [
                'error' => 'Error de transporte: ' . $e->getMessage(),
                'status_code' => $e->getCode(),
            ];
        }
    }
}
