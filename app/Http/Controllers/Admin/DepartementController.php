<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Departement;
use Illuminate\Http\Request;

class DepartementController extends Controller
{
    public function index(Request $request)
    {
        $query = Departement::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $departements = $query->latest()->paginate(10)->withQueryString();

        return view('admin.departement.index', compact('departements'));
    }

    public function create()
    {
        return view('admin.departement.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Departement::create([
            'name' => $data['name'],
        ]);

        return redirect()->route('admin.departement.index')->with('success', 'Departement created.');
    }

    public function edit(Departement $departement)
    {
        return view('admin.departement.edit', compact('departement'));
    }

    public function update(Request $request, Departement $departement)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $departement->update([
            'name' => $data['name'],
        ]);

        return redirect()->route('admin.departement.index')->with('success', 'Departement updated.');
    }

    public function destroy(Departement $departement)
    {
        $departement->delete();

        return redirect()->route('admin.departement.index')->with('success', 'Departement deleted.');
    }
}
