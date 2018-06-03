<?php

namespace App\Http\Middleware;


use Illuminate\Support\Facades\Auth;

class FilledProfile
{

    public function handle($request, \Closure $next)
    {
        $user = Auth::user();
        if(!$user->hasFilledProfile()){
            flash('Пожалуйста заполните свой профиль')->error();
            return redirect()->route('cabinet.profile.home');
        }
        return $next($request);
    }
}
