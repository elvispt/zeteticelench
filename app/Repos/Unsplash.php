<?php

namespace App\Repos;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Psr\SimpleCache\InvalidArgumentException;

class Unsplash
{
    protected $accessKey;
    protected $baseUri;
    protected $randomPhoto;

    protected $cacheKey = Unsplash::class;

    protected $cacheExpiration = 300; // 5 minutes

    public function __construct()
    {
        $this->baseUri = config('unsplash.base_uri');
        $this->randomPhoto = config('unsplash.random_photo_endpoint');
        $this->accessKey = config('unsplash.access_key');
    }

    public function getUnsplashFeaturedImage()
    {
        $photoUrl = Cache::get($this->cacheKey);

        if (empty($photoUrl)) {
            $photoUrl = $this->getFeaturedImage();
            try {
                Cache::set($this->cacheKey, $photoUrl, $this->cacheExpiration);
            } catch (InvalidArgumentException $exception) {
                Log::warning("Could not store photoUrl into cache");
            }
        }

        return $photoUrl;
    }

    protected function getFeaturedImage()
    {
        $photoUrl = null;
        $client = new Client([
            'base_uri' => $this->baseUri,
        ]);
        try {
            $response = $client->get($this->randomPhoto, [
                'headers' => [
                    'Accept-Version' => 'v1',
                    'Authorization' => 'Client-ID ' . $this->accessKey
                ],
                'query' => [
                    'featured' => 1,
                    'orientation' => 'portrait',
                    'query' => 'technology',
                ],
            ]);
        } catch (ClientException $exception) {
            Log::warning("Failed to get image from unsplash api");
        }
        if (!empty($response)) {
            $json = $response->getBody()->getContents();
            $obj = \GuzzleHttp\json_decode($json);
            $photoUrl = (Object) [
                'url' => data_get($obj, 'urls.full'),
                'bg' => data_get($obj, 'color'),
            ];
        }
        return $photoUrl;
    }
}
