<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandApiController extends Controller
{
     public function index()
    {
        return response()->json(Brand::all());
    }

    public function show(Brand $brand)
    {
        return response()->json(
            $brand->load(['fragrances.collection'])
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'country'  => 'nullable|string|max:100',
            'logo_url' => 'nullable|url|max:500',
        ]);

        $brand = Brand::create($data);
        return response()->json($brand, 201);
    }

    public function update(Request $request, Brand $brand)
    {
        $data = $request->validate([
            'name'     => 'sometimes|string|max:255',
            'country'  => 'nullable|string|max:100',
            'logo_url' => 'nullable|url|max:500',
        ]);

        $brand->update($data);
        return response()->json($brand);
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();
        return response()->json(['message' => 'Brand deleted successfully']);
    }
}
