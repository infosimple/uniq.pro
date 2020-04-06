<?php

use Illuminate\Database\Seeder;

class BotsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bots')->insert([
            'name' => 'Vk Бот',
            'soc' => 'vk',
            'config' => '{"vk_key": "9961ea377a19cdca77f85d1153f0b1cd0b1425f0b3d3824b470955614cd5257ab40c7e661cd638fc04867", "version": "5.81", "group_id": "174044810", "access_key": "c4e946d5", "secret_key": "IUEGtbFaQqsz", "user_token": "1329264713292647132926474113476b2311329132926474ecb5175c449398e7490d636"}',
        ]);
    }
}
