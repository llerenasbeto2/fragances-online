<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Fragrance;
use Illuminate\Http\Request;

class FragranceApiController extends Controller
{
     
    public function index()
    {
        $fragrances = Fragrance::with(['brand', 'collection'])->get();
        return response()->json($fragrances);
    }

    
    public function show(Fragrance $fragrance)
    {
        return response()->json($fragrance->load(['brand', 'collection']));
    }

    
    public function store(Request $request)
    {
        $data = $request->validate([
            'brand_id'      => 'required|exists:brands,id',
            'collection_id' => 'nullable|exists:collections,id',
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'price'         => 'required|numeric|min:0',
            'stock'         => 'required|integer|min:0',
            'concentration' => 'required|in:EDT,EDP,Parfum,Elixir',
            'image_url'     => 'nullable|url|max:500',
        ]);

        $fragrance = Fragrance::create($data);
        return response()->json($fragrance->load(['brand', 'collection']), 201);
    }

    
    public function update(Request $request, Fragrance $fragrance)
    {
        $data = $request->validate([
            'brand_id'      => 'sometimes|exists:brands,id',
            'collection_id' => 'nullable|exists:collections,id',
            'name'          => 'sometimes|string|max:255',
            'description'   => 'nullable|string',
            'price'         => 'sometimes|numeric|min:0',
            'stock'         => 'sometimes|integer|min:0',
            'concentration' => 'sometimes|in:EDT,EDP,Parfum,Elixir',
            'image_url'     => 'nullable|url|max:500',
        ]);

        $fragrance->update($data);
        return response()->json($fragrance->load(['brand', 'collection']));
    }

    
    public function destroy(Fragrance $fragrance)
    {
        $fragrance->delete();
        return response()->json(['message' => 'Fragrance deleted successfully']);
    }
}
