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
        $permissions = Dashboard::getPermission()
            ->collapse()
            ->reduce(static function (Collection $permissions, array $item) {
                return $permissions->put($item['slug'], true);
            }, collect());

        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@uniq.pro',
            'password' => bcrypt('king6767'),
            'permissions' => $permissions,
        ]);
    }
}
