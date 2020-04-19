<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soc_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('vk_user_id')->nullable()->unsigned()->index();
            $table->integer('telegram_user_id')->nullable()->unsigned()->index();
            $table->integer('watsup_user_id')->nullable()->unsigned()->index();
            $table->foreign('vk_user_id')->references('id')->on('vk_user')
                ->onDelete('cascade');
            $table->foreign('telegram_user_id')->references('id')->on('telegram_user')
                ->onDelete('cascade');
            $table->foreign('watsup_user_id')->references('id')->on('watsup_user')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('soc_users');
    }
}
