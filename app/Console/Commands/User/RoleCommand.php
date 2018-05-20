<?php

namespace App\Console\Commands\User;

use App\Entity\User;
use Illuminate\Console\Command;

class RoleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:role {email} {role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $email = $this->argument('email');
        $role = $this->argument('role');

        if(!$user = User::where('email',$email)->first()){
            $this->error('Пользователь с email - '.$email.' не существует');
            return false;
        }
        try{
            $user->changeRole($role);
        }catch (\Exception $ex){
            $this->error('Ошибка смены роли пользователю с email - '.$email.' '.$ex->getMessage());
            return false;
        }
        $this->info('Роль пользователя с email - '.$email.' успешно сменена на '.$role);
        return true;
    }
}
