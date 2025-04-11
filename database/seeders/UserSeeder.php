<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('it_IT');
        
        // Ottieni gli ID dei ruoli
        $repItRoleId = DB::table('roles')->where('name', 'rep_it')->first()->id;
        $dipendenteRoleId = DB::table('roles')->where('name', 'dipendente')->first()->id;

        // Crea un utente specifico rep_it
        DB::table('users')->insert([
            'name' => 'Luca Satta',
            'email' => 'luca@test.test',
            'email_verified_at' => now(),
            'password' => Hash::make('reparto1'),
            'role_id' => $repItRoleId,
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Crea 2 utenti rep_it
        for ($i = 1; $i <= 2; $i++) {
            $firstName = $faker->firstName();
            $lastName = $faker->lastName();
            $name = $firstName . ' ' . $lastName;
            $emailName = strtolower(str_replace(' ', '', $firstName . $lastName . $i));
            
            DB::table('users')->insert([
                'name' => $name,
                'email' => $emailName . '@test.test',
                'email_verified_at' => now(),
                'password' => Hash::make('reparto1'),
                'role_id' => $repItRoleId,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Crea 50 dipendenti
        for ($i = 1; $i <= 50; $i++) {
            $firstName = $faker->firstName();
            $lastName = $faker->lastName();
            $name = $firstName . ' ' . $lastName;
            $emailName = strtolower(str_replace(' ', '', $firstName . $lastName . $i));
            
            DB::table('users')->insert([
                'name' => $name,
                'email' => $emailName . '@test.test',
                'email_verified_at' => now(),
                'password' => Hash::make('dipendente1'),
                'role_id' => $dipendenteRoleId,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}