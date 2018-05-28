<?php

use Illuminate\Database\Seeder;

class RegionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Entity\Region::class,10)->create()->each(function (\App\Entity\Region $region){
            $region->children()->saveMany(factory(\App\Entity\Region::class,random_int(3,10))->create()->each(function (\App\Entity\Region $region){
                $region->children()->saveMany(factory(\App\Entity\Region::class,random_int(3,10))->make());
            }));
        });
    }
}
