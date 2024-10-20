<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->upsert([
            [
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('adminadmin')
            ]
        ], ['email'], ['name', 'password']);
    }
}
