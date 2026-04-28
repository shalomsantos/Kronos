<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Item;
use App\Models\ItemSubitem;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Item::query();

        if ($request->filled('search')) $query->where('nome', 'like', "%{$request->search}%");

        if ($request->expectsJson()) return response()->json($query->get());

        try {
            $usuario_logado = auth()->user();
            $preferencias = $usuario_logado->preferencia;

            return Inertia::render('Crud/cadastros/itens/index', [
                'itens'        => $query->orderBy('id', 'desc')->get(),
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

    public function itemAssociaveis(string $id)
    {
        try {
            $associaveis = ItemSubitem::where('item_id', $id)->with('subitem')->get();
            return response()->json([
                'success' => true,
                'data' => $associaveis
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
