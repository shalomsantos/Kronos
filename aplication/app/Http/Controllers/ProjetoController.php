<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projeto;
use Inertia\Inertia;

class ProjetoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->expectsJson()) return Projeto::with('tipoProjeto')->get();

        return Inertia::render('Crud/cadastros/projetos/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $projetoStore = Projeto::insert([
                'nome' => $request['nome'],
                'tipo_projeto_id' => $request['tipo_projeto_id'],
                'descricao' => $request['descricao'] ?? '',
                'created_by' => auth()->id(),
                // 'updated_by' => ,
                'created_at' => now(),
                // 'updated_at' =>
            ]);
            if($projetoStore){
                return response()->json([
                    'success' => true,
                    'message' => "Projeto: ".$request['nome'].", criado com sucesso."
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => "Houve um erro no procedimento de inserção de registro."
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => "Erro ao tentar inserir o projeto: ".$request['nome'].".",
                'details' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
