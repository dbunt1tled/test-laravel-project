<?php
/**
 * Created by PhpStorm.
 * User: sid
 * Date: 02.06.18
 * Time: 20:31
 */

namespace Tests\Unit\Entity\User;

use App\Entity\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class PhoneTest extends TestCase
{
    //automatically rollback db data changed
    use DatabaseTransactions;

    public function testDefault()
    {
        /**
         * @var User $testUserData
         */
        $testUserData = factory(User::class)->create([
            'phone' =>null,
            'phone_verified' => false,
            'phone_verify_token' => null,
        ]);
        self::assertFalse($testUserData->isPhoneVerified());
    }
    public function testRequestEmptyPhone()
    {
        /**
         * @var User $testUserData
         */
        $testUserData = factory(User::class)->create([
            'phone' =>null,
            'phone_verified' => false,
            'phone_verify_token' => null,
        ]);

        $this->expectExceptionMessage('Номер телефона отсутствует.');
        $testUserData->requestPhoneVerification(Carbon::now());
    }
    public function testRequest()
    {
        /**
         * @var User $testUserData
         */
        $testUserData = factory(User::class)->create([
            'phone' =>'380670000000',
            'phone_verified' => false,
            'phone_verify_token' => null,
        ]);
        $codeVerifiation = $testUserData->requestPhoneVerification(Carbon::now());
        self::assertFalse($testUserData->isPhoneVerified());
        self::assertNotEmpty($codeVerifiation);
    }
    public function testRequestWithOldPhone()
    {
        /**
         * @var User $testUserData
         */
        $testUserData = factory(User::class)->create([
            'phone' =>'380670000000',
            'phone_verified' => true,
            'phone_verify_token' => null,
        ]);
        self::assertTrue($testUserData->isPhoneVerified());
        $testUserData->requestPhoneVerification(Carbon::now());
        self::assertFalse($testUserData->isPhoneVerified());
        self::assertNotEmpty($testUserData->phone_verify_token);
    }
    public function testRequestAllReadySentTimeout()
    {
        /**
         * @var User $testUserData
         */
        $testUserData = factory(User::class)->create([
            'phone' =>'380670000000',
            'phone_verified' => true,
            'phone_verify_token' => null,
        ]);
        $tokenOld = $testUserData->requestPhoneVerification($now = Carbon::now());
        $tokenNew = $testUserData->requestPhoneVerification($now->copy()->addSeconds(500));
        self::assertFalse($testUserData->isPhoneVerified());
        self::assertNotEquals($tokenOld,$tokenNew);
    }
    public function testRequestAllReadySent()
    {
        /**
         * @var User $testUserData
         */
        $testUserData = factory(User::class)->create([
            'phone' =>'380670000000',
            'phone_verified' => true,
            'phone_verify_token' => null,
        ]);
        $testUserData->requestPhoneVerification($now = Carbon::now());
        $this->expectExceptionMessage('Проверочный код уже отправлен.');
        $testUserData->requestPhoneVerification($now->copy()->addSeconds(15));
    }
    public function testVerify()
    {
        /**
         * @var User $testUserData
         */
        $testUserData = factory(User::class)->create([
            'phone' =>'380670000000',
            'phone_verified' => false,
            'phone_verify_token' => $token = '1234',
            'phone_verify_token_expire' => $now = Carbon::now(),
        ]);
        self::assertFalse($testUserData->isPhoneVerified());

        $testUserData->verifyPhone($token,$now->copy()->subSeconds(15));
        self::assertTrue($testUserData->isPhoneVerified());

    }
    public function testVerifyIncorrectToken()
    {
        /**
         * @var User $testUserData
         */
        $testUserData = factory(User::class)->create([
            'phone' =>'380670000000',
            'phone_verified' => false,
            'phone_verify_token' => $token = '1234',
            'phone_verify_token_expire' => $now = Carbon::now(),
        ]);
        self::assertFalse($testUserData->isPhoneVerified());
        $this->expectExceptionMessage('Введен не правильный проверочный код');
        $testUserData->verifyPhone($token.'1',$now->copy()->subSeconds(15));
    }
    public function testVerifyExpiredToken()
    {
        /**
         * @var User $testUserData
         */
        $testUserData = factory(User::class)->create([
            'phone' =>'380670000000',
            'phone_verified' => false,
            'phone_verify_token' => $token = '1234',
            'phone_verify_token_expire' => $now = Carbon::now(),
        ]);
        self::assertFalse($testUserData->isPhoneVerified());
        $this->expectExceptionMessage('Вышел срок действия проверочного кода.');
        $testUserData->verifyPhone($token,$now->copy()->addSeconds(500));
    }
}