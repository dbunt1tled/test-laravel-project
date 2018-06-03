<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cabinet\UpdateRequest;

class ProfileController extends Controller
{

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
        $user = \Auth::user();
        $oldPhone = $user->phone;
        $user->edit($request->name,$request->last_name,$request->phone);
        $user->save();
        if($user->phone !== $oldPhone){
            $user->unverifyPhone();
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
