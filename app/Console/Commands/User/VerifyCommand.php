<?php

namespace App\Console\Commands\User;

use App\Entity\User;
use App\UseCases\Auth\RegisterService;
use Illuminate\Console\Command;

class VerifyCommand extends Command
{
    private $registerService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:verify {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Активация пользователя';

    public function __construct( RegisterService $registerService) {
        parent::__construct();
        $this->registerService = $registerService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle():bool
    {
        $email = $this->argument('email');

        if(!$user = User::where('email',$email)->first()){
            $this->error('Пользователь с email - '.$email.' не существует');
            return false;
        }
        try{
            $this->registerService->verify($user->id);
        }catch (\Exception $ex){
            $this->error('Ошибка активации пользователя с email - '.$email.' '.$ex->getMessage());
            return false;
        }
        $this->info('Адрес - '.$email.' успешно подтвержден');
        return true;
    }
}
