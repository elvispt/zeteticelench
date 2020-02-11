<?php

namespace App\Actions;

use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

class NotifyOfNewGameAction
{
    public function execute($deal)
    {
        $data = [
            'redditPermalink' => "https://www.reddit.com/$deal->permalink",
        ];
        Mail::send('emails.mail', $data, function (Message $message) use ($deal) {
            $message
                ->from('elvispt@gmail.com', 'ZeteticElench: EGS Free Game Notifier')
                ->to('elvispt@gmail.com', 'Elvis Pestana')
                ->subject($deal->title)
            ;
        });
    }
}
