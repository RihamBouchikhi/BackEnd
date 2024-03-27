<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EncadrantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('encadrant')->insert(
            [
                'id' => '40',
                'nom' => 'amina',
                'prenom' => 'alami',
                'email' => 'amina123@gmail.com',
                'password' => \Hash::make('amina123'),
                'telephone' => '0636453567',
                'dateNaissance' => '1975-03-16',
                'genre' => 'F',
                'CIN' => 'CD378790',
                'fonction' => 'ingenieur',
            ],
        );    
    }
}
