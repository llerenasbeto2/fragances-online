<?php

namespace App\Http\Controllers;

use App\Models\Fragrance;
use App\Models\Brand;
use App\Models\Collection;
use Illuminate\Http\Request;
use Inertia\Inertia;


class FragranceController extends Controller
{
      public function index()
    {
        $fragrances = Fragrance::with(['brand', 'collection'])->get();
        return Inertia::render('Auth/Admin/Fragrances/Index', [
            'fragrances' => $fragrances
        ]);
    }

    public function create()
    {
        $brands = Brand::orderBy('name')->get();
        $collections = Collection::orderBy('nombre')->get();
        
        return Inertia::render('Auth/Admin/Fragrances/Create', [
            'brands' => $brands,
            'collections' => $collections,
            'isUpdating' => false
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'collection_id' => 'nullable|exists:collections,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'concentration' => 'required|in:EDT,EDP,Parfum,Elixir',
        ]);

        Fragrance::create($validated);
        
        return redirect()->route('admin.fragrances.index');
    }

    public function edit(Fragrance $fragrance)
    {
        $brands = Brand::orderBy('name')->get();
        $collections = Collection::orderBy('nombre')->get();
        
        return Inertia::render('Auth/Admin/Fragrances/Create', [
            'fragrance' => $fragrance->load(['brand', 'collection']),
            'brands' => $brands,
            'collections' => $collections,
            'isUpdating' => true
        ]);
    }

    public function update(Request $request, Fragrance $fragrance)
    {
        $validated = $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'collection_id' => 'nullable|exists:collections,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'concentration' => 'required|in:EDT,EDP,Parfum,Elixir',
        ]);

        $fragrance->update($validated);
        
        return redirect()->route('admin.fragrances.index');
    }

    public function destroy(Fragrance $fragrance)
    {
        $fragrance->delete();
        return redirect()->back();
    }
}
