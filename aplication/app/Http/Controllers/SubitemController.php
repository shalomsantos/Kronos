<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subitem;
use App\Models\ItemSubitem;

class SubitemController extends Controller
{
    public function subitensAssociaveis(Request $request)
    {
        $id = $request['itemId'];

        $subitensAssociaveis = ItemSubitem::whereNot('id', $id)->get();

        return response()->json([
            'data' => $subitensAssociaveis
        ]);
    }
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
}
