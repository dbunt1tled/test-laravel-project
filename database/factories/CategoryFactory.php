<?php

use Faker\Generator as Faker;

/**
 * @var \Illuminate\Database\Eloquent\Factory $factory
 */

$factory->define(\App\Entity\Adverts\Category::class, function (Faker $faker) {
    return [
        'name' => $name =$faker->unique()->name,
        'slug' => str_slug($name),
        'parent_id' => null,
        '_lft' => null,
        '_rgt' => null,
    ];
});
