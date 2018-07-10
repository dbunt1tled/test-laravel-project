<?php
/**
 * Created by PhpStorm.
 * User: sid
 * Date: 10.07.18
 * Time: 12:19
 */

namespace App\UseCases\Auth;

use App\Entity\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Contracts\User as NetworkUser;

class NetworkService
{

    public function auth(string $network, NetworkUser $data)
    {

        if($user = User::byNetwork($network,$data->getId())->first()) {
            return $user;
        }
        if($data->getEmail() && $user = User::where('email',$data->getEmail())->exists()) {
            throw new \DomainException('Пользователь с таким email существует');
        }

        $user = DB::transaction(function () use($network,$data){
            return User::registerByNetwork($network,$data->getId());
        });
        event(new Registered($user));

        return $user;
    }
}