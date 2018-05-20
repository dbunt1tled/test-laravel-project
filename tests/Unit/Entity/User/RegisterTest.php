<?php

namespace Tests\Unit\Entity\User;

use App\Entity\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    //automatically rollback db data changed
    use DatabaseTransactions;

    public function testRequest()
    {
        $testUserData = factory(User::class)->make();

        /*
         * создает возвращает одного юзера
         * $testUserData = factory(User::class)->make();
         * возвращает массив юзеров 10 штук
         * $testUserData = factory(User::class,10)->make();
         *
         * возвращает массив и создает 10 юзеров
         * $testUserData = factory(User::class,10)->create();
         *
         */

        $user = User::register($testUserData->name,$testUserData->email, 'secret');

        self::assertNotEmpty($user);

        self::assertEquals($testUserData->name,$user->name);
        self::assertEquals($testUserData->email,$user->email);

        self::assertNotEmpty($user->password);
        self::assertNotEquals($testUserData->password,$user->password);

        self::assertFalse($user->isActive());
        self::assertTrue($user->isWait());
        self::assertFalse($user->isAdmin());
        self::assertFalse($user->isModerator());
        //Trait DatabaseTransactions automatically rollback
        //$user->delete();
    }

    public function testVerify()
    {
        $testUserData = factory(User::class)->make();
        $user = User::register($testUserData->name,$testUserData->email, 'secret');
        $user->verify();

        //$this->expectExceptionMessage('Ваша почта уже подтверждена.');
        //$user->verify();
        // //If exception this row not execute
        //$user->delete();
        try{
            $user->verify();
        }catch (\Exception $ex){
            self::assertEquals('Ваша почта уже подтверждена.',$ex->getMessage());
        }
        //$user->delete();
    }
}
