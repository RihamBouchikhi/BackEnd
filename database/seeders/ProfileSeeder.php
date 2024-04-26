<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('profiles')->insert([
            [
                'firstName' => 'hassan',
                'lastName' => 'mhd',
                'email' => 'hassan@gmail.com',
                'password' => Hash::make('Hassan123?'),
                'phone' => '0636453567',
                'role'=>'user',
            ],
            [
                'firstName' => 'walid',
                'lastName' => 'zkn',
                'email' => 'walid@gmail.com',
                'password' => Hash::make('Walid123?'),
                'phone' => '0636453567',
                'role'=>'supervisor',
            ],
            [
                'firstName' => 'riham',
                'lastName' => 'rhm',
                'email' => 'riham@gmail.com',
                'password' => Hash::make('Riham123?'),
                'phone' => '0636453567',
                'role'=>'admin',
            ],
            [
                'firstName' => 'zyad',
                'lastName' => 'zyd',
                'email' => 'zyad@gmail.com',
                'password' => Hash::make('Zyad123?'),
                'phone' => '0636453567',
                'role'=>'intern',
            ],
            [
                'firstName' => 'hassan2',
                'lastName' => 'mhd',
                'email' => 'hassan2@gmail.com',
                'password' => Hash::make('Hassan123?'),
                'phone' => '0636453567',
                'role'=>'intern',
            ],
            ]
        );
        DB::table('users')->insert(
            [  
                'profile_id' => 1,
                'academicLevel' => 'bac+2',
                'establishment' => 'Ofppt',
            ]
        );
             DB::table('supervisors')->insert(
            [  
                'profile_id' => 2,
          
            ]
        );
             DB::table('admins')->insert(
            [  
                'profile_id' => 3,
          
            ]
        );
             DB::table('interns')->insert(
            [  
                'profile_id' => 4,
                'projectLink' => 'acdjscjvsvdvjbsd',
                'academicLevel' => 'bac+2',
                'establishment' => 'Ofppt',
                'startDate' => "2024-03-18 18:38:13" ,
                'endDate' => "2024-04-28 18:38:13",
            ]
        );
             DB::table('interns')->insert(
            [  
                'profile_id' => 5,
                'projectLink' => 'acdjscjvsvdvjbsd',
                'academicLevel' => 'bac+2',
                'establishment' => 'Ofppt',
                'startDate' => "2024-03-18 18:38:13" ,
                'endDate' => "2024-04-28 18:38:13",
            ]
        );
         
    }
}
