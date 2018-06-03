<?php

namespace Tests\Feature\Auth;

use App\Entity\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    public function testLoginForm()
    {
        $response = $this->get('/login');

        $response->assertStatus(200)
        ->assertSee('<div class="card-header">Вход</div>');
    }

    public function testErrors()
    {
        $response = $this->post('/login',[
            'email' => '',
            'password' => '',
        ]);
        $response
            ->assertStatus(302)
            ->assertSessionHasErrors(['email','password']);
    }
    public function testWait()
    {
        $testUserData = factory(User::class)->make();
        $user = User::register($testUserData->name,$testUserData->email, 'secret');

        $response = $this->post('/login',[
            'email' => $user->name,
            'password' => $user->email,
        ]);
        $response
            ->assertStatus(302)
            ->assertRedirect('/')/*
            ->assertSessionHas('flash','Акаунт не подтвержден или доступ ограничен.')/**/;
    }
    public function testActive()
    {
        $testUserData = factory(User::class)->make();
        $user = User::register($testUserData->name,$testUserData->email, 'secret');
        $user->verify();
        $response = $this->post('/login',[
            'email' => $user->email,
            'password' => 'secret',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/cabinet');
        $this->assertAuthenticated();
    }
}
