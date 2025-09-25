<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Projeto;

class ProjetoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projetos = [
            [
                'nome' => 'Gestão de Projetos Ágeis',
                'tipo_projeto_id' => 1,
                'descricao' => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.',
                'created_at' => now(),
                'created_by' => 1
            ]
            ,[
                'nome' => 'Base de Conhecimento Global',
                'tipo_projeto_id' => 2,
                'descricao' => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.',
                'created_at' => now(),
                'created_by' => 1
            ]
            ,[
                'nome' => 'Fluxo de Trabalho Integrado',
                'tipo_projeto_id' => 3,
                'descricao' => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.',
                'created_at' => now(),
                'created_by' => 1
            ]
            ,[
                'nome' => 'Plataforma de Dados Seguros',
                'tipo_projeto_id' => 4,
                'descricao' => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.',
                'created_at' => now(),
                'created_by' => 1
            ]
            ,[
                'nome' => 'Controle de Recursos Humanos',
                'tipo_projeto_id' => 5,
                'descricao' => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.',
                'created_at' => now(),
                'created_by' => 1
            ]
        ];
        Projeto::insert($projetos);
    }
}
