<?php

use Illuminate\Database\Seeder;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = [
            [
                'name' => 'Старт',
                'text' => "Добро пожаловать ✋\n🔹 Теперь вы можете выполнять задания нажав на кнопку ▶ Получить задание;\n🔸 Если у вас возникли вопросы или хотите понять, как это работает, нажмите на кнопку ⁉ Вопросы/Ответы;",
                'keyboard_id' => 1,
                'method' => 'start',
                'method_text' => null,
                'bot_id' => 1
            ],
            [
                'name' => 'Инвайтинг',
                'text' => "К сожалению, вас нет в нашей базе 😔\nНапишите код приглашения от друга ✒",
                'keyboard_id' => null,
                'method' => 'askInvite',
                'method_text' => "⚠ К сожалению, такого приглашения не существует или он неверно введен.\n🔄 Попробуйте еще раз.",
                'bot_id' => 1
            ],
            [
                'name' => 'Пользователь на модерации',
                'text' => "Мы приняли ваш инвайт! Ваш аккаунт отправлен на модерацию. &#128373;\nПо завершению модерации к вам придет сообщение с ответом.",
                'keyboard_id' => null,
                'method' => 'addOnModeration',
                'method_text' => 'Ваш аккаунт отправлен на модерацию, ожидайте. &#9203;',
                'bot_id' => 1
            ],
            [
                'name' => 'Вопросы/Ответы',
                'text' => 'А тут у нас ответы на вопросы.',
                'keyboard_id' => null,
                'method' => null,
                'method_text' => null,
                'bot_id' => 1
            ]
        ];
        DB::table('messages')->insert($date);
    }
}
