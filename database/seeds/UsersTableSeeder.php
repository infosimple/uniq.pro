<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@uniq.pro',
                'password' => bcrypt('king6767'),
                'roles_id' => 1
            ],
            [
                'name' => 'Виктория',
                'email' => 'moderator@uniq.pro',
                'password' => bcrypt('king6767'),
                'roles_id' => 2
            ],
        ]);
    }
}
