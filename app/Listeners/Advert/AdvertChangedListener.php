<?php

namespace App\Listeners\Advert;

use App\Jobs\Advert\ReindexAdvert;
use App\Notifications\Advert\ModerationPassedNotification;
use App\Services\Search\AdvertIndexer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\Advert\ModerationPassed;

class AdvertChangedListener
{
    public function handle(ModerationPassed $event)
    {
        ReindexAdvert::dispatch($event->advert);
    }
}
