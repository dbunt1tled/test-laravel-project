<?php

namespace App\Console\Commands\Advert;

use App\Entity\Adverts\Advert\Advert;
use App\Entity\User;
use App\UseCases\Adverts\AdvertService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class ExpireCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'advert:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Отключаем просроченные объявления';

    private $service;

    /**
     * ExpireCommand constructor.
     *
     * @param AdvertService $service
     */
    public function __construct(AdvertService $service)
    {
        $this->service = $service;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
       $success = true;
       foreach (Advert::active()->where('expires_at','<',Carbon::now())->cursor() as $advert) {
           /**
            * @var Advert $advert
            */
           try{
               $this->service->expire($advert);
           }catch (\Exception $ex){
               $this->error('Ошибка закрытия объявления '.$advert->id.' '.$ex->getMessage());
               $success = false;
           }
       }
       return $success;
    }
}
