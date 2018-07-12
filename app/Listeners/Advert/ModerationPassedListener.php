<?php

namespace App\Listeners\Advert;

use App\Notifications\Advert\ModerationPassedNotification;
use App\Services\Search\AdvertIndexer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\Advert\ModerationPassed;

class ModerationPassedListener
{
    public function handle(ModerationPassed $event)
    {
        $advert = $event->advert;
        $advert->user->notify(new ModerationPassedNotification($advert));
    }
}
