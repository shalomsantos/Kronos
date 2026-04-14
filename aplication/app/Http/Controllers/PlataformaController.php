<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Plataforma;
use App\Models\PlataformaItemSubitemFornecedor;

class PlataformaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Plataforma::with('itens');

        if ($request->filled('search')) $query->where('nome', 'like', "%{$request->search}%");

        if ($request->expectsJson()) return response()->json($query->get());
        
        try {
            $usuario_logado = auth()->user();
            $preferencias = $usuario_logado->preferencia;

            return Inertia::render('Crud/cadastros/plataformas/index', [
                'plataformas'  => $query->get(), 
                'user'         => $usuario_logado,
                'preferencias' => $preferencias,
            ]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
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
            $plataformaStore = Plataforma::insert([
                'nome' => $request['nome'],
                'descricao' => $request['descricao'],
                'created_by' => auth()->id(),
                // 'updated_by' => ,
                'created_at' => now(),
                // 'updated_at' =>
            ]);
            if ($plataformaStore) {
                return response()->json([
                    'success' => true,
                    'message' => "Plataforma: " . $request['nome'] . ", criado com sucesso."
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => "Houve um erro no procedimento de inserção de registro."
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Erro ao tentar inserir a plataforma: " . $request['nome'] . ".",
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
        try {
            $plataforma = Plataforma::find($id);
            if (!$plataforma) {
                return response()->json([
                    'success' => false,
                    'message' => "Plataforma com ID: $id não encontrada."
                ], 404);
            }
            $plataforma->update([
                'nome' => $request['nome'],
                'descricao' => $request['descricao'],
                'updated_by' => auth()->id(),
                'updated_at' => now(),
            ]);
            return response()->json([
                'success' => true,
                'message' => "Plataforma: " . $request['nome'] . ", atualizada com sucesso."
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Erro ao tentar atualizar a plataforma: " . $request['nome'] . ".",
                'details' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function plataformasAssociaveis(string $id)
    {
        try {
            $relationchips = PlataformaItemSubitemFornecedor::where('plataforma_id', $id)->get();
            return response()->json([
                'success' => true,
                'data' => $relationchips
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function insertPlataformasAssociaveis() {}
}
