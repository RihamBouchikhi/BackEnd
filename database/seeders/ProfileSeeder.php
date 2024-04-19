<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class profileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('profiles')->insert([
            [
                'fullName' => 'hassan mhd',
                'email' => 'hassan@gmail.com',
                'password' => Hash::make('Hassan123?'),
                'phone' => '0636453567',
                'role'=>'user',
            ],
            [
                'fullName' => 'walid zkn',
                'email' => 'walid@gmail.com',
                'password' => Hash::make('walid123?'),
                'phone' => '0636453567',
                'role'=>'supervisor',
            ],
            [
                'fullName' => 'riham bck',
                'email' => 'riham@gmail.com',
                'password' => Hash::make('Riham123?'),
                'phone' => '0636453567',
                'role'=>'admin',
            ],
            [
                'fullName' => 'zeyad idk',
                'email' => 'zyad@gmail.com',
                'password' => Hash::make('Zyad123'),
                'phone' => '0636453567',
                'role'=>'intern',
            ],
            ]
        );    
    }
}
