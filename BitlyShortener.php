<?php

namespace shortlink;

use GuzzleHttp\Client;

class BitlyShortener
{
    protected $accessToken;
    protected $httpClient;

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

    public function shortenUrl($longUrl,$group_guid ='Bo32cS4sOq6',$domain='bit.ly')
    {
        $response = $this->httpClient->post('shorten', [
            'json' => [
                'long_url' => $longUrl,
                'domain'=>$domain,
                'group_guid'=>$group_guid,
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        return $data['link'] ?? null;
    }
}
