<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeyBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('key_boards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->jsonb('buttons'); // Json buttons_id
            $table->integer('bot_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('key_boards');
    }
}
