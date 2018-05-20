<?php

namespace Tests\Unit\Entity\User;

use App\Entity\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleTest extends TestCase
{

    use DatabaseTransactions;

    public function testRequest()
    {
        $testUserData = factory(User::class)->make();
        $user = User::register($testUserData->name,$testUserData->email, 'secret');

        self::assertFalse($user->isAdmin());
        self::assertFalse($user->isModerator());
        $user->changeRole(User::ROLE_ADMIN);
        self::assertTrue($user->isAdmin());
        self::assertFalse($user->isModerator());
        $user->changeRole(User::ROLE_MODERATOR);
        self::assertFalse($user->isAdmin());
        self::assertTrue($user->isModerator());

        try{
            $user->changeRole(User::ROLE_MODERATOR);
        }catch (\Exception $ex){
            self::assertEquals('Данная роль уже присвоина пользователю.',$ex->getMessage());
        }
        try{
            $user->changeRole('super');
        }catch (\Exception $ex){
            self::assertEquals('Устанавливаемая роль не найдена.',$ex->getMessage());
        }
    }

}
