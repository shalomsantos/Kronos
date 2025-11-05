<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Fornecedor;


class FornecedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fornecedores = [
            [
                'nome_fantasia' => 'Tech Solutions',
                'razao_social' => 'Tech Solutions Ltda',
                'cnpj' => '12.345.678/0001-90',
                'endereco' => 'Rua das Flores, 123',
                'contato' => '(11) 98765-4321',
                'email' => 'TechSolutionsLtda@gmail.com',
                'descricao' => 'Fornecedor de soluções tecnológicas.',
                'created_at' => now(),
                'created_by' => 1
            ]
            ,[
                'nome_fantasia' => 'ConstruMax',
                'razao_social' => 'ConstruMax S.A.',
                'cnpj' => '98.765.432/0001-12',
                'endereco' => 'Avenida Central, 456',
                'contato' => '(21) 91234-5678',
                'email' => 'ConstruMax@gmail.com',
                'descricao' => 'Especialista em materiais de construção.',
                'created_at' => now(),
                'created_by' => 1
            ]
            ,[
                'nome_fantasia' => 'Alimentos & Cia',
                'razao_social' => 'Alimentos & Cia Comércio de Alimentos Ltdaa',
                'cnpj' => '23.456.789/0001-34',
                'endereco' => 'Praça da Alimentação, 789',
                'contato' => '(31) 99876-5432',
                'email' => 'Alimentos&Cia@gmail.com',
                'descricao' => 'Distribuidora de alimentos e bebidas.',
                'created_at' => now(),
                'created_by' => 1
            ]
        ];

        Fornecedor::insert($fornecedores);
    }
}
