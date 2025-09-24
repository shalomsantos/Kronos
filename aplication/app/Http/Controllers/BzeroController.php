<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Preferencia;
use App\Models\Bzero;

class BzeroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->expectsJson()) return Bzero::all();
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
            $bzeroStore = Bzero::insert([
                'projeto_id' => $request->input('projeto_id'),
                'ano' => $request->input('ano'),
                'descricao' => $request->input('descricao') ?? '',
                'dt_aprovacao' => null,
                'created_by' => auth()->id(),
                // 'updated_by' => ,
                'created_at' => now(),
                // 'updated_at' =>
            ]);
            if($bzeroStore){
                return response()->json([
                    'success' => true,
                    'message' => "base criada com sucesso."
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => "Houve um erro no procedimento de inserção de registro."
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => "Erro ao tentar inserir a base.",
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

    public function modify(Request $request)
    {
        try {
            $preferencia = Preferencia::updateOrCreate([
                'user_id' => $request->input('user_id')
            ],[
                'listagem_menu' => $request->input('listagem_menu')
            ]);

            if ($preferencia) {
                return response()->json([
                    'success' => true,
                    'message' => "Preferência modificada/criada com sucesso."
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => "Houve um erro ao tentar salvar a preferência."
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => "Erro ao tentar modificar/criar a preferência.",
                'details' => $e->getMessage()
            ]);
        }
    }
}
