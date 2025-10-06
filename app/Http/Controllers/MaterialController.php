<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Kategori;
use App\Models\Satuan;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of materials.
     */
    public function index(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $query = Material::with(['kategori', 'satuan']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('spesifikasi', 'like', "%{$search}%");
            });
        }

        // Filter by Kategori
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        // Filter by Satuan
        if ($request->filled('satuan')) {
            $query->where('satuan_id', $request->satuan);
        }

        // Filter by Stock Status
        if ($request->filled('stock_status')) {
            switch ($request->stock_status) {
                case 'empty':
                    $query->where('jumlah', '<=', 0);
                    break;
                case 'low':
                    $query->whereColumn('jumlah', '<', 'safety_stock')
                          ->where('jumlah', '>', 0);
                    break;
                case 'safe':
                    $query->whereColumn('jumlah', '>=', 'safety_stock');
                    break;
            }
        }

        // Sorting
        $sort = $request->get('sort', 'terbaru');
        switch ($sort) {
            case 'nama_asc':
                $query->orderBy('nama', 'asc');
                break;
            case 'nama_desc':
                $query->orderBy('nama', 'desc');
                break;
            case 'jumlah_asc':
                $query->orderBy('jumlah', 'asc');
                break;
            case 'jumlah_desc':
                $query->orderBy('jumlah', 'desc');
                break;
            case 'terbaru':
            default:
                $query->latest();
                break;
        }

        $materials = $query->paginate(10)->withQueryString();

        // Get statistics for all materials (not paginated)
        $allMaterials = Material::with(['kategori', 'satuan'])->get();
        $totalMaterials = $allMaterials->count();
        $lowStockMaterials = $allMaterials->filter(fn($m) => $m->isStokKurang())->count();
        $emptyStockMaterials = $allMaterials->filter(fn($m) => $m->getCurrentStok() <= 0)->count();
        $safeStockMaterials = $allMaterials->filter(fn($m) => $m->getCurrentStok() > $m->safety_stock)->count();

        // Get all kategoris and satuans for filter dropdowns
        $kategoris = Kategori::orderBy('name')->get();
        $satuans = Satuan::orderBy('name')->get();

        return view('admin.materials.index', compact('materials', 'totalMaterials', 'lowStockMaterials', 'emptyStockMaterials', 'safeStockMaterials', 'kategoris', 'satuans'));
    }

    /**
     * Show the form for creating a new material.
     */
    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $kategoris = Kategori::all();
        $satuans = Satuan::all();
        return view('admin.materials.create', compact('kategoris', 'satuans'));
    }

    /**
     * Store a newly created material in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'material' => 'required|string|max:255',
            'spesifikasi' => 'nullable|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'safety_stock' => 'required|numeric|min:0',
            'satuan_id' => 'required|exists:satuans,id',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        // Map 'material' field to 'nama' for database
        $validated['nama'] = $validated['material'];
        unset($validated['material']);

        Material::create($validated);

        return redirect()->route('admin.materials.index')
                        ->with('success', 'Material berhasil ditambahkan.');
    }

    /**
     * Display the specified material.
     */
    public function show(Material $material)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $material->load(['kategori', 'satuan', 'movements']);
        return view('admin.materials.show', compact('material'));
    }

    /**
     * Show the form for editing the specified material.
     */
    public function edit(Material $material)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $kategoris = Kategori::all();
        $satuans = Satuan::all();
        return view('admin.materials.edit', compact('material', 'kategoris', 'satuans'));
    }

    /**
     * Update the specified material in storage.
     */
    public function update(Request $request, Material $material)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'material' => 'required|string|max:255',
            'spesifikasi' => 'nullable|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'safety_stock' => 'required|numeric|min:0',
            'satuan_id' => 'required|exists:satuans,id',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        // Map 'material' field to 'nama' for database
        $validated['nama'] = $validated['material'];
        unset($validated['material']);

        $material->update($validated);

        return redirect()->route('admin.materials.index')
                        ->with('success', 'Material berhasil diupdate.');
    }

    /**
     * Remove the specified material from storage.
     */
    public function destroy(Material $material)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $material->delete();

        return redirect()->route('admin.materials.index')
            ->with('success', 'Material berhasil dihapus.');
    }
}
