<?php

namespace App\Repos\Unsplash;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;

class UnsplashApi
{
    protected $accessKey;
    protected $baseUri;
    protected $randomPhoto;
    protected $query;
    protected $headers;

    public function __construct(
        array $query = null,
        array $headers = null,
        string $accessKey = null
    ) {
        $this->baseUri = config('unsplash.base_uri');
        $this->randomPhoto = config('unsplash.random_photo_endpoint');
        $this->accessKey = $accessKey
            ? $accessKey
            : config('unsplash.access_key');
        $this->query = $this->query($query);
        $this->headers = $this->headers($headers);
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
                'headers' => $this->headers,
                'query' => $this->query,
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
     *
     * @param array|null $headers
     * @return array
     */
    protected function headers(array $headers = null)
    {
        $defaults = [
            'Accept-Version' => 'v1',
            'Authorization' => 'Client-ID ' . $this->accessKey,
        ];
        if (is_array($headers)) {
            return array_merge($defaults, $headers);
        }
        return $defaults;
    }

    /**
     * Defines the query params for the request
     *
     * @param array|null $query
     * @return array
     */
    protected function query(array $query = null): array
    {
        $searchTerm = Arr::random(config('unsplash.search_query_values'));
        $defaults = [
            'featured' => 1,
            'orientation' => 'portrait',
            'query' => $searchTerm,
        ];
        if (is_array($query)) {
            return array_merge($defaults, $query);
        }
        return $defaults;
    }
}
