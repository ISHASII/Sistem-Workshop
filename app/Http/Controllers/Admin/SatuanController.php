<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Satuan;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    public function index(Request $request)
    {
        $query = Satuan::query();

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $satuans = $query->latest()->paginate(10)->withQueryString();
        return view('admin.satuan.index', compact('satuans'));
    }

    public function create()
    {
        return view('admin.satuan.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Satuan::create(['name' => $data['name']]);
        return redirect()->route('admin.satuan.index')->with('success', 'Satuan created.');
    }

    public function edit(Satuan $satuan)
    {
        return view('admin.satuan.edit', compact('satuan'));
    }

    public function update(Request $request, Satuan $satuan)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $satuan->update(['name' => $data['name']]);
        return redirect()->route('admin.satuan.index')->with('success', 'Satuan updated.');
    }

    public function destroy(Satuan $satuan)
    {
        $satuan->delete();
        return redirect()->route('admin.satuan.index')->with('success', 'Satuan deleted.');
    }
}
