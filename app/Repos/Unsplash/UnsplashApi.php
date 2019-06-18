<?php

namespace App\Repos\Unsplash;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;

class UnsplashApi
{
    protected $accessKey;
    protected $baseUri;
    protected $randomPhoto;

    public function __construct()
    {
        $this->baseUri = config('unsplash.base_uri');
        $this->randomPhoto = config('unsplash.random_photo_endpoint');
        $this->accessKey = config('unsplash.access_key');
    }

    /**
     * Gets a featured image from the Unsplash API
     *
     * @return object|null Returns the path (url) to the unsplash image and a
     *                     background color to use
     */
    public function getFeaturedImage()
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
     * Parses the response to obtain path and background color
     *
     * @param ResponseInterface $response The response object from the API
     * @return object|null Returns the path (url) to the unsplash image and a
     *                     background color to use
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

    /**
     * Defines the headers for the request
     */
    protected function headers()
    {
        return [
            'Accept-Version' => 'v1',
            'Authorization' => 'Client-ID ' . $this->accessKey,
        ];
    }

    /**
     * Defines the query params for the request
     */
    protected function query()
    {
        return [
            'featured' => 1,
            'orientation' => 'portrait',
            'query' => 'technology',
        ];
    }
}
