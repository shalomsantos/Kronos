<?php

namespace App\Http\Controllers;
namespace App\Models\Tipo_projeto;

use Illuminate\Http\Request;

class TipoProjeto extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        dd("entrou");
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
            // $newTipo_Projeto = Tipo_projeto::create([
            //     'nome' => $request['nome']
            // ]);

            return response()->json([
                'success' => true,
                'message' => "Tipo de projeto: [".$request['nome']."], criado com sucesso."
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => "Erro ao tentar inserir tipo: [".$request['nome']."].",
                'details' => $e
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
