<?php

use Illuminate\Database\Seeder;

class ButtonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('buttons')->insert([
            [
                'name' => '&#8265; Вопросы/Ответы',
                'color' => 'primary',
                'command' => 'faq',
                'bot_id' => 1
            ],
            [
                'name' => '&#128176; Мои баллы',
                'color' => 'secondary',
                'command' => 'points',
                'bot_id' => 1
            ],
            [
                'name' => '&#9881; Настройки',
                'color' => 'secondary',
                'command' => 'settings',
                'bot_id' => 1
            ],
            [
                'name' => '&#9654; Получить задание',
                'color' => 'positive',
                'command' => 'task',
                'bot_id' => 1
            ]
        ]);
    }
}
