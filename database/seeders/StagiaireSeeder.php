<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StagiaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('stagiaire')->insert(
            [
                'id' => '33',
                'nom' => 'zaid',
                'prenom' => 'ouzzani',
                'email' => 'zaid.oz@gmail.com',
                'password' => \Hash::make('zaid1991'),
                'telephone' => '0635956057',
                'dateNaissance' => '1991-10-23',
                'genre' => 'M',
                'CIN' => 'CD356678',
                'CNE' => 'N133137178'
                
            ],
        );
    }
}
