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
use Tests\TestCase;

class CreateTest extends TestCase
{
    //automatically rollback db data changed
    use DatabaseTransactions;

    public function testCreate()
    {
        /**
         * @var User $testUserData
         */
        $testUserData = factory(User::class)->make();
        $user = User::new($testUserData->name,$testUserData->email);
        $user->save();

        self::assertNotEmpty($user);

        self::assertEquals($testUserData->name,$user->name);
        self::assertEquals($testUserData->email,$user->email);

        self::assertNotEmpty($user->password);

        self::assertFalse($user->isActive());
        self::assertTrue($user->isWait());
        self::assertFalse($user->isAdmin());
        self::assertFalse($user->isModerator());
    }
}