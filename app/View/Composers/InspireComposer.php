<?php

namespace App\View\Composers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
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

    protected function adviceSlip(): string
    {
        $advice = Cache::get($this->cacheKey);
        if (empty($advice)) {
            $client = new Client();
            $response = $client->get($this->adviceSlipUrl);
            $json = $response->getBody()->getContents();
            $obj = \GuzzleHttp\json_decode($json);
            $advice = data_get($obj, 'slip.advice');
            try {
                Cache::set($this->cacheKey, $advice, $this->cacheExpiration);
            } catch (InvalidArgumentException $exception) {
                Log::warning("Could not store advice slip into cache");
            }
        }

        return $advice;
    }
}
