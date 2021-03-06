<?php

namespace App\Libraries\Reddit;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;

class GameDealsFree
{
    protected string $baseUri = 'https://api.reddit.com/r/';
    protected string $searchUri = 'GameDeals/new';

    public function getDeals(): Collection
    {
        $response = $this->makeRequest();

        if (!is_null($response)) {
            return new Collection($this->getBodyContents($response));
        }
        return new Collection();
    }

    protected function getBodyContents(ResponseInterface $response)
    {
        $json = $response->getBody()->getContents();
        try {
            $gameDeals = \GuzzleHttp\json_decode($json);
        } catch (InvalidArgumentException $exception) {
            Log::error(
                'Could not decode live data endpoint json response',
                ['eMessage' => $exception->getMessage()]
            );
            $gameDeals = [];
        }

        return data_get($gameDeals, 'data.children');
    }

    protected function makeRequest()
    {
        $client = new Client([
            'base_uri' => $this->baseUri,
        ]);

        $response = null;
        try {
            $response = $client->get($this->searchUri, [
                'headers' => [
                    'User-Agent' => 'ZeteticElench',
                ],
            ]);
        } catch (ConnectException $exception) {
            Log::error(
                'Could not connecto to reddit api',
                ['eMessage' => $exception->getMessage()]
            );
        } catch (ServerException $exception) {
            Log::error(
                'Unexpected response from reddit Api',
                ['eMessage' => $exception->getMessage()]
            );
        }

        return $response;
    }
}
