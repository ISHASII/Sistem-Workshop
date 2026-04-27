<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChecklistQualityItem;
use Illuminate\Http\Request;

class ChecklistQualityItemController extends Controller
{
    public function index(Request $request)
    {
        $query = ChecklistQualityItem::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $items = $query->orderBy('sort_order')->orderBy('name')->paginate(10)->withQueryString();

        return view('admin.checklist-quality.index', compact('items'));
    }

    public function create()
    {
        return view('admin.checklist-quality.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        ChecklistQualityItem::create([
            'name' => $data['name'],
            'sort_order' => $data['sort_order'] ?? 0,
            'is_active' => (bool)($data['is_active'] ?? false),
        ]);

        return redirect()->route('admin.checklist-quality.index')->with('success', 'Checklist kualitas berhasil ditambahkan.');
    }

    public function edit(ChecklistQualityItem $checklistQualityItem)
    {
        return view('admin.checklist-quality.edit', compact('checklistQualityItem'));
    }

    public function update(Request $request, ChecklistQualityItem $checklistQualityItem)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        $checklistQualityItem->update([
            'name' => $data['name'],
            'sort_order' => $data['sort_order'] ?? 0,
            'is_active' => (bool)($data['is_active'] ?? false),
        ]);

        return redirect()->route('admin.checklist-quality.index')->with('success', 'Checklist kualitas berhasil diperbarui.');
    }

    public function destroy(ChecklistQualityItem $checklistQualityItem)
    {
        $checklistQualityItem->delete();
        return redirect()->route('admin.checklist-quality.index')->with('success', 'Checklist kualitas berhasil dihapus.');
    }
}
