<?php
/**
 * Created by PhpStorm.
 * User: sid
 * Date: 19.05.18
 * Time: 19:19
 */

namespace App\UseCases\Auth;

use App\Entity\User;
use App\Http\Requests\Auth\RegisterRequest;
use App\Mail\Auth\AdvertFavoritePrice;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Mail\Mailer;

class RegisterService
{
    private $mailer;
    private $dispatcher;

    public function __construct(Mailer $mailer, Dispatcher $dispatcher)
    {
        $this->mailer = $mailer;
        $this->dispatcher = $dispatcher;
    }

    public function register(RegisterRequest $request)
    {
        $user = User::register($request['name'],$request['email'],$request['password']);
        $this->mailer->to($user->email)->send(new AdvertFavoritePrice($user));
        $this->dispatcher->dispatch(new Registered($user));
    }

    public function verify($id)
    {
        /** @var User $user */
        $user = User::findOrFail($id);
        $user->verify();
    }
}