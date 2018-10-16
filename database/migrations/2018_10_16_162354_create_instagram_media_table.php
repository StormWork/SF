<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstagramMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instagram_media', function (Blueprint $table) {
            $table->string('id')->unique()->primary();
            $table->string('instagram_id');
            $table->string('link');
            // $table->string('thumbnail_link');
            // $table->string('low_link');
            // $table->string('standard_link');
            // $table->string('high_link');
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
        Schema::dropIfExists('instagram_media');
    }
}
