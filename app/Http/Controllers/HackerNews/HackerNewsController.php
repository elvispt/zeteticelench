<?php

namespace  App\Http\Controllers\HackerNews;

use App\Http\Controllers\Controller;
use App\Repos\HackerNews;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use InvalidArgumentException;

class HackerNewsController extends Controller
{
    public function top()
    {
        $hackerNews = new HackerNews();
        $stories = $hackerNews->getTopStories();
        $hnPostUrlFormat = config('hackernews.site_url') . '/item?id=%s';
        return View::make('hackernews/top', [
            'stories' => $stories,
            'hnPostUrlFormat' => $hnPostUrlFormat,
        ]);
    }

    public function best()
    {
        $hackerNews = new HackerNews();
        $stories = $hackerNews->getBestStories();
        $hnPostUrlFormat = config('hackernews.site_url') . '/item?id=%s';
        return View::make('hackernews/top', [
            'stories' => $stories,
            'hnPostUrlFormat' => $hnPostUrlFormat,
        ]);
    }

    protected function getItem($id)
    {
        $client = new Client([
            'base_uri' => 'https://hacker-news.firebaseio.com',
        ]);
        $response = $client->get("v0/item/$id.json");
        $json = $response->getBody()->getContents();

        $item = null;
        try {
            $item = \GuzzleHttp\json_decode($json);
        } catch (InvalidArgumentException $exception) {
            Log::error("Could not decode hn story item", [$exception->getMessage()]);
        }
        return $item;
    }
}
