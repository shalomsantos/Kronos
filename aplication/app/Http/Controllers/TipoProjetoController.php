<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoProjeto;

class TipoProjetoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $allTipoProjeto = TipoProjeto::all();

            if($allTipoProjeto){
                return response()->json([
                    'success' => true,
                    'message' => "Registros encontrados.",
                    'data' => $allTipoProjeto
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => "Nenhum registro foi encontrado.",
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => "Houve um erro inesperado ao consultar os registros.",
                'details' => $e->getMessage()
            ]);
        }
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
            $newTipo_Projeto = TipoProjeto::insert([
                'nome' => $request['nome']
            ]);
            if($newTipo_Projeto){
                return response()->json([
                    'success' => true,
                    'message' => "Tipo de projeto: [".$request['nome']."], criado com sucesso."
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => "Houve um erro no procedimento de inserção de registro."
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => "Erro ao tentar inserir tipo: [".$request['nome']."].",
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
