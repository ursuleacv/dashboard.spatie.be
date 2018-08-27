<?php

namespace App\Services\Instagram;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;

class SpatieInstagramApi implements InstagramApi
{
    const API_URL = 'https://spatie.be/api/instagram-photos';

    /** @var Client */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
    
    public function getAll(): Collection
    {
        $response = $this->client->get(static::API_URL);

        $photos = json_decode((string) $response->getBody(), true);

        return collect($photos['data']);
    }
}
