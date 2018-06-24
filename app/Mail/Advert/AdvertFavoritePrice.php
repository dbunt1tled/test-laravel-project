<?php

namespace App\Mail\Auth;

use App\Entity\Adverts\Advert\Advert;
use App\Entity\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdvertFavoritePrice extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $advert;
    public $oldPrice;

    public function __construct(User $user, Advert $advert, $oldPrice)
    {
        $this->user = $user;
        $this->oldPrice = $oldPrice;
        $this->advert = $advert;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Изменение цены в объявлении: '. $this->advert->title)
                    ->markdown('emails.advert.favorite');
    }
}
