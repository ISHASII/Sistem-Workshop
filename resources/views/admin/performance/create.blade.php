@extends('layouts.admin')

@section('title', 'Tambah Performance')

@section('content')
    <div class="bg-white rounded-lg shadow p-6 w-full mx-auto">
        <h2 class="text-2xl font-semibold mb-4">Tambah Performance</h2>

        <form action="{{ route('admin.performance.store') }}" method="POST" id="performance-form">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm text-slate-600 mb-1">NRP Manpower</label>
                    <select name="nrp" id="nrp"
                        class="w-full border rounded px-3 py-2 @error('nrp') border-red-500 @enderror" required>
                        <option value="">-- Pilih NRP --</option>
                        @foreach($manpowers as $mp)
                            <option value="{{ $mp->nrp }}" data-nama="{{ $mp->nama }}" {{ old('nrp') == $mp->nrp ? 'selected' : '' }}>
                                {{ $mp->nrp }} - {{ $mp->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('nrp') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm text-slate-600 mb-1">Nama</label>
                    <input type="text" id="nama" class="w-full border rounded px-3 py-2 bg-slate-50" value="" readonly>
                </div>
                <div>
                    <label class="block text-sm text-slate-600 mb-1">Project (Job Order)</label>
                    <select name="job_order_id"
                        class="w-full border rounded px-3 py-2 @error('job_order_id') border-red-500 @enderror">
                        <option value="">-- Tanpa Project --</option>
                        @foreach($joborders as $jo)
                            <option value="{{ $jo->id }}" {{ old('job_order_id') == $jo->id ? 'selected' : '' }}>
                                #{{ $jo->id }} - {{ $jo->project }}
                            </option>
                        @endforeach
                    </select>
                    @error('job_order_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="border rounded p-4 mb-4">
                <h3 class="font-semibold mb-3">Checklist Kualitas</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    @php
                        $selectedIds = old('checklist_quality_item_ids', []);
                    @endphp
                    @forelse($checklistItems as $item)
                        <label class="flex items-center space-x-2 p-2 rounded hover:bg-slate-50">
                            <input type="checkbox" name="checklist_quality_item_ids[]" value="{{ $item->id }}"
                                class="check-item" {{ in_array($item->id, $selectedIds) ? 'checked' : '' }}>
                            <span>{{ $item->name }}</span>
                        </label>
                    @empty
                        <div class="text-sm text-slate-500">Checklist kualitas belum tersedia. Silakan tambah di menu Master
                            Data.</div>
                    @endforelse
                </div>
            </div>

            <div class="flex items-center justify-between mt-4">
                <div>
                    <span class="text-sm text-slate-600">Perkiraan Score:</span>
                    <span id="score-preview" class="font-semibold">0%</span>
                </div>
                <div class="space-x-2">
                    <a href="{{ route('admin.performance.index') }}" class="px-4 py-2 border rounded">Batal</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        const nrpSel = document.getElementById('nrp');
        const namaEl = document.getElementById('nama');
        function syncNama() {
            const opt = nrpSel.options[nrpSel.selectedIndex];
            namaEl.value = opt ? (opt.getAttribute('data-nama') || '') : '';
        }
        nrpSel.addEventListener('change', syncNama);
        syncNama();

        const checks = document.querySelectorAll('.check-item');
        const scoreEl = document.getElementById('score-preview');
        function updateScore() {
            let total = checks.length, ok = 0;
            checks.forEach(c => { if (c.checked) ok++; });
            const score = total > 0 ? Math.round((ok / total) * 100) : 0;
            scoreEl.textContent = score + '%';
        }
        checks.forEach(c => c.addEventListener('change', updateScore));
        updateScore();
    </script>
@endsection