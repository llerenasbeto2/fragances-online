<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Collection as FragranceCollection;

class CollectionApiController extends Controller
{
 public function index()
    {
        return response()->json(FragranceCollection::all());
    }

    public function show($id)
    {
        $collection = FragranceCollection::with(['fragrances.brand'])->findOrFail($id);
        return response()->json($collection);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $collection = FragranceCollection::create($data);
        return response()->json($collection, 201);
    }

    public function update(Request $request, $id)
    {
        $collection = FragranceCollection::findOrFail($id);

        $data = $request->validate([
            'nombre'      => 'sometimes|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $collection->update($data);
        return response()->json($collection);
    }

    public function destroy($id)
    {
        $collection = FragranceCollection::findOrFail($id);
        $collection->delete();
        return response()->json(['message' => 'Collection deleted successfully']);
    }
}
