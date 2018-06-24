<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Entity\Adverts\Category::class,10)->create()->each(function (\App\Entity\Adverts\Category $category){
            $counts = [0, random_int(3,7)];
            $category->children()->saveMany(factory(\App\Entity\Adverts\Category::class,$counts[array_rand($counts)])->create()->each(function (\App\Entity\Adverts\Category $category){
                $counts = [0, random_int(3,7)];
                $category->children()->saveMany(factory(\App\Entity\Adverts\Category::class,$counts[array_rand($counts)])->create());
            }));
        });
    }
}
