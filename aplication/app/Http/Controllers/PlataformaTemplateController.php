<?php

namespace App\Http\Controllers;

use App\Models\PlataformaTemplate;
use Illuminate\Http\Request;

class PlataformaTemplateController extends Controller
{
    public function show(string $id)
    {
        try {
            $relationchips = PlataformaTemplate::where('plataforma_id', $id)->get();
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
            $relationchip = PlataformaTemplate::create([
                'plataforma_id' => $request->plataforma_id,
                'item_id' => $request->item_id,
                'subitem_id' => $request->subitem_id,
                'fornecedor_id' => $request->fornecedor_id,
                'vl_unit_cot' => $request->vl_unit_cot,
                'qt_unidade_cot' => $request->qt_unidade_cot,
                'qt_multip_uni_cot' => $request->qt_multip_uni_cot
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Operação bem sucedida!',
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
