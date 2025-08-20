<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => '7arh3ad@gmail.com',
                'password' => Hash::make('$up3r$3cr3t'),
                'is_admin' => true
            ],
            [
                'name' => 'Miłosz',
                'email' => 'gajda.milosz@gmail.com',
                'password' => Hash::make('$up3r$3cr3t'),
                'is_admin' => false
            ]
        ]);
    }
}
