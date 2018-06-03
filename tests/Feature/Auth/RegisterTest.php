<?php

namespace Tests\Feature\Auth;

use App\Entity\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    use DatabaseTransactions;

    public function testRegisterForm()
    {
        $response = $this->get('/register');

        $response->assertStatus(200)
        ->assertSee('<div class="card-header">Регистрация</div>');
    }

    public function testErrors()
    {
        $response = $this->post('/register',[
            'name' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => ''
        ]);
        $response
            ->assertStatus(302)
            ->assertSessionHasErrors(['email','name','password']);
    }
    public function testRegisterSuccess()
    {
        $testUserData = factory(User::class)->make();

        $response = $this->post('/register',[
            'name' => $testUserData->name,
            'email' => $testUserData->email,
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ]);
        $response
            ->assertStatus(302)
            ->assertRedirect('/login')/*
            ->assertSessionHas('flash','')/**/;
    }
    public function testVerifyIncorrect()
    {
        $response = $this->get('/verify/' . Str::uuid());
        $response
            ->assertStatus(302)
            ->assertRedirect('/login')/*
            ->assertSessionHas('flash','')/**/;
    }
    public function testVerifyCorrect()
    {
        $testUserData = factory(User::class)->create([
            'status' => User::STATUS_WAIT,
            'verify_token' => Str::uuid()
        ]);
        $response = $this->get('/verify/' .$testUserData->verify_token);
        $response
            ->assertStatus(302)
            ->assertRedirect('/login')/*
            ->assertSessionHas('flash','')/**/;
    }
}
