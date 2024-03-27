<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdministrateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('administrateur')->insert(
            [
                'id' => '20',
                'nom' => 'riham',
                'prenom' => 'bouchikhi',
                'email' => 'riham2004bouchikhi@gmail.com',
                'password' => \Hash::make('riham2004'),
                'telephone' => '0631095645',
                'dateNaissance' => '2004-01-28',
                'genre' => 'F',
                'CIN' => 'CD345678',
            ],
        );
    }
}
