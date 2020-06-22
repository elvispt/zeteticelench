<?php

namespace App\Actions;

use App\Mail\GameDealFound;
use Illuminate\Support\Facades\Mail;

class NotifyOfNewGameAction
{
    public function execute($deal)
    {
        $to = (object) [
            'email' => config('reddit.game_deals_notify_mail_to'),
            'name' => config('reddit.game_deals_notify_mail_to_name'),
        ];
        Mail::to($to)->send(new GameDealFound($deal));
    }
}
