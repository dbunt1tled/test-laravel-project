<?php

namespace Tests\Unit\Entity\User;

use App\Entity\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{

    public function testRequest()
    {
        $user = User::register($name = 'name',$email = 'email1', $password ='password');

        self::assertNotEmpty($user);

        self::assertEquals($name,$user->name);
        self::assertEquals($email,$user->email);

        self::assertNotEmpty($user->password);
        self::assertNotEquals($password,$user->password);

        self::assertFalse($user->isActive());
        self::assertTrue($user->isWait());

        $user->delete();
    }

    public function testVerify()
    {
        $user = User::register($name = 'name',$email = 'email2', $password ='password');
        $user->verify();
        /*
        $this->expectExceptionMessage('Ваша почта уже подтверждена.');
        $user->verify();
        //If exception this row not execute
        //$user->delete();/**/
        try{
            $user->verify();
        }catch (\DomainException $ex){
            self::assertEquals('Ваша почта уже подтверждена.',$ex->getMessage());
        }
        $user->delete();
    }
}
