<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialMovement;
use Illuminate\Http\Request;

class MaterialMovementController extends Controller
{
    /**
     * Display a listing of material movements.
     */
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $movements = MaterialMovement::with('material')
            ->orderBy('tanggal', 'desc')
            ->paginate(20);

        return view('admin.material-movements.index', compact('movements'));
    }

    /**
     * Show the form for creating a new material movement.
     */
    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $materials = Material::with(['kategori', 'satuan'])->get();
        return view('admin.material-movements.create', compact('materials'));
    }

    /**
     * Store a newly created material movement in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'material_id' => 'required|exists:materials,id',
            'type' => 'required|in:in,out',
            'tanggal' => 'required|date',
            'jumlah' => 'required|integer|min:1',
            'seksi' => 'nullable|string|max:255',
            'safety_stock' => 'nullable|integer|min:0',
            'movement_type' => 'required|in:jo,memo,other',
            'keterangan' => 'nullable|string',
        ]);

        MaterialMovement::create($request->all());

        return redirect()->route('admin.material-movements.index')
            ->with('success', 'Perpindahan stok berhasil ditambahkan.');
    }

    /**
     * Display the specified material movement.
     */
    public function show(MaterialMovement $materialMovement)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $materialMovement->load('material');
        return view('admin.material-movements.show', compact('materialMovement'));
    }

    /**
     * Show the form for editing the specified material movement.
     */
    public function edit(MaterialMovement $materialMovement)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $materials = Material::with(['kategori', 'satuan'])->get();
        return view('admin.material-movements.edit', compact('materialMovement', 'materials'));
    }

    /**
     * Update the specified material movement in storage.
     */
    public function update(Request $request, MaterialMovement $materialMovement)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'material_id' => 'required|exists:materials,id',
            'type' => 'required|in:in,out',
            'tanggal' => 'required|date',
            'jumlah' => 'required|integer|min:1',
            'seksi' => 'nullable|string|max:255',
            'safety_stock' => 'nullable|integer|min:0',
            'movement_type' => 'required|in:jo,memo,other',
            'keterangan' => 'nullable|string',
        ]);

        $materialMovement->update($request->all());

        return redirect()->route('admin.material-movements.index')
            ->with('success', 'Perpindahan stok berhasil diperbarui.');
    }

    /**
     * Remove the specified material movement from storage.
     */
    public function destroy(MaterialMovement $materialMovement)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $materialMovement->delete();

        return redirect()->route('admin.material-movements.index')
            ->with('success', 'Perpindahan stok berhasil dihapus.');
    }

    /**
     * Show form for stock in (material masuk)
     */
    public function stockIn()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $materials = Material::with(['kategori', 'satuan'])->get();
        return view('admin.material-movements.stock-in', compact('materials'));
    }

    /**
     * Show form for stock out (material keluar)
     */
    public function stockOut()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $materials = Material::with(['kategori', 'satuan'])->get();
        return view('admin.material-movements.stock-out', compact('materials'));
    }

    /**
     * Process stock in
     */
    public function processStockIn(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'material_id' => 'required|exists:materials,id',
            'tanggal' => 'required|date',
            'jumlah' => 'required|integer|min:1',
            'safety_stock' => 'nullable|integer|min:0',
            'keterangan' => 'nullable|string',
        ]);

        // Create movement record
        MaterialMovement::create([
            'material_id' => $request->material_id,
            'type' => 'in',
            'tanggal' => $request->tanggal,
            'jumlah' => $request->jumlah,
            'safety_stock' => $request->safety_stock,
            'movement_type' => 'other',
            'keterangan' => $request->keterangan,
        ]);

        // Get updated stock using getCurrentStok method
        $material = Material::with('satuan')->find($request->material_id);
        $currentStock = $material->getCurrentStok();

        return redirect()->route('admin.material-movements.stock-in')
            ->with('success', 'Stok masuk berhasil ditambahkan. Stock sekarang: ' . (int)$currentStock . ' ' . ($material->satuan->name ?? ''));
    }

    /**
     * Process stock out
     */
    public function processStockOut(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'material_id' => 'required|exists:materials,id',
            'tanggal' => 'required|date',
            'jumlah' => 'required|integer|min:1',
            'seksi' => 'required|string|max:255',
            'movement_type' => 'required|in:jo,memo,other',
            'keterangan' => 'nullable|string',
        ]);

        // Check if stock is sufficient using getCurrentStok
        $material = Material::with('satuan')->find($request->material_id);
        $currentStock = $material->getCurrentStok();

        if ($currentStock < $request->jumlah) {
            return redirect()->back()
                ->withErrors(['jumlah' => 'Stok tidak mencukupi. Stok tersedia: ' . (int)$currentStock . ' ' . ($material->satuan->name ?? '')])
                ->withInput();
        }

        // Create movement record (stock akan otomatis terhitung dari movements)
        MaterialMovement::create([
            'material_id' => $request->material_id,
            'type' => 'out',
            'tanggal' => $request->tanggal,
            'jumlah' => $request->jumlah,
            'seksi' => $request->seksi,
            'movement_type' => $request->movement_type,
            'keterangan' => $request->keterangan,
        ]);

        // Get new current stock after movement
        $newStock = $material->getCurrentStok();

        return redirect()->route('admin.material-movements.stock-out')
            ->with('success', 'Stok keluar berhasil ditambahkan. Stock sekarang: ' . (int)$newStock . ' ' . ($material->satuan->name ?? ''));
    }
}