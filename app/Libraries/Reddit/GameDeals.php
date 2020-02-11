<?php

namespace App\Libraries\Reddit;

use App\Actions\NotifyOfNewGameAction;
use App\Models\RedditGamedeal;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class GameDeals
{
    public function get()
    {
        $gamedeals = new Collection($this->getDeals());
        $epicGamesDeals = $this->filterForFreeDeals($gamedeals);

        $notifiables = $this->storeAndGetNotifiables($epicGamesDeals);
        $notifiables->each(function ($deal) {
            $notifyOfNewGameAction = new NotifyOfNewGameAction();
            $notifyOfNewGameAction->execute((object) $deal);
        });
    }

    protected function storeAndGetNotifiables(Collection $list)
    {
        return $list
            ->map(static function ($deal) {
                $data = $deal->data;
                return [
                    'id' => $data->id,
                    'title' => $data->title,
                    'permalink' => $data->permalink,
                    'storeLink' => $data->url,
                ];
            })
            ->filter(function ($deal) {
                $redditGamedeal = RedditGamedeal::updateOrCreate($deal);
                return $redditGamedeal->wasRecentlyCreated;
            });
    }

    protected function filterForFreeDeals(Collection $gamedeals)
    {
        return $gamedeals
            ->filter(function ($deal) {
                $link_flair_text = $deal->data->link_flair_text;

                return is_null($link_flair_text);
            })
            ->filter(function ($deal) {
                $title = $deal->data->title;

                return Str::contains(Str::lower($title), ['free', '100%']);
            });
    }

    protected function getDeals()
    {
        $gamesDealsEpicGamesStore = new GameDealsEpicGamesStore();
        return $gamesDealsEpicGamesStore->getDeals();
    }
}
