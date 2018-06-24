<?php

namespace App\Providers;

use App\Entity\Adverts\Category;
use App\Entity\Region;
use App\Services\Sms\ArraySender;
use App\Services\Sms\SmsRu;
use App\Services\Sms\SmsSender;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

class CacheServiceProvider extends ServiceProvider
{
    private $classes = [Region::class,Category::class];
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        //Навешиваться на глобальные события
        foreach ($this->classes as $class) {
            $this->registerFlush($class);
        }


        /*//Вызывается после обработки в БД
        Region::created($flushRegion);
        Region::updated($flushRegion);
        Region::deleted($flushRegion);
        Region::saved($flushRegion);
        //Вызывается до обработки в БД
        Category::saving($flushCategory);
        Category::updating($flushCategory);
        Category::deleting($flushCategory);
        Category::creating($flushCategory);/**/
    }

    private function registerFlush($class)
    {
        /**
         * @var Model $class
         */
        $flush = function () use ($class) {
            Cache::tags($class)->flush();
        };

        $class::created($flush);
        $class::updated($flush);
        $class::deleted($flush);
        $class::saved($flush);
    }

}
