<?php

namespace Chexwarrior;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * Grabs HTML from ILLiad account
 * 
 * @package Chexwarrior
 */
class Crawler
{
    public const LOGIN_URL = 'https://nypl.illiad.oclc.org/illiad/NYP/illiad.dll';

    public function __construct(?Client $client = null)
    {
        if (empty($client)) {
            $this->client = new Client();
        } else {
            $this->client = $client;
        }
    }

    public function makePost(string $username, string $password): string
    {
        /** @var ResponseInterface */
        $response = $this->client->request('POST', self::LOGIN_URL, [
            'form_params' => [
                'ILLiadForm' => 'Logon',
                'Username' => $username,
                'Password' => $password,
                'SubmitButton' => 'Logon to ILLiad',
            ],
        ]);

        return (string) $response->getBody();
    }
}
