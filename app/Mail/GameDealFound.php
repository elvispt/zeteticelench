<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GameDealFound extends Mailable
{
    use SerializesModels;

    public object $deal;

    /**
     * Create a new message instance.
     */
    public function __construct(object $deal)
    {
        $this->deal = $deal;
        $permalink = $this->deal->permalink;
        $this->deal->permalink = "https://www.reddit.com/$permalink";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $from = config('reddit.game_deals_notify_mail_from');
        $fromName = 'ZeteticElench: /r/GameDeals Free Game Notifier';
        return $this->from($from, $fromName)
                    ->subject($this->deal->title)
                    ->view('emails.mail');
    }
}
