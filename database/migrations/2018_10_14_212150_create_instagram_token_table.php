<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstagramTokenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instagram_tokens', function (Blueprint $table) {
            $table->string('id')->unique()->primary();
            $table->integer('user_id')->unsigned();
            $table->text('profile_picture')->nullable();
            $table->string('name')->nullable();
            $table->string('username')->nullable();
            $table->string('token')->nullable();
            //$table->string('refresh_token')->nullable();
            //$table->timestamp('expire_on');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instagram_tokens');
    }
}
