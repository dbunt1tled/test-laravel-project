<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBanners extends Migration
{
    public function up()
    {
        Schema::create('banner_banners', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->integer('category_id')->references('id')->on('advert_categories');
            $table->integer('region_id')->nullable()->references('id')->on('regions');
            $table->string('name');
            $table->integer('views')->nullable();
            $table->integer('limit');
            $table->integer('clicks')->nullable();
            $table->integer('cost')->nullable();
            $table->string('url');
            $table->string('format');
            $table->string('file');
            $table->string('status', 16);

            $table->timestamps();
            $table->timestamp('published_at')->nullable();
        });
    }
    public function down()
    {
        Schema::dropIfExists('banner_banners');
    }
}
