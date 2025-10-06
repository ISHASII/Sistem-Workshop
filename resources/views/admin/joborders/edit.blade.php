@extends('layouts.admin')

@section('title', 'Edit Job Order')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-4 sm:py-8">
    <div class="max-w-4xl mx-auto px-2 sm:px-4">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-800 mb-2">Edit Job Order</h1>
                    <p class="text-slate-600">Perbarui detail job order di bawah</p>
                </div>
                <a href="{{ route('admin.joborder.index') }}" class="inline-flex items-center px-4 py-2 bg-white text-slate-600 rounded-xl border border-slate-200 hover:bg-slate-50 hover:text-red-600 transition-all duration-200 shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Daftar
                </a>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl shadow-slate-900/5 border border-slate-200/50 overflow-hidden">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-red-500 to-red-600 p-6">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-white">Informasi Job Order</h3>
                        <p class="text-red-100 text-sm">Edit field sesuai kebutuhan</p>
                    </div>
                </div>
            </div>

            <!-- Form Body -->
            <form action="{{ route('admin.joborder.update', $joborder->id) }}" method="POST" class="p-8">
                @csrf
                @method('PUT')

                <!-- Project Information Section -->
                <div class="mb-8">
                    <div class="flex items-center mb-6">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-slate-800">Detail Proyek</h4>
                            <p class="text-sm text-slate-500">Informasi proyek dasar dan prioritas</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Seksi
                                </span>
                            </label>
                            <div class="relative">
                                <input name="seksi" type="text"
                                       class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all duration-200"
                                       placeholder="Enter department/section"
                                       value="{{ old('seksi', $joborder->seksi) }}">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Status Prioritas
                                </span>
                            </label>
                            <div class="relative">
                                <select name="status" class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all duration-200 appearance-none">
                                    <option value="Low" {{ $joborder->status == 'Low' ? 'selected' : '' }}>Low</option>
                                    <option value="Medium" {{ $joborder->status == 'Medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="High" {{ $joborder->status == 'High' ? 'selected' : '' }}>High</option>
                                    <option value="Urgent" {{ $joborder->status == 'Urgent' ? 'selected' : '' }}>Urgent</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9l-7 7l-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="form-group md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    Nama Proyek
                                </span>
                            </label>
                            <div class="relative">
                                <input name="project" type="text"
                                       class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all duration-200"
                                       placeholder="Masukkan nama proyek"
                                       value="{{ old('project', $joborder->project) }}">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Timeline Section -->
                <div class="mb-8">
                    <div class="flex items-center mb-6">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-slate-800">Timeline</h4>
                            <p class="text-sm text-slate-500">Tanggal mulai dan selesai proyek</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                    Tanggal Mulai
                                </span>
                            </label>
                            <div class="relative">
                    <input name="start" type="text"
                        class="datepicker w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all duration-200"
                        placeholder="Pilih tanggal mulai"
                        autocomplete="off"
                        value="{{ old('start', $joborder->start) }}">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                                    </svg>
                                    Tanggal Selesai
                                </span>
                            </label>
                            <div class="relative">
                    <input name="end" type="text"
                        class="datepicker w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all duration-200"
                        placeholder="Pilih tanggal selesai"
                        autocomplete="off"
                        value="{{ old('end', $joborder->end) }}">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Materials Section -->
                <div class="mb-8">
                    <div class="flex items-center mb-6">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-slate-800">Material & Spesifikasi</h4>
                            <p class="text-sm text-slate-500">Material yang dibutuhkan dan jumlahnya</p>
                        </div>
                    </div>

                    <div id="items-wrapper" class="space-y-4">
                        @php $index = 0; @endphp
                        @foreach($joborder->items as $it)
                        <div class="item-row grid grid-cols-1 md:grid-cols-12 gap-4 p-4 border border-slate-200 rounded-xl bg-slate-50">
                            <input type="hidden" name="items[{{ $index }}][id]" value="{{ $it->id }}" />
                            <div class="md:col-span-4">
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Material</label>
                                <select name="items[{{ $index }}][material_id]" class="material-select w-full px-3 py-2 bg-white border-2 border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/10 transition-all duration-200">
                                    <option value="">Pilih material</option>
                                    @foreach($materials as $m)
                                        <option value="{{ $m->id }}" data-unit="{{ $m->satuan ? $m->satuan->nama : '' }}" data-notes="{{ $m->spesifikasi }}" {{ $it->material_id == $m->id ? 'selected' : '' }}>{{ $m->nama }} @if($m->satuan) ({{ $m->satuan->nama }}) @endif</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Spesifikasi</label>
                                <input name="items[{{ $index }}][spesifikasi]" type="text" class="spec-input w-full px-3 py-2 bg-white border-2 border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/10 transition-all duration-200" placeholder="Spesifikasi" value="{{ $it->spesifikasi }}" />
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Jumlah</label>
                                <input name="items[{{ $index }}][jumlah]" type="number" min="0" step="any" class="w-full px-3 py-2 bg-white border-2 border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/10 transition-all duration-200" placeholder="0" value="{{ $it->jumlah }}" />
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Satuan</label>
                                <input name="items[{{ $index }}][satuan]" type="text" class="unit-input w-full px-3 py-2 bg-white border-2 border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/10 transition-all duration-200" placeholder="pcs/kg/m" value="{{ $it->satuan }}" />
                            </div>
                            <div class="md:col-span-1 flex items-end">
                                <button type="button" class="remove-row px-3 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300">Hapus</button>
                            </div>
                        </div>
                        @php $index++; @endphp
                        @endforeach
                        @if($joborder->items->isEmpty())
                        <div class="item-row grid grid-cols-1 md:grid-cols-12 gap-4 p-4 border border-slate-200 rounded-xl bg-slate-50">
                            <div class="md:col-span-4">
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Material</label>
                                <select name="items[0][material_id]" class="material-select w-full px-3 py-2 bg-white border-2 border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/10 transition-all duration-200">
                                    <option value="">Pilih material</option>
                                    @foreach($materials as $m)
                                        <option value="{{ $m->id }}" data-unit="{{ $m->satuan ? $m->satuan->nama : '' }}" data-notes="{{ $m->spesifikasi }}">{{ $m->nama }} @if($m->satuan) ({{ $m->satuan->nama }}) @endif</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Spesifikasi</label>
                                <input name="items[0][spesifikasi]" type="text" class="spec-input w-full px-3 py-2 bg-white border-2 border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/10 transition-all duration-200" placeholder="Spesifikasi" />
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Jumlah</label>
                                <input name="items[0][jumlah]" type="number" min="0" step="any" class="w-full px-3 py-2 bg-white border-2 border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/10 transition-all duration-200" placeholder="0" />
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Satuan</label>
                                <input name="items[0][satuan]" type="text" class="unit-input w-full px-3 py-2 bg-white border-2 border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/10 transition-all duration-200" placeholder="pcs/kg/m" />
                            </div>
                            <div class="md:col-span-1 flex items-end">
                                <button type="button" class="remove-row hidden px-3 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300">Hapus</button>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="mt-3">
                        <button type="button" id="add-item" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200">+ Tambah Material</button>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-slate-200">
                    <div class="text-sm text-slate-500">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Mohon tinjau semua informasi sebelum menyimpan
                        </span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.joborder.index') }}" class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl hover:bg-slate-200 transition-all duration-200 font-medium">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl hover:from-red-600 hover:to-red-700 shadow-lg shadow-red-500/25 hover:shadow-red-500/40 transition-all duration-200 transform hover:scale-105 font-medium flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.form-group input:focus,
.form-group select:focus {
    transform: translateY(-1px);
}

.form-group {
    transition: all 0.2s ease;
}

.form-group:hover {
    transform: translateY(-1px);
}

@media (max-width: 768px) {
    .form-group {
        margin-bottom: 1rem;
    }
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const wrapper = document.getElementById('items-wrapper');
    const addBtn = document.getElementById('add-item');
    let index = {{ max(1, $joborder->items->count()) }};

    function wireRow(row){
        const select = row.querySelector('.material-select');
        const specInput = row.querySelector('.spec-input');
        const unitInput = row.querySelector('.unit-input');
        const removeBtn = row.querySelector('.remove-row');
        if(select){
            select.addEventListener('change', function(){
                const unit = this.options[this.selectedIndex]?.dataset?.unit || '';
                const notes = this.options[this.selectedIndex]?.dataset?.notes || '';
                if(!unitInput.value){ unitInput.value = unit; }
                if(!specInput.value && notes){ specInput.value = notes; }
            });
        }
        if(removeBtn){
            removeBtn.addEventListener('click', function(){
                row.remove();
                if(wrapper.querySelectorAll('.item-row').length === 0){ addNewRow(); }
            });
        }
    }

    function addNewRow(){
        const template = wrapper.querySelector('.item-row');
        const clone = template.cloneNode(true);
        // Remove hidden id input for new rows
        const hiddenId = clone.querySelector('input[type="hidden"][name*="[id]"]');
        if(hiddenId){ hiddenId.remove(); }
        clone.querySelectorAll('input, select').forEach((el)=>{
            if(el.name){
                el.name = el.name.replace(/items\[\d+\]/, `items[${index}]`);
            }
            if(el.tagName === 'SELECT'){
                el.selectedIndex = 0;
            } else {
                el.value = '';
            }
        });
        const removeBtn = clone.querySelector('.remove-row');
        if(removeBtn){ removeBtn.classList.remove('hidden'); }
        wrapper.appendChild(clone);
        wireRow(clone);
        index++;
    }

    addBtn.addEventListener('click', addNewRow);
    wrapper.querySelectorAll('.item-row').forEach(wireRow);
});
</script>
@endsection
