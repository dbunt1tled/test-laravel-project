<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\UseCases\Auth\NetworkService;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class NetworkController extends Controller
{
    private $service;

    public function __construct(NetworkService $service)
    {
        $this->service = $service;
    }

    public function callback($driver)
    {
        $data =  Socialite::driver($driver)->user();
        try {
            $user = $this->service->auth($driver,$data);
            Auth::login($user);
            //обратно редиректиим куда он хотел
            return redirect()->intended();
        } catch (\DomainException $e) {
            return redirect()->home()->with('error',$e->getMessage());
        }

    }
    public function redirect($driver)
    {
        return Socialite::driver($driver)->redirect();
    }
}
