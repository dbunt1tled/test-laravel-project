<?php

namespace App\Events\Advert;

use App\Entity\Adverts\Advert\Advert;
use Illuminate\Broadcasting\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ModerationPassed implements  ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels, Queueable;

    public $advert;

    public function __construct(Advert $advert)
    {
        $this->advert = $advert;
    }

}
