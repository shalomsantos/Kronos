<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subitem;

class SubitemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subitens = [
            [
                'nome' => 'Áudio Descrição',
                'created_at' => now(),
                'created_by' => 1
            ]
            ,[
                'nome' => 'Legenda descritiva',
                'created_at' => now(),
                'created_by' => 1
            ]
            ,[
                'nome' => 'Legenda oculta',
                'created_at' => now(),
                'created_by' => 1
            ]
            ,[
                'nome' => 'Alimentação palestrante',
                'created_at' => now(),
                'created_by' => 1
            ]
            ,[
                'nome' => 'Almoço Staff',
                'created_at' => now(),
                'created_by' => 1
            ]
            ,[
                'nome' => 'Brunch',
                'created_at' => now(),
                'created_by' => 1
            ]
            ,[
                'nome' => 'Café da manhã',
                'created_at' => now(),
                'created_by' => 1
            ]
            ,[
                'nome' => 'Coffee break',
                'created_at' => now(),
                'created_by' => 1
            ]
            ,[
                'nome' => 'Premiação',
                'created_at' => now(),
                'created_by' => 1
            ]
            ,[
                'nome' => 'Figurino',
                'created_at' => now(),
                'created_by' => 1
            ]
        ];

        Subitem::insert($subitens);
    }
}
