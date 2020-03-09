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
        $unfilteredGamedeals = new Collection($this->getDeals());
        $gameDealsList = $this->filterForFreeDeals($unfilteredGamedeals);

        $notifiables = $this->storeAndGetNotifiables($gameDealsList);
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
                $title = $deal->data->title;

                return Str::contains(Str::lower($title), ['free', '100%', '0.00']);
            });
    }

    protected function getDeals()
    {
        $gameDealsFree = new GameDealsFree();
        return $gameDealsFree->getDeals();
    }
}
