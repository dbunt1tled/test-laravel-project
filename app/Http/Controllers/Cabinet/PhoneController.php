<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cabinet\Phone\AuthRequest;
use App\Http\Requests\Cabinet\Phone\VerifyRequest;
use App\Services\Sms\SmsSender;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class PhoneController extends Controller
{
    private $sms;

    public function __construct(SmsSender $sms)
    {
        $this->sms = $sms;
    }

    public function request(Request $request)
    {
        $user = \Auth::user();
        try{
            $token = $user->requestPhoneVerification(Carbon::now());
            $this->sms->send($user->phone,'Ваш код подтверждения телефона: '.$token);
        }catch (\DomainException $ex){
            $request->session()->flash('error',$ex->getMessage());
        }
        return redirect()->route('cabinet.profile.phone');
    }

    public function form()
    {
        $user = \Auth::user();
        return view('cabinet.profile.phone',compact('user'));
    }

    public function verify(VerifyRequest $request)
    {
        $user = \Auth::user();
        try{
            $user->verifyPhone($request->token,Carbon::now());
        }catch (\DomainException $ex){
            flash($ex->getMessage())->warning();
            return redirect()->route('cabinet.profile.phone');
        }
        return redirect()->route('cabinet.profile.home');
    }

    public function auth(AuthRequest $request)
    {
        $user = \Auth::user();
        if($request->phoneAuthEnable){
            $user->enablePhoneAuth();
        }else{
            $user->disablePhoneAuth();
        }
        return redirect()->route('cabinet.profile.home');
    }

}
