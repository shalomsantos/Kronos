<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rascunho = Status::create(['nome' => 'Rascunho', 'created_at' => now()]); // 1
        $cotacao  = Status::create(['nome' => 'Cotação',  'created_at' => now()]); // 2
        $revisao  = Status::create(['nome' => 'Revisão',  'created_at' => now()]); // 3
        $aprovado = Status::create(['nome' => 'Aprovado', 'created_at' => now()]); // 4
        $negado   = Status::create(['nome' => 'Negado',   'created_at' => now()]); // 5
        $fechado  = Status::create(['nome' => 'Fechado',  'created_at' => now()]); // 6

        // Atualiza os relacionamentos
        $rascunho->update(['prox_id' => $cotacao->id]);
        $cotacao ->update(['pai_id'  => $rascunho->id, 'prox_id' => $revisao->id]);
        $revisao ->update(['pai_id'  => $cotacao->id, 'prox_id'  => $aprovado->id]);
        $aprovado->update(['pai_id'  => $revisao->id, 'prox_id'  => $negado->id]);
        $negado  ->update(['pai_id'  => $aprovado->id, 'prox_id' => $fechado->id]);
        $fechado ->update(['pai_id'  => $negado->id]);
    }
}
