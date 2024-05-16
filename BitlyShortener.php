<?php

namespace shortlink;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class BitlyShortener
{
    protected $accessToken;
    protected $httpClient;
    protected $qrHttpRequest;
    const CONFLICT = 409;
    const API_USAGE_LIMIT_EXCEEDED = 409;

    public function __construct($accessToken)
    {
        $this->accessToken = $accessToken;
        $this->httpClient = new Client([
            'base_uri' => 'https://api-ssl.bitly.com/v4/shorten',
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /**
     * Generate a short URl from the long Url
     */
    public function shortenUrl($longUrl, $group_guid = 'Bo32cS4sOq6', $domain = 'bit.ly'): string
    {
        try {
            $response = $this->httpClient->post('shorten', [
                'json' => [
                    'long_url' => $longUrl,
                    'domain' => $domain,
                    'group_guid' => $group_guid,
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            return $data['link'] ?? null;
        } catch (RequestException $exception) {
            if ($exception->getResponse()->getStatusCode() === self::API_USAGE_LIMIT_EXCEEDED) {
                $nextTry = $exception->getResponse()->getHeader('Retry-After');

                sleep((int)$nextTry);

                return $this->shortenUrl($longUrl);
            }

            throw $exception;
        }
    }

    /**
     * Generate a base64 code for QR code from short URl 
     */
    public function generateQR(string $logoUrl): string
    {
        $shortUrl = $this->shortenUrl($logoUrl);

        $shortUrl =  str_replace('https://bit.ly/', '', $shortUrl);

        $httpClient = new Client([
            'base_uri' => 'https://api-ssl.bitly.com/v4/bitlinks/bit.ly/' . $shortUrl . '/',
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Content-Type' => 'application/json',
            ],
        ]);

        try {
            $response = $httpClient->post('qr', [
                'json' => [
                    'is_hidden' => true
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            return $data['qr_code'] ?? null;
        } catch (RequestException $exception) {
            if ($exception->getResponse()->getStatusCode() === self::CONFLICT) {
                $httpClient1 = new Client([
                    'base_uri' => 'https://api-ssl.bitly.com/v4/bitlinks/bit.ly/' . $shortUrl . '/',
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->accessToken,
                        'Content-Type' => 'application/json',
                    ],
                ]);

                $response1 = $httpClient1->get('qr?image_format=png');

                $data = json_decode($response1->getBody()->getContents(), true);

                return $data['qr_code'] ?? null;
            }

            throw $exception;
        }
    }
}
