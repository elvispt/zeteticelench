<?php

namespace App\Repos;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class Calendarific
{
    /**
     * @var string
     */
    protected $cacheKey = self::class;

    /**
     * 1 day expiration
     * @var int
     */
    protected $cacheExpiration = 86400;

    /**
     * @var string
     */
    protected $baseUri;

    /**
     * @var string
     */
    protected $endpoint;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var Client
     */
    protected $client;

    protected $holidays;

    public function __construct()
    {
        $this->baseUri = config('calendarific.base_uri');
        $this->endpoint = config('calendarific.holidays_endpoint');
        $this->apiKey = config('calendarific.api_key');
        $this->client = new Client([
            'base_uri' => $this->baseUri,
            'headers' => [
                'Accept: application/json',
            ],
        ]);
    }

    public function holidays(
        $year = null,
        $country = 'pt',
        $location = 'Madeira'
    ) {
        if ($this->holidays) {
            return $this->holidays;
        }
        $holidays = Cache::get($this->cacheKey);
        if (is_null($holidays)) {
            $holidays = $this->getHolidaysFromApi($year, $country, $location);
            if (!is_null($holidays)) {
                $holidays = data_get($holidays, 'response.holidays');
                Cache::set($this->cacheKey, $holidays, $this->cacheExpiration);
            }
        }
        $this->holidays = $holidays;
        return $this->holidays;
    }

    public function getNextHolidays($holidays = [], $length = 3)
    {
        $currentDateTime = Carbon::now();
        return (new Collection($holidays))
            ->filter(static function ($holiday) use ($currentDateTime) {
                $holidayDateTime = Carbon::make($holiday->date->iso);
                return $currentDateTime->lte($holidayDateTime);
            })
            ->slice(0, $length)
            ->toArray();
    }

    protected function getHolidaysFromApi(
        $year = null,
        $country = 'pt',
        $location = 'Madeira'
    ) {
        $year = $year ?: date('Y');
        $response = null;
        try {
            $response = $this->client->get($this->endpoint, [
                'query' => [
                    'api_key' => $this->apiKey,
                    'country' => $country,
                    'year' => $year,
                    'location' => $location,
                ],
            ]);
        } catch (ClientException $exception) {
            Log::warning(
                "Failed to make request to Calendarific endpoint",
                ['message' => $exception->getMessage()]
            );
        }
        if (is_null($response)) {
            return null;
        }
        $json = $response->getBody()->getContents();
        $holidays = null;
        try {
            $holidays = \GuzzleHttp\json_decode($json);
        } catch (InvalidArgumentException $exception) {
            Log::warning(
                "Could not parse Calendarific response",
                ['message' => $exception->getMessage()]
            );
        }
        return $holidays;
    }
}
