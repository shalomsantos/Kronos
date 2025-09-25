<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bzero;

class BzeroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bzeros = [
            [
                'projeto_id' => 1,
                'status_id' => 1,
                'ano' => '2025',
                'descricao' => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.',
                'created_at' => now(),
                'created_by' => 1
            ]
            ,[
                'projeto_id' => 2,
                'status_id' => 2,
                'ano' => '2025',
                'descricao' => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.',
                'created_at' => now(),
                'created_by' => 1
            ]
            ,[
                'projeto_id' => 3,
                'status_id' => 3,
                'ano' => '2025',
                'descricao' => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.',
                'created_at' => now(),
                'created_by' => 1
            ]
            ,[
                'projeto_id' => 4,
                'status_id' => 4,
                'ano' => '2025',
                'descricao' => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.',
                'created_at' => now(),
                'created_by' => 1
            ]
            ,[
                'projeto_id' => 5,
                'status_id' => 5,
                'ano' => '2025',
                'descricao' => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.',
                'created_at' => now(),
                'created_by' => 1
            ]
        ];
        Bzero::insert($bzeros);
    }
}
