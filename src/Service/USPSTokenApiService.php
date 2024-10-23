<?php

namespace App\Service;

use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class USPSTokenApiService
{

    protected $client;
    protected $clientId;
    protected $clientSecret;
    protected $oAuth2URL;
    protected $token;
    protected $cache;

    public function __construct(HttpClientInterface $client, CacheInterface $cache)
    {
        $this->client = $client;
        $this->cache = $cache;
        $this->clientId = $_ENV['USPS_CLIENT_ID'];
        $this->clientSecret = $_ENV['USPS_CLIENT_SECRET'];
        $this->oAuth2URL = $_ENV['USPS_OAUTH2_URL'];
    }

    /**
     * Obtiene el token de acceso desde el caché o solicita uno nuevo si ha expirado.
     */
    public function getAccessToken(): string
    {
        return $this->cache->get('usps_oauth_token', function ($item) {
            // Si el token no está en caché o ha expirado, solicitar uno nuevo
            $tokenData = $this->requestNewToken();
            
            // Configurar el tiempo de vida del token en caché
            $item->expiresAfter($tokenData['expires_in'] - 60); // 60 segundos de margen

            // Devolver el token para almacenarlo en caché
            return $tokenData['access_token'];
        });
    }

    /**
     * Solicita un nuevo token de acceso utilizando el flujo "client_credentials".
     */
    private function requestNewToken(): array
    {
        $response = $this->client->request('POST', $this->oAuth2URL, [
            'body' => [
                'grant_type' => $_ENV['USPS_GRANT_TYPE'],
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ],
        ]);

        return $response->toArray();
    }

    protected function getAuthHeaders(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->getAccessToken(),
            'Content-Type' => 'application/json',
        ];
    }
}
