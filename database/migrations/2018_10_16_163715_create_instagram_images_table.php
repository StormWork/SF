<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstagramImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instagram_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('media_id');
            $table->string('image_type');
            $table->string('link');
            $table->integer('height')->unsigned();
            $table->integer('width')->unsigned();
            $table->timestamps(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instagram_images');
    }
}
