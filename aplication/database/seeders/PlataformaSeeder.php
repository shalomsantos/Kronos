<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plataforma;

class PlataformaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plataformas = [
            [
                'nome' => 'Ação promocional',
                'descricao' => 'Campanhas focadas em acessibilidade digital',
                'created_at' => now(),
                'created_by' => 1
            ],
            [
                'nome' => 'Artigo',
                'descricao' => 'Conteúdos sobre alimentação e bebidas',
                'created_at' => now(),
                'created_by' => 1
            ],
            [
                'nome' => 'AudioBook',
                'descricao' => 'Livros narrados e educativos diversos',
                'created_at' => now(),
                'created_by' => 1
            ],
            [
                'nome' => 'AudioCartilha',
                'descricao' => 'Cartilhas narradas com temas variados',
                'created_at' => now(),
                'created_by' => 1
            ],
            [
                'nome' => 'Aulão virtual',
                'descricao' => 'Aulas online interativas e temáticas',
                'created_at' => now(),
                'created_by' => 1
            ],
            [
                'nome' => 'Ava',
                'descricao' => 'Ambiente virtual para aprendizado contínuo',
                'created_at' => now(),
                'created_by' => 1
            ],
            [
                'nome' => 'Blog',
                'descricao' => 'Publicações e artigos informativos diversos',
                'created_at' => now(),
                'created_by' => 1
            ],
            [
                'nome' => 'Caderno',
                'descricao' => 'Materiais de estudo e anotações digitais',
                'created_at' => now(),
                'created_by' => 1
            ],

        ];
        Plataforma::insert($plataformas);
    }
}
