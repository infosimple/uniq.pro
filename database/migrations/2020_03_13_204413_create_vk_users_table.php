<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVkUsersTable extends Migration
{

    public function up()
    {
        Schema::create('vk_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('vk_id')->unique();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('photo_50')->nullable();
            $table->integer('region_id')->nullable();
            $table->integer('status')->default(0);
            $table->integer('role')->default(0);
            $table->jsonb('params')->nullable();
            $table->bigInteger('referral')->nullable();
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
        Schema::dropIfExists('vk_users');
    }
}
