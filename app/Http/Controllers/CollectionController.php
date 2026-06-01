<?php

namespace App\Http\Controllers;
use App\Models\Collection;
use Inertia\Inertia;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function index()
    {
        return Inertia::render('Auth/Admin/Collections/Index', [
            'collections' => Collection::all()
        ]);
    }

    public function create()
    {
        return Inertia::render('Auth/Admin/Collections/Create', [
            'isUpdating' => false
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        Collection::create($request->all());
        return redirect()->route('admin.collections.index');
    }

    public function edit(Collection $collection)
    {
        return Inertia::render('Auth/Admin/Collections/Create', [
            'collection' => $collection,
            'isUpdating' => true
        ]);
    }

    public function update(Request $request, Collection $collection)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $collection->update($request->all());
        return redirect()->route('admin.collections.index');
    }

    public function destroy(Collection $collection)
    {
        $collection->delete();
        return redirect()->back();
    }
}
