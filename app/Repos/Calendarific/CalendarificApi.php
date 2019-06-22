<?php

namespace App\Repos\Calendarific;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;

class CalendarificApi
{
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

    public function __construct()
    {
        $this->baseUri = config('calendarific.base_uri');
        $this->endpoint = config('calendarific.holidays_endpoint');
        $this->apiKey = config('calendarific.api_key');
    }

    /**
     * Gets the holidays from the Calendarific API and parse the response
     *
     * @param string $year     Year of the holidays
     * @param string $country  Country of the holidays
     * @param string $location Location of the holidays
     * @return mixed|null
     */
    public function getHolidays(
        string $year,
        string $country,
        string $location
    ) {
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
