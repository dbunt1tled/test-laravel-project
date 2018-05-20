<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use App\Mail\Auth\VerifyMail;
use App\Entity\User;
use App\Http\Controllers\Controller;
use App\UseCases\Auth\RegisterService;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    private $registerService;

    protected $redirectTo = '/cabinet';

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        //валидация происходит автоматически
        $this->registerService->register($request);
        flash('Проверьте указанный электронный ящик, туда отправлена ссылка для подтверждения регистрации')->warning();
        return redirect()->route('login');
    }

    protected function guard()
    {
        return \Auth::guard();
    }

    protected function create(array $data)
    {
        $user = User::register($data['name'],$data['email'],$data['password']);
        \Mail::to($user->email)->send(new VerifyMail($user));
        return $user;
    }

    public function verify($token)
    {
        if(!$user = User::where('verify_token',$token)->first()){
            flash('Не верный код подтверждения.')->error();
            return redirect('login');
        }
        try{
            $this->registerService->verify($user->id);
            flash('Ваша почта успешно подтверждена. Введите регистрационные данные и войдите на сайт')->success();
        }catch (\DomainException $ex){
            flash($ex->getMessage())->error();
        }
        return redirect('login');
    }
}
