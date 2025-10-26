<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialMovement;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

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

        $query = MaterialMovement::with('material')->orderBy('tanggal', 'desc');

        // Apply filters from the request
        if (request()->filled('search')) {
            $search = request('search');
            $query->whereHas('material', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('spesifikasi', 'like', "%{$search}%");
            });
        }

        if (request()->filled('type')) {
            $query->where('type', request('type'));
        }

        if (request()->filled('date')) {
            $query->whereDate('tanggal', request('date'));
        }

        if (request()->filled('movement_type')) {
            $query->where('movement_type', request('movement_type'));
        }

        $movements = $query->paginate(10)->withQueryString();

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
     * Export filtered material movements to PDF
     */
    public function exportPdfAll(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $query = MaterialMovement::with('material')->orderBy('tanggal', 'desc');

        // optional filters can be implemented if needed (material id, type, date range)
        if ($request->filled('material_id')) {
            $query->where('material_id', $request->material_id);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('start_date')) {
            $query->where('tanggal', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->where('tanggal', '<=', $request->end_date);
        }

        $movements = $query->get();

        $pdf = PDF::loadView('admin.material-movements.pdf.all', compact('movements'))
                  ->setPaper('a4', 'landscape');

        $filename = 'material_movements_' . now()->format('Ymd_His') . '.pdf';
        return $pdf->download($filename);
    }

    /**
     * Export single material movement to PDF
     */
    public function exportPdf(MaterialMovement $materialMovement)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $materialMovement->load('material');
        $pdf = PDF::loadView('admin.material-movements.pdf.item', compact('materialMovement'));
        $filename = 'material_movement_' . ($materialMovement->id ?? 'item') . '_' . now()->format('Ymd') . '.pdf';
        return $pdf->download($filename);
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