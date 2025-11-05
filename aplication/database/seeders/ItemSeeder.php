<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $itens = [
            [
                'nome' => 'Acessibilidade',
                'created_at' => now(),
                'created_by' => 1
            ],
            [
                'nome' => 'Alimentação e Bebida',
                'created_at' => now(),
                'created_by' => 1
            ],
            [
                'nome' => 'Diversos',
                'created_at' => now(),
                'created_by' => 1
            ]
        ];
        Item::insert($itens);
    }
}
