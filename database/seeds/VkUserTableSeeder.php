<?php

use Illuminate\Database\Seeder;

class VkUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vk_users')->insert([
            'vk_id' => '517130041',
            'status' => 3
        ]);
    }
}
