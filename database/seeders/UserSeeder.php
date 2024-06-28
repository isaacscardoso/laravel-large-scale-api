<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'role_id' => 1,
            'name' => 'Usuário Administrador',
            'email' => 'admin@teste.com',
        ]);

        User::factory()->create([
            'role_id' => 2,
        ]);
    }
}
