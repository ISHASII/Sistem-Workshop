<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index(Request $request)
    {
        $query = Jabatan::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $jabatans = $query->latest()->paginate(10)->withQueryString();

        return view('admin.jabatan.index', compact('jabatans'));
    }

    public function create()
    {
        return view('admin.jabatan.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Jabatan::create([
            'name' => $data['name'],
        ]);

        return redirect()->route('admin.jabatan.index')->with('success', 'Jabatan created.');
    }

    public function edit(Jabatan $jabatan)
    {
        return view('admin.jabatan.edit', compact('jabatan'));
    }

    public function update(Request $request, Jabatan $jabatan)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $jabatan->update([
            'name' => $data['name'],
        ]);

        return redirect()->route('admin.jabatan.index')->with('success', 'Jabatan updated.');
    }

    public function destroy(Jabatan $jabatan)
    {
        $jabatan->delete();

        return redirect()->route('admin.jabatan.index')->with('success', 'Jabatan deleted.');
    }
}
