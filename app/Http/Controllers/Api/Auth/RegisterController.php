<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use App\Entity\User;
use App\Http\Controllers\Controller;
use App\UseCases\Auth\RegisterService;
use Illuminate\Http\Response;

class RegisterController extends Controller
{
    private $registerService;
    private $header;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
        $this->header = [
            'Content-Type' => 'application/json; charset=UTF-8',
            'charset' => 'utf-8'
        ];
    }

    public function register(RegisterRequest $request)
    {
        //валидация происходит автоматически
        $this->registerService->register($request);
        return response()->json(['success' => 'Проверьте указанный электронный ящик, туда отправлена ссылка для подтверждения регистрации'], Response::HTTP_CREATED,$this->header, JSON_UNESCAPED_UNICODE);
    }
}
