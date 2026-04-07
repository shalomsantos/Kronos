<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FornecedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $fornecedores = Fornecedor::paginate(5);

            if ($request->expectsJson()) return response()->json(['success' => true, 'data' => $fornecedores], 200);

            $usuario_logado = auth()->user();
            $preferencias = $usuario_logado->preferencia;

            return Inertia::render('Crud/cadastros/fornecedores/index', [
                'fornecedores' => $fornecedores,
                'user' => $usuario_logado,
                'preferencias'=> $preferencias
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
        //
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
