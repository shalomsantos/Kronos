<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoProjeto;

class TipoProjetoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $TipoProjetos = [
            ['nome' => 'Plano de trabalho', 'created_at' => now(), 'created_by' => 1],
            ['nome' => 'Núcleo Criativo',   'created_at' => now(), 'created_by' => 1],
            ['nome' => 'Mapa Digital',      'created_at' => now(), 'created_by' => 1],
            ['nome' => 'Fluxo Ágil',        'created_at' => now(), 'created_by' => 1],
            ['nome' => 'Núcleo Criativo',   'created_at' => now(), 'created_by' => 1],
        ];
        TipoProjeto::insert($TipoProjetos);
    }
}
