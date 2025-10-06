<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaterialMasuk;
use App\Models\Satuan;
use App\Models\Kategori;

class MaterialMasukController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') abort(403);
        $items = MaterialMasuk::with(['satuan', 'kategori'])->orderByDesc('tanggal')->paginate(20);
        return view('admin.material.masuk_index', compact('items'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'admin') abort(403);
        $satuans = Satuan::orderBy('name')->get();
        $kategoris = Kategori::orderBy('name')->get();
        return view('admin.material.masuk', compact('satuans', 'kategoris'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $data = $request->validate([
            'tanggal' => 'required|date',
            'material' => 'required|string|max:255',
            'spesifikasi' => 'nullable|string|max:255',
            'jumlah' => 'required|numeric',
            'safety_stock' => 'nullable|numeric|min:0',
            'satuan_id' => 'required|exists:satuans,id',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);
        // default to 0 if null
        if (!isset($data['safety_stock'])) $data['safety_stock'] = 0;

        MaterialMasuk::create($data);

        return redirect()->route('material.masuk.index')->with('success', 'Material masuk berhasil disimpan.');
    }

    public function edit(MaterialMasuk $materialMasuk)
    {
        if (auth()->user()->role !== 'admin') abort(403);
        $satuans = Satuan::orderBy('name')->get();
        $kategoris = Kategori::orderBy('name')->get();
        $item = $materialMasuk;
        return view('admin.material.masuk_edit', compact('item', 'satuans', 'kategoris'));
    }

    public function update(Request $request, MaterialMasuk $materialMasuk)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $data = $request->validate([
            'tanggal' => 'required|date',
            'material' => 'required|string|max:255',
            'spesifikasi' => 'nullable|string|max:255',
            'jumlah' => 'required|numeric',
            'safety_stock' => 'nullable|numeric|min:0',
            'satuan_id' => 'required|exists:satuans,id',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);
        if (!isset($data['safety_stock'])) $data['safety_stock'] = 0;

        $materialMasuk->update($data);

        return redirect()->route('material.masuk.index')->with('success', 'Material masuk berhasil diperbarui.');
    }

    public function destroy(MaterialMasuk $materialMasuk)
    {
        if (auth()->user()->role !== 'admin') abort(403);
        $materialMasuk->delete();
        return redirect()->route('material.masuk.index')->with('success', 'Material masuk berhasil dihapus.');
    }
}