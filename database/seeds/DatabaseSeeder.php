<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(BotsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(VkUserTableSeeder::class);
        $this->call(ButtonsTableSeeder::class);
        $this->call(KeyBoardsTableSeeder::class);
        $this->call(MessagesTableSeeder::class);
        $this->call(RegionTableSeeder::class);
        $this->call(RolesTableSeeder::class);
    }
}
