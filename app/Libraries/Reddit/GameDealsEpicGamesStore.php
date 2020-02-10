<?php

namespace App\Libraries\Reddit;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;

class GameDealsEpicGamesStore
{
    protected $baseUri = 'https://api.reddit.com/r/';
    protected $searchUri = 'GameDeals/search?q=site:epicgames.com+OR+title:epicgamestore+OR+title:%22epic+game+store%22+OR+title:%22EGS%22+OR+title:%22epic+games%22&restrict_sr=on&sort=new&include_over_18=on&feature=legacy_search';

    public function getDeals()
    {
        $response = $this->makeRequest();

        if (!is_null($response)) {
            return $this->getBodyContents($response);
        }
        return $response;
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
