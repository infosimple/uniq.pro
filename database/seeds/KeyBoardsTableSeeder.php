<?php

use Illuminate\Database\Seeder;

class KeyBoardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('key_boards')->insert([
            'name' => 'Главная',
            'buttons' => '"[[\"3\",\"4\"],[\"2\"]]"',
            'bot_id' => 1
        ]);
    }
}
