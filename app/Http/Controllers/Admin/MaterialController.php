<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Satuan;
use App\Models\Kategori;
use App\Models\MaterialMasuk;

class MaterialController extends Controller
{
    public function masuk()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
        // kept for backward compatibility; prefer MaterialMasukController
        $satuans = Satuan::orderBy('name')->get();
        $kategoris = Kategori::orderBy('name')->get();
        return view('admin.material.masuk', compact('satuans', 'kategoris'));
    }

    public function storeMasuk(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $data = $request->validate([
            'tanggal' => 'required|date',
            'material' => 'required|string|max:255',
            'spesifikasi' => 'nullable|string|max:255',
            'jumlah' => 'required|numeric',
            'satuan_id' => 'required|exists:satuans,id',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        MaterialMasuk::create($data);

        return redirect()->route('material.masuk')->with('success', 'Material masuk berhasil disimpan.');
    }

    public function indexMasuk()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $items = MaterialMasuk::with(['satuan', 'kategori'])->orderByDesc('tanggal')->paginate(20);
        return view('admin.material.masuk_index', compact('items'));
    }

    public function keluarJo()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
        $items = \App\Models\MaterialKeluar::with(['satuan', 'kategori'])->where('type', 'jo')->orderByDesc('tanggal')->paginate(20);
        return view('admin.material.keluar_jo', compact('items'));
    }

    public function keluarMemo()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
        $items = \App\Models\MaterialKeluar::with(['satuan', 'kategori'])->where('type', 'memo')->orderByDesc('tanggal')->paginate(20);
        return view('admin.material.keluar_memo', compact('items'));
    }
}
