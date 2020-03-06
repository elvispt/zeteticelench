<?php

namespace App\Libraries\Inspire;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;
use Psr\SimpleCache\InvalidArgumentException;

class Inspire
{
    protected $adviceSlipUrl = 'https://api.adviceslip.com/advice';

    protected $cacheKey = self::class;

    // 10 minutes
    protected $cacheTtl = 600;

    /**
     * Gets the advice slip from cache or from the API
     *
     * @return string Returns the advice splip
     */
    public function adviceSlip(): string
    {
        $advice = Cache::get($this->cacheKey);
        if (is_null($advice)) {
            $client = new Client();
            $response = null;
            try {
                $response = $client->get($this->adviceSlipUrl);
            } catch (ConnectException $exception) {
                Log::warning(
                    'Could not connect to advice slip api.',
                    ['eMessage' => $exception->getMessage()]
                );
            }
            if (! is_null($response)) {
                $advice = $this->parseResponse($response);
            }
        }

        return is_string($advice) ? $advice : '';
    }

    /**
     * @param ResponseInterface|null $response
     *
     * @return mixed
     */
    protected function parseResponse(?ResponseInterface $response)
    {
        $json = $response->getBody()->getContents();
        try {
            $obj = \GuzzleHttp\json_decode($json);
        } catch (\InvalidArgumentException $exception) {
            Log::warning(
                'Failed to parse json on Inspire quote',
                ['eMessage' => $exception->getMessage()]
            );
            $obj = null;
        }
        $advice = data_get($obj, 'slip.advice');
        try {
            Cache::set($this->cacheKey, $advice, $this->cacheTtl);
        } catch (InvalidArgumentException $exception) {
            Log::warning(
                'Could not store advice slip into cache',
                ['eMessage' => $exception->getMessage()]
            );
        }

        return $advice;
    }
}
