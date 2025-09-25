<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin123'),
                'cargo_id' => 1,
                'created_at' => now()
            ],
            [
                'name' => 'Diretor diretor',
                'email' => 'diretor@diretor.com',
                'password' => Hash::make('diretor123'),
                'cargo_id' => 2,
                'created_at' => now()
            ],
            [
                'name' => 'Gerente gerente',
                'email' => 'gerente@gerente.com',
                'password' => Hash::make('gerente123'),
                'cargo_id' => 3,
                'created_at' => now()
            ],
            [
                'name' => 'Usuário usuario',
                'email' => 'usuario@usuario.com',
                'password' => Hash::make('usuario123'),
                'cargo_id' => 4,
                'created_at' => now()
            ],
        ];
        User::insert($users);
    }
}
