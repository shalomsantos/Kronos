<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Plataforma;
use App\Models\User;

class PlataformaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->expectsJson()) return Plataforma::all();

        $usuario_logado = User::find(auth()->id());
        $preferencias = $usuario_logado->preferencia;

        return Inertia::render('Crud/cadastros/plataformas/index', [
            'plataformas' => Plataforma::all(),
            'user' => $usuario_logado,
            'preferencias' => $preferencias,
        ]);
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
            $plataformaStore = Plataforma::insert([
                'nome' => $request['nome'],
                'descricao' => $request['descricao'],
                'created_by' => auth()->id(),
                // 'updated_by' => ,
                'created_at' => now(),
                // 'updated_at' =>
            ]);
            if($plataformaStore){
                return response()->json([
                    'success' => true,
                    'message' => "Plataforma: ".$request['nome'].", criado com sucesso."
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => "Houve um erro no procedimento de inserção de registro."
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Erro ao tentar inserir a plataforma: ".$request['nome'].".",
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
