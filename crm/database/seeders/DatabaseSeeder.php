<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Usuário de teste para desenvolvimento
        User::create([
            'name' => 'Empresa Teste',
            'email' => null,
            'cnpj' => '12.345.678/0001-90',
            'company_name' => 'Empresa Teste LTDA',
            'phone' => null,
            'address' => null,
            'city' => null,
            'state' => null,
            'zip_code' => null,
            'user_type' => 'company',
            'password' => \Hash::make('password'),
            'email_verified_at' => now(),
        ]);
    }
}
