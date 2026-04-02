<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subitem;
use App\Models\ItemSubitem;
use App\Models\SubitemFornecedor;

class SubitemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->expectsJson()) return Subitem::all();

        if($request['search']){
            return response()->json([
                'search' => $request['search']
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

    public function subitensAssociaveis(string $id)
    {
        try {
            $subitensAssociaveis = SubitemFornecedor::where('subitem_id', $id)->with('fornecedor')->get();
            return response()->json([
                'success' => true,
                'data' => $subitensAssociaveis
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
