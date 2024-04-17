<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('users')->insert(
            [
                'fullName' => 'amina alami',
                'email' => 'hassan@gmail.com',
                'password' => Hash::make('Hassan123'),
                'phone' => '0636453567',
                'role'=>'user',
                'city'=>'rabat',
                'niveau_id'=>5
            ],
        );    
    }
}
