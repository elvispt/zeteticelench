<?php

namespace App\Repos;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;
use Psr\SimpleCache\InvalidArgumentException;

class Unsplash
{
    protected $accessKey;
    protected $baseUri;
    protected $randomPhoto;

    protected $cacheKey = Unsplash::class;

    protected $cacheExpiration = 330; // 5 minutes

    public function __construct()
    {
        $this->baseUri = config('unsplash.base_uri');
        $this->randomPhoto = config('unsplash.random_photo_endpoint');
        $this->accessKey = config('unsplash.access_key');
    }

    public function getUnsplashFeaturedImage($forceCacheRefresh = false)
    {
        $photoUrl = Cache::get($this->cacheKey);

        if (is_null($photoUrl) || $forceCacheRefresh) {
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
        $response = null;
        try {
            $response = $client->get($this->randomPhoto, [
                'headers' => $this->headers(),
                'query' => $this->query(),
            ]);
        } catch (ClientException $exception) {
            Log::warning("Failed to get image from unsplash api");
        }
        if ($response) {
            $photoUrl = $this->getImageFromResponse($response);
        }

        return $photoUrl;
    }

    /**
     * @param ResponseInterface $response
     * @return object
     */
    protected function getImageFromResponse(ResponseInterface $response)
    {
        $json = $response->getBody()->getContents();
        $obj = \GuzzleHttp\json_decode($json);
        return (object) [
            'url' => data_get($obj, 'urls.full'),
            'bg' => data_get($obj, 'color'),
        ];
    }

    protected function headers()
    {
        return [
            'Accept-Version' => 'v1',
            'Authorization' => 'Client-ID ' . $this->accessKey,
        ];
    }

    protected function query()
    {
        return [
            'featured' => 1,
            'orientation' => 'portrait',
            'query' => 'technology',
        ];
    }
}
