<?php

namespace App\Http\Controllers;
use App\Models\Brand;
use Illuminate\Http\Request;
use Inertia\Inertia;
class BrandController extends Controller
{
    public function index()
    {
        return Inertia::render('Auth/Admin/Brands/Index', [
            'brands' => Brand::all()
        ]);
    }

    public function create()
    {
        return Inertia::render('Auth/Admin/Brands/Create', [
            'isUpdating' => false
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'country'  => 'nullable|string|max:100',
            'logo_url' => 'nullable|url|max:500',
        ]);

        Brand::create($request->all());
        return redirect()->route('admin.brands.index');
    }

    public function edit(Brand $brand)
    {
        return Inertia::render('Auth/Admin/Brands/Create', [
            'brand'      => $brand,
            'isUpdating' => true
        ]);
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'country'  => 'nullable|string|max:100',
            'logo_url' => 'nullable|url|max:500',
        ]);

        $brand->update($request->all());
        return redirect()->route('admin.brands.index');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();
        return redirect()->back();
    }
}
