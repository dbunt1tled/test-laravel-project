<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cabinet\UpdateRequest;
use App\UseCases\Profile\ProfileService;

class ProfileController extends Controller
{
    private $service;

    public function __construct(ProfileService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $user = \Auth::user();
        return view('cabinet.profile.home',compact('user'));
    }
    public function edit()
    {
        $user = \Auth::user();
        return view('cabinet.profile.edit',compact('user'));
    }
    public function update(UpdateRequest $request)
    {
        try{
            $this->service->edit($request->user()->id,$request);
        }catch (\DomainException $e) {
            return redirect()->back()->with('error','Пользователь не найден');
        }

        return redirect()->route('cabinet.profile.home');
    }
    public function phone()
    {
        $user = \Auth::user();
        $user->requestPhoneVerification();
        return view('cabinet.profile.edit',compact('user'));
    }
}
