<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'name' => 'Администратор',
                'slug' => 'admin',
                'permissions' => '{"platform.index": "1", "platform.systems.index": "1", "platform.systems.roles": "1", "platform.systems.users": "1", "platform.systems.attachment": "1"}'
           ],
            [
                'name' => 'Модератор',
                'slug' => 'moderator',
                'permissions' => '{"platform.index": "1", "platform.systems.index": "0", "platform.systems.roles": "0", "platform.systems.users": "0", "platform.systems.attachment": "0"}'
            ],
            [
                'name' => 'Пользователь',
                'slug' => 'user',
                'permissions' => '{"platform.index": "1", "platform.systems.index": "1", "platform.systems.roles": "1", "platform.systems.users": "1", "platform.systems.attachment": "1"}'
            ],
            [
                'name' => 'Клиент',
                'slug' => 'client',
                'permissions' => '{"platform.index": "1", "platform.systems.index": "1", "platform.systems.roles": "1", "platform.systems.users": "1", "platform.systems.attachment": "1"}'
            ],
            [
                'name' => 'Отключен',
                'slug' => 'disabled',
                'permissions' => '{"platform.index": "0", "platform.systems.index": "0", "platform.systems.roles": "0", "platform.systems.users": "0", "platform.systems.attachment": "0"}'
            ]
        ]);
    }
}
