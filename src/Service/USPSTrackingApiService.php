<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class USPSTrackingApiService extends USPSTokenApiService
{

    private $trackingApiUrl;

    public function __construct(HttpClientInterface $client)
    {
        parent::__construct($client);
        $this->trackingApiUrl = $_ENV['USPS_TRACKING_URL'];
    }


    public function validateAddress(array $address): array
    {
        $response = $this->client->request('POST', $this->trackingApiUrl, [
            'headers' => $this->getAuthHeaders(), // Usa los headers con el token de la clase base
            'json' => [
                'address' => $address
            ],
        ]);

        return $response->toArray();
    }
}
