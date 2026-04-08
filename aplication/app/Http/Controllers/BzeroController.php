<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Preferencia;
use App\Models\Bzero;

class BzeroController extends Controller
{
    /**
     * Filtra registros de Bzero conforme parâmetros recebidos.
     */
    public function filtro(Request $request)
    {
        $validated = $request->validate([
            'id' => 'nullable|integer',
            'projeto_id' => 'nullable|integer',
            'ano' => 'nullable|integer',
            'status_id' => 'nullable|integer',
            'created_at_start' => 'nullable|date',
            'created_at_end' => 'nullable|date',
        ]);

        $query = Bzero::query();

        if (isset($validated['id'])) {
            $query->where('id', $validated['id']);
        }
        if (isset($validated['projeto_id'])) {
            $query->where('projeto_id', $validated['projeto_id']);
        }
        if (isset($validated['ano'])) {
            $query->where('ano', $validated['ano']);
        }
        if (isset($validated['status_id'])) {
            $query->where('status_id', $validated['status_id']);
        }
        if (isset($validated['created_at_start']) && isset($validated['created_at_end'])) {
            $start = Carbon::parse($validated['created_at_start'])->startOfDay();

            $end = $validated['created_at_end']
                ? Carbon::parse($validated['created_at_end'])->endOfDay()
                : $start->copy()->endOfDay();
            dd($start, $end);
            $query->whereBetween('created_at', [$start, $end]);
        } else if (isset($validated['created_at_start']) && !isset($validated['created_at_end'])) {
            $start = Carbon::parse($validated['created_at_start'])->startOfDay();
            $end = $start->copy()->endOfDay();
            $query->whereBetween('created_at', [$start, $end]);
        }

        $result = $query->get();

        if ($result->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Nenhum registro encontrado.',
                'data' => []
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Registros filtrados com sucesso.',
            'data' => $result
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $bzeros = Bzero::with('plataformas')->paginate(6);
            
            if ($request->expectsJson()) return response()->json(['success' => true, 'data' => $bzeros], 200);

            $usuario_logado = auth()->user();
            $preferencias = $usuario_logado->preferencia;

            return Inertia::render('Dashboard', [
                'bzeros' => $bzeros,
                'user' => $usuario_logado,
                'preferencias' => $preferencias
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
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
            if ($bzeroStore) {
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
            ], [
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
