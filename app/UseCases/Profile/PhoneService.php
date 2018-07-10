<?php
/**
 * Created by PhpStorm.
 * User: sid
 * Date: 10.07.18
 * Time: 17:55
 */

namespace App\UseCases\Profile;

use App\Entity\User;

use App\Http\Requests\Cabinet\Phone\VerifyRequest;
use App\Services\Sms\SmsSender;
use Illuminate\Support\Carbon;
class PhoneService
{
    private $sms;
    public function __construct(SmsSender $sms)
    {
        $this->sms = $sms;
    }
    public function request($id)
    {
        $user = $this->getUser($id);
        $token = $user->requestPhoneVerification(Carbon::now());
        $this->sms->send($user->phone, 'Ваш код подтверждения телефона: ' . $token);
    }
    public function verify($id, VerifyRequest $request)
    {
        $user = $this->getUser($id);
        $user->verifyPhone($request['token'], Carbon::now());
    }
    public function toggleAuth($id): bool
    {
        $user = $this->getUser($id);
        if ($user->isPhoneAuthEnabled()) {
            $user->disablePhoneAuth();
        } else {
            $user->enablePhoneAuth();
        }
        return $user->isPhoneAuthEnabled();
    }
    private function getUser($id): User
    {
        return User::findOrFail($id)->first();
    }
}