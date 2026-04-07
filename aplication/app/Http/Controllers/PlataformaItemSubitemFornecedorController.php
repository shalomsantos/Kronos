<?php

namespace App\Http\Controllers;

use App\Models\PlataformaItemSubitemFornecedor;
use Illuminate\Http\Request;

class PlataformaItemSubitemFornecedorController extends Controller
{
    public function show(string $id)
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

    public function store(Request $request)
    {
        $request->validate([
            'plataforma_id' => 'required',
            'item_id' => 'required',
            'subitem_id' => 'required',
            'fornecedor_id' => '',
            'vl_unit_cot' => 'required', // "12,50" ?? 12.5
            'qt_unidade_cot' => 'required',
            'qt_multip_uni_cot' => 'required',
        ]);
        try {
            $relationchip = PlataformaItemSubitemFornecedor::create([
                'fornecedor_id' => $request->fornecedor_id,
                'item_id' => $request->item_id,
                'plataforma_id' => $request->plataforma_id,
                'qt_multip_uni_cot' => $request->qt_multip_uni_cot,
                'qt_unidade_cot' => $request->qt_unidade_cot,
                'subitem_id' => $request->subitem_id,
                'vl_unit_cot' => $request->vl_unit_cot
            ]);
            return response()->json([
                'success' => true,
                'data' => $relationchip
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, string $id)
    {
        return response()->json([
            'message' => 'update',
            'id' => $id,
            'request' => $request->all()
        ]);
        
    }

    public function create()
    {
        
    }

    public function edit(string $id)
    {
        
    }

    public function destroy(string $id)
    {
        
    }
}
