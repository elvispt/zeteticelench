<?php

namespace App\Repos;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Psr\SimpleCache\InvalidArgumentException as
    SimpleCacheInvalidArgumentException;

class Calendarific
{
    /**
     * @var string
     */
    protected $cacheKey = self::class;

    /**
     * 1 day expiration
     *
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
     * @var array
     */
    protected $holidays;

    public function __construct()
    {
        $this->baseUri = config('calendarific.base_uri');
        $this->endpoint = config('calendarific.holidays_endpoint');
        $this->apiKey = config('calendarific.api_key');
    }

    /**
     * Gets the holidays for the given country and year
     *
     * @param string|null $year     Optional. The year of the holidays.
     * @param string      $country  Optional. The country code.
     * @param string      $location Optional. The region name.
     * @return array Returns the holidays
     */
    public function holidays(
        ?string $year = null,
        string $country = 'pt',
        string $location = 'Madeira'
    ) {
        if ($this->holidays) {
            return $this->holidays;
        }
        $holidays = Cache::get($this->cacheKey);
        if (is_null($holidays)) {
            $holidays = $this->getHolidaysFromApi($year, $country, $location);
            $holidays = data_get($holidays, 'response.holidays');
            try {
                Cache::set($this->cacheKey, $holidays, $this->cacheExpiration);
            } catch (SimpleCacheInvalidArgumentException $exception) {
                Log::error(
                    "Failed to store holidays on cache",
                    ['eMessage' => $exception->getMessage()]
                );
            }
        }
        $this->holidays = $holidays;

        return $this->holidays;
    }

    /**
     * Gets the next $length holidays based on current date/time.
     *
     * @param array $holidays The holidays list
     * @param int   $length   The number of next holidays to obtain
     * @return array Returns the next holidays
     */
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

    /**
     * Gets the holidays from the Calendarific API and parse the response
     *
     * @param null   $year     Year of the holidays
     * @param string $country  Country of the holidays
     * @param string $location Location of the holidays
     * @return mixed|null
     */
    protected function getHolidaysFromApi(
        $year = null,
        $country = 'pt',
        $location = 'Madeira'
    ) {
        $year = $year ? $year : date('Y');
        $response = $this->holidaysApiRequest($year, $country, $location);

        return $this->parseApiResponse($response);
    }

    /**
     * Make the request to the Calendarific API endpoint
     *
     * @param string $year     Year of the holidays
     * @param string $country  Country of the holidays
     * @param string $location The location of the holidays
     * @return ResponseInterface|null Returns the response from the API
     */
    protected function holidaysApiRequest(
        string $year,
        string $country,
        string $location
    ) {
        $response = null;
        try {
            $client = new Client([
                'base_uri' => $this->baseUri,
                'headers' => [
                    'Accept: application/json',
                ],
            ]);
            $response = $client->get($this->endpoint, [
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

        return $response;
    }

    /**
     * Parses the calendarific api response
     *
     * @param ResponseInterface|null $response The response from the API.
     * @return mixed|null Returns the parsed response from the API
     */
    protected function parseApiResponse(?ResponseInterface $response = null)
    {
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
                ['eMessage' => $exception->getMessage()]
            );
        }

        return $holidays;
    }
}
