<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cargo;

class CargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cargos = [
            ['nome' => 'Admin',   'created_at' => now()],
            ['nome' => 'Diretor', 'created_at' => now()],
            ['nome' => 'Gerente', 'created_at' => now()],
            ['nome' => 'Usuário', 'created_at' => now()],
        ];
        Cargo::insert($cargos);
    }
}
