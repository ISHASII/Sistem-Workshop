<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Manpower;
use Illuminate\Support\Facades\Storage;

class ManpowerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Manpower::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nrp', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%");
            });
        }

        // Filter Jenis Kelamin
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        // Filter Status Pegawai
        if ($request->filled('status_pegawai')) {
            $query->where('status_pegawai', $request->status_pegawai);
        }

        $manpowers = $query->orderBy('nrp')->paginate(15)->withQueryString();
        return view('admin.manpower.index', compact('manpowers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.manpower.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nrp'  => 'required|string|max:50|unique:manpowers,nrp',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'status_pegawai' => 'required|in:kontrak,tetap',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('manpowers', 'public');
            $validated['photo'] = $path;
        }

        Manpower::create($validated);

        return redirect()->route('admin.manpower.index')->with('success', 'Man Power berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Manpower $manpower)
    {
        return view('admin.manpower.show', compact('manpower'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Manpower $manpower)
    {
        return view('admin.manpower.edit', compact('manpower'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Manpower $manpower)
    {
        $validated = $request->validate([
            'nrp'  => 'required|string|max:50|unique:manpowers,nrp,' . $manpower->id,
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'status_pegawai' => 'required|in:kontrak,tetap',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            // delete old photo if exists
            if ($manpower->photo) {
                Storage::disk('public')->delete($manpower->photo);
            }
            $path = $request->file('photo')->store('manpowers', 'public');
            $validated['photo'] = $path;
        }

        $manpower->update($validated);

        return redirect()->route('admin.manpower.index')->with('success', 'Man Power berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Manpower $manpower)
    {
        $manpower->delete();
        return redirect()->route('admin.manpower.index')->with('success', 'Man Power berhasil dihapus');
    }

    /**
     * Remove photo for the specified manpower.
     */
    public function destroyPhoto(Manpower $manpower)
    {
        if ($manpower->photo) {
            Storage::disk('public')->delete($manpower->photo);
            $manpower->photo = null;
            $manpower->save();
        }

        return redirect()->route('admin.manpower.index')->with('success', 'Foto manpower berhasil dihapus');
    }
}
