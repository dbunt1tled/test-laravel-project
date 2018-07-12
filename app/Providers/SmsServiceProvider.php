<?php

namespace App\Providers;

use App\Services\Sms\ArraySender;
use App\Services\Sms\SmsRu;
use App\Services\Sms\Telegram;
use App\Services\Sms\SmsSender;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

class SmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SmsSender::class,function (Application $app){
            $config = $app->make('config')->get('sms');
            switch ($config['driver']){
                case 'sms.ru':
                    $params = $config['drivers']['sms.ru'];
                    if(!empty($params['url'])){
                        return new SmsRu($params['appId'],$params['url']);
                    }
                    return new SmsRu($config['appId']);
                case 'array':
                    return new ArraySender();
                case 'telegram':
                    $params = $config['drivers']['telegram'];
                    if(!empty($params['url'])){
                        return new Telegram($params['appId'],$params['url']);
                    }
                    return new Telegram($config['appId']);
                default:
                    throw new \InvalidArgumentException('Не верный смс драйвер: '.$config['driver']);
            }
        });
    }
}
