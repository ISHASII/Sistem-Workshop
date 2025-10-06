<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaterialKeluar;
use App\Models\Satuan;
use App\Models\Kategori;
use App\Models\Material;

class MaterialKeluarController extends Controller
{
    public function indexJo()
    {
        if (auth()->user()->role !== 'admin') abort(403);
        $items = MaterialKeluar::with(['satuan', 'kategori'])->where('type', 'jo')->orderByDesc('tanggal')->paginate(20);
        return view('admin.material.keluar_jo', compact('items'));
    }

    public function indexMemo()
    {
        if (auth()->user()->role !== 'admin') abort(403);
        $items = MaterialKeluar::with(['satuan', 'kategori'])->where('type', 'memo')->orderByDesc('tanggal')->paginate(20);
        return view('admin.material.keluar_memo', compact('items'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'admin') abort(403);
        $satuans = Satuan::orderBy('name')->get();
        $kategoris = Kategori::orderBy('name')->get();
        $materials = Material::orderBy('name')->get();
        return view('admin.material.keluar_create', compact('satuans', 'kategoris', 'materials'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $data = $request->validate([
            'seksi' => 'nullable|string|max:100',
            'tanggal' => 'required|date',
            'material' => 'required|string|max:255',
            'spesifikasi' => 'nullable|string|max:255',
            'jumlah' => 'required|numeric',
            'satuan_id' => 'required|exists:satuans,id',
            'kategori_id' => 'nullable|exists:kategoris,id',
            'type' => 'required|in:jo,memo',
        ]);

        MaterialKeluar::create($data);

        $route = $data['type'] === 'memo' ? 'material.keluar_memo' : 'material.keluar_jo';
        return redirect()->route($route)->with('success', 'Material keluar berhasil disimpan.');
    }

    public function edit(MaterialKeluar $materialKeluar)
    {
        if (auth()->user()->role !== 'admin') abort(403);
        $satuans = Satuan::orderBy('name')->get();
        $kategoris = Kategori::orderBy('name')->get();
        $item = $materialKeluar;
        return view('admin.material.keluar_edit', compact('item', 'satuans', 'kategoris'));
    }

    public function update(Request $request, MaterialKeluar $materialKeluar)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $data = $request->validate([
            'tanggal' => 'required|date',
            'material' => 'required|string|max:255',
            'spesifikasi' => 'nullable|string|max:255',
            'jumlah' => 'required|numeric',
            'satuan_id' => 'required|exists:satuans,id',
            'kategori_id' => 'required|exists:kategoris,id',
            'type' => 'required|in:jo,memo',
        ]);

        $materialKeluar->update($data);

        $route = $data['type'] === 'memo' ? 'material.keluar_memo' : 'material.keluar_jo';
        return redirect()->route($route)->with('success', 'Material keluar berhasil diperbarui.');
    }

    public function destroy(MaterialKeluar $materialKeluar)
    {
        if (auth()->user()->role !== 'admin') abort(403);
        $type = $materialKeluar->type;
        $materialKeluar->delete();
        $route = $type === 'memo' ? 'material.keluar_memo' : 'material.keluar_jo';
        return redirect()->route($route)->with('success', 'Material keluar berhasil dihapus.');
    }
}
