<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PriceConverter
{
    public function __construct(private HttpClientInterface $httpClient)
    {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws \Exception
     */
    public function convertEur(float $euroPrice, string $monnaie ): string
    {
        $response = $this->httpClient->request('GET',
            'https://v6.exchangerate-api.com/v6/61e381bdc05b177c9f01b770/pair/EUR/' . $monnaie);
        if ($response->getStatusCode() === 200) {
            $conversion = $response->toArray()['conversion_rate'];
        return number_format( $euroPrice * $conversion, 2);
        }
        throw new \Exception('Api ne fonctionne pas');
    }
}