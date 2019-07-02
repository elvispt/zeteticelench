<?php

namespace App\View\Composers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Psr\Http\Message\ResponseInterface;
use Psr\SimpleCache\InvalidArgumentException;

class InspireComposer
{
    protected $adviceSlipUrl = 'https://api.adviceslip.com/advice';

    protected $cacheKey = 'advice_slip_json_apis';

    protected $cacheExpiration = 120; // 2 minutes

    public function compose(View $view)
    {
        $__inspire = $this->adviceSlip();
        $view->with('__inspire', $__inspire);
    }

    /**
     * Gets the advice slip from cache or from the API
     *
     * @return string Returns the advice splip
     */
    protected function adviceSlip(): string
    {
        $advice = Cache::get($this->cacheKey);
        if (is_null($advice)) {
            $client = new Client();
            $response = null;
            try {
                $response = $client->get($this->adviceSlipUrl);
            } catch (ConnectException $exception) {
                Log::warning(
                    "Could not connect to advice slip api.",
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
     * @return mixed
     */
    protected function parseResponse(?ResponseInterface $response) {
        $json = $response->getBody()->getContents();
        $obj = \GuzzleHttp\json_decode($json);
        $advice = data_get($obj, 'slip.advice');
        try {
            Cache::set($this->cacheKey, $advice, $this->cacheExpiration);
        } catch (InvalidArgumentException $exception) {
            Log::warning(
                "Could not store advice slip into cache",
                ['eMessage' => $exception->getMessage()]
            );
        }

        return $advice;
}
}
