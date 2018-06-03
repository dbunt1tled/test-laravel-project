<?php

use Faker\Generator as Faker;
use App\Entity\User;
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Entity\User::class, function (Faker $faker) {
    $active = $faker->boolean;
    $phoneVerify = $faker->boolean;
    return [
        'name' => $faker->name,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
        'verify_token' => $active ? null : \Illuminate\Support\Str::uuid(),
        'status' => $active ? User::STATUS_ACTIVE : User::STATUS_WAIT,
        'phone_verified' => $phoneVerify,
        'phone' => $faker->unique()->phoneNumber,
        'phone_verify_token_expire' => $phoneVerify ? null : \Illuminate\Support\Carbon::now()->addSeconds(300),
        'phone_verify_token' => $phoneVerify ? null : \Illuminate\Support\Str::uuid(),
    ];
});
