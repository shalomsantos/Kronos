<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            CargoSeeder::class, // 4
            UserSeeder::class, // 4
            TipoProjetoSeeder::class, // 5
            ProjetoSeeder::class, // 5
            StatusSeeder::class, // 6
            BzeroSeeder::class, // 5

            FornecedorSeeder::class, // 3
            SubitemSeeder::class, // 10
            ItemSeeder::class, // 3
            PlataformaSeeder::class, // 8

            TabelasAuxiliaresSeeder::class
        ]);
    }
}
