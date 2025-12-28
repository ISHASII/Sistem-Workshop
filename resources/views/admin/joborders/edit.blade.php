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
                    <a href="{{ route('admin.joborder.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-white text-slate-600 rounded-xl border border-slate-200 hover:bg-slate-50 hover:text-red-600 transition-all duration-200 shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-white">Informasi Job Order</h3>
                            <p class="text-red-100 text-sm">Edit field sesuai kebutuhan</p>
                        </div>
                    </div>
                </div>

                <!-- Form Body -->
                <form action="{{ route('admin.joborder.update', $joborder->id) }}" method="POST" class="p-8"
                    enctype="multipart/form-data">
                    @if ($errors->any())
                        <div class="mb-6">
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <strong class="font-bold">Terjadi kesalahan!</strong>
                                <ul class="mt-2 list-disc list-inside text-sm">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    @csrf
                    @method('PUT')

                    <!-- Project Information Section -->
                    <div class="mb-8">
                        <div class="flex items-center mb-6">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
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
                                        <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                            </path>
                                        </svg>
                                        Seksi
                                    </span>
                                </label>
                                <div class="relative">
                                    <input name="seksi" type="text"
                                        class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all duration-200"
                                        placeholder="Enter department/section" value="{{ old('seksi', $joborder->seksi) }}">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Status Prioritas
                                    </span>
                                </label>
                                <div class="relative">
                                    <select name="status"
                                        class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all duration-200 appearance-none">
                                        <option value="Low" {{ $joborder->status == 'Low' ? 'selected' : '' }}>Low</option>
                                        <option value="Medium" {{ $joborder->status == 'Medium' ? 'selected' : '' }}>Medium
                                        </option>
                                        <option value="High" {{ $joborder->status == 'High' ? 'selected' : '' }}>High</option>
                                        <option value="Urgent" {{ $joborder->status == 'Urgent' ? 'selected' : '' }}>Urgent
                                        </option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="m19 9l-7 7l-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                            </path>
                                        </svg>
                                        Nama Proyek
                                    </span>
                                </label>
                                <div class="relative">
                                    <input name="project" type="text"
                                        class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all duration-200"
                                        placeholder="Masukkan nama proyek" value="{{ old('project', $joborder->project) }}">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Info: Area, Latar Belakang, Tujuan, Target -->
                    <div class="mb-8">
                        <div class="flex items-center mb-6">
                            <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-slate-800">Informasi Tambahan</h4>
                                <p class="text-sm text-slate-500">Area, latar belakang, tujuan, dan target proyek</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="form-group">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Area</label>
                                <input name="area" type="text" value="{{ old('area', $joborder->area) }}"
                                    class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800"
                                    placeholder="Masukkan area proyek" />
                            </div>

                            <div class="form-group">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Target</label>
                                <input name="target" type="text" value="{{ old('target', $joborder->target) }}"
                                    class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800"
                                    placeholder="Contoh: Selesai 2 minggu" />
                            </div>

                            <div class="form-group md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Latar Belakang</label>
                                <textarea name="latar_belakang"
                                    class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800"
                                    rows="4"
                                    placeholder="Jelaskan latar belakang proyek">{{ old('latar_belakang', $joborder->latar_belakang) }}</textarea>
                            </div>

                            <div class="form-group md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Tujuan</label>
                                <textarea name="tujuan"
                                    class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800"
                                    rows="3"
                                    placeholder="Tujuan dari pekerjaan ini">{{ old('tujuan', $joborder->tujuan) }}</textarea>
                            </div>

                            <div class="form-group md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Gambar (multiple)</label>
                                <div id="image-inputs-edit" class="space-y-2">
                                    <div class="image-input-row flex items-start space-x-3">
                                        <input class="image-input-edit" name="images[]" type="file" accept="image/*" />
                                        <div class="flex-1">
                                            <div class="images-preview-edit grid grid-cols-3 gap-3" data-preview-id="0">
                                            </div>
                                        </div>
                                        <button type="button"
                                            class="remove-image-input-edit hidden px-2 py-1 bg-slate-100 text-red-600 rounded">&times;</button>
                                    </div>
                                </div>
                                <div class="mt-2 flex items-center space-x-3">
                                    <button type="button" id="add-image-input-edit"
                                        class="px-3 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200">+ Tambah
                                        Gambar</button>
                                    <p class="text-xs text-slate-400">Anda dapat menambahkan beberapa input gambar; setiap
                                        input punya preview dan tombol hapus.</p>
                                </div>
                            </div>

                            <div class="form-group md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Gambar Saat Ini</label>
                                <div id="existing-images" class="grid grid-cols-3 gap-3">
                                    @if(is_array($joborder->images ?? null) && count($joborder->images))
                                        @foreach($joborder->images as $i => $img)
                                            <div class="relative border rounded overflow-hidden existing-image-slot"
                                                data-img-index="{{ $i }}">
                                                <img src="{{ asset($img) }}" class="object-cover w-full h-24" />
                                                <button type="button"
                                                    class="remove-existing absolute top-1 right-1 bg-white/80 text-red-600 rounded-full p-1 border"
                                                    data-img="{{ $img }}">&times;</button>
                                                <input type="hidden" name="existing_images[{{ $i }}]" value="{{ $img }}" />
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-xs text-slate-400">Tidak ada gambar.</div>
                                    @endif
                                </div>
                                {{-- container to hold names of removed images to send to server --}}
                                <div id="removed-images-inputs"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Timeline Section -->
                    <div class="mb-8">
                        <div class="flex items-center mb-6">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
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
                                        <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                                            </path>
                                        </svg>
                                        Tanggal Mulai
                                    </span>
                                </label>
                                <div class="relative">
                                    <input name="start" type="text"
                                        class="datepicker w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all duration-200"
                                        placeholder="Pilih tanggal mulai" autocomplete="off"
                                        data-date="{{ old('start', $joborder->start ?? '') }}">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                                            </path>
                                        </svg>
                                        Tanggal Selesai
                                    </span>
                                </label>
                                <div class="relative">
                                    <input name="end" type="text"
                                        class="datepicker w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all duration-200"
                                        placeholder="Pilih tanggal selesai" autocomplete="off"
                                        data-date="{{ old('end', $joborder->end ?? '') }}">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
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
                                <div
                                    class="item-row grid grid-cols-1 md:grid-cols-12 gap-4 p-4 border border-slate-200 rounded-xl bg-slate-50">
                                    <input type="hidden" name="items[{{ $index }}][id]" value="{{ $it->id }}" />
                                    <div class="md:col-span-4">
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">Material</label>
                                        <select name="items[{{ $index }}][material_id]"
                                            class="material-select w-full px-3 py-2 bg-white border-2 border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/10 transition-all duration-200">
                                            <option value="">Pilih material</option>
                                            @foreach($materials as $m)
                                                <option value="{{ $m->id }}" data-unit="{{ $m->satuan ? $m->satuan->name : '' }}"
                                                    data-notes="{{ $m->spesifikasi }}"
                                                    data-stok="{{ method_exists($m, 'getCurrentStok') ? $m->getCurrentStok() : $m->jumlah }}"
                                                    {{ $it->material_id == $m->id ? 'selected' : '' }}>
                                                    {{ $m->nama }}@if($m->satuan && $m->satuan->name) ({{ $m->satuan->name }})@endif
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="md:col-span-3">
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">Spesifikasi</label>
                                        <input name="items[{{ $index }}][spesifikasi]" type="text"
                                            class="spec-input w-full px-3 py-2 bg-white border-2 border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/10 transition-all duration-200"
                                            placeholder="Spesifikasi" value="{{ $it->spesifikasi }}" />
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">Jumlah</label>
                                        <input name="items[{{ $index }}][jumlah]" type="number" min="0" step="any"
                                            class="w-full px-3 py-2 bg-white border-2 border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/10 transition-all duration-200"
                                            placeholder="0" value="{{ $it->jumlah }}" />
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">Satuan</label>
                                        <input name="items[{{ $index }}][satuan]" type="text"
                                            class="unit-input w-full px-3 py-2 bg-white border-2 border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/10 transition-all duration-200"
                                            placeholder="pcs/kg/m" value="{{ $it->satuan }}" readonly />
                                    </div>
                                    <div class="md:col-span-1">
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">Stok</label>
                                        <input type="text"
                                            class="stok-input w-full px-3 py-2 bg-white border-2 border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/10 transition-all duration-200"
                                            placeholder="0"
                                            value="{{ $it->material ? (method_exists($it->material, 'getCurrentStok') ? $it->material->getCurrentStok() : $it->material->jumlah) : '' }}"
                                            readonly />
                                    </div>
                                    <div class="md:col-span-1 flex items-end">
                                        <button type="button"
                                            class="remove-row px-3 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300">Hapus</button>
                                    </div>
                                </div>
                                @php $index++; @endphp
                            @endforeach
                            @if($joborder->items->isEmpty())
                                <div
                                    class="item-row grid grid-cols-1 md:grid-cols-12 gap-4 p-4 border border-slate-200 rounded-xl bg-slate-50">
                                    <div class="md:col-span-4">
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">Material</label>
                                        <select name="items[0][material_id]"
                                            class="material-select w-full px-3 py-2 bg-white border-2 border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/10 transition-all duration-200">
                                            <option value="">Pilih material</option>
                                            @foreach($materials as $m)
                                                <option value="{{ $m->id }}" data-unit="{{ $m->satuan ? $m->satuan->name : '' }}"
                                                    data-notes="{{ $m->spesifikasi }}"
                                                    data-stok="{{ method_exists($m, 'getCurrentStok') ? $m->getCurrentStok() : $m->jumlah }}">
                                                    {{ $m->nama }}@if($m->satuan && $m->satuan->name) ({{ $m->satuan->name }})@endif
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="md:col-span-3">
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">Spesifikasi</label>
                                        <input name="items[0][spesifikasi]" type="text"
                                            class="spec-input w-full px-3 py-2 bg-white border-2 border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/10 transition-all duration-200"
                                            placeholder="Spesifikasi" />
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">Jumlah</label>
                                        <input name="items[0][jumlah]" type="number" min="0" step="any"
                                            class="w-full px-3 py-2 bg-white border-2 border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/10 transition-all duration-200"
                                            placeholder="0" />
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">Satuan</label>
                                        <input name="items[0][satuan]" type="text"
                                            class="unit-input w-full px-3 py-2 bg-white border-2 border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/10 transition-all duration-200"
                                            placeholder="pcs/kg/m" readonly />
                                    </div>
                                    <div class="md:col-span-1">
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">Stok</label>
                                        <input type="text"
                                            class="stok-input w-full px-3 py-2 bg-white border-2 border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/10 transition-all duration-200"
                                            placeholder="0" readonly />
                                    </div>
                                    <div class="md:col-span-1 flex items-end">
                                        <button type="button"
                                            class="remove-row hidden px-3 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300">Hapus</button>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="mt-3">
                            <button type="button" id="add-item"
                                class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200">+ Tambah
                                Material</button>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between pt-6 border-t border-slate-200">
                        <div class="text-sm text-slate-500">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Mohon tinjau semua informasi sebelum menyimpan
                            </span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('admin.joborder.index') }}" id="cancelBtn" data-swal-cancel
                                class="px-6 py-3 bg-slate-200 text-slate-800 rounded-xl hover:bg-slate-300 transition-all duration-200 font-medium">
                                Batal
                            </a>
                            <button type="submit"
                                class="px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl hover:from-red-600 hover:to-red-700 shadow-lg shadow-red-500/25 hover:shadow-red-500/40 transition-all duration-200 transform hover:scale-105 font-medium flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
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
        document.addEventListener('DOMContentLoaded', function () {
            const wrapper = document.getElementById('items-wrapper');
            const addBtn = document.getElementById('add-item');
            let index = {{ max(1, $joborder->items->count()) }};

            // Validasi stok sebelum submit
            const form = document.querySelector('form');
            form.addEventListener('submit', function (e) {
                let valid = true;
                let message = '';
                wrapper.querySelectorAll('.item-row').forEach(function (row, idx) {
                    const jumlahInput = row.querySelector('input[type="number"]');
                    const stokInput = row.querySelector('.stok-input');
                    if (jumlahInput && stokInput) {
                        const jumlah = parseFloat(jumlahInput.value || '0');
                        const stok = parseFloat(stokInput.value || '0');
                        if (jumlah > stok) {
                            valid = false;
                            message = `Jumlah material pada baris ${idx + 1} melebihi stok tersedia!`;
                        }
                    }
                });
                if (!valid) {
                    e.preventDefault();
                    alert(message || 'Jumlah material melebihi stok tersedia!');
                }
            });

            function wireRow(row) {
                const select = row.querySelector('.material-select');
                const specInput = row.querySelector('.spec-input');
                const unitInput = row.querySelector('.unit-input');
                const stokInput = row.querySelector('.stok-input');
                const removeBtn = row.querySelector('.remove-row');
                if (select) {
                    select.addEventListener('change', function () {
                        const unit = this.options[this.selectedIndex]?.dataset?.unit || '';
                        const notes = this.options[this.selectedIndex]?.dataset?.notes || '';
                        const stok = this.options[this.selectedIndex]?.dataset?.stok || '';
                        if (unitInput) unitInput.value = unit;
                        if (specInput && !specInput.value && notes) specInput.value = notes;
                        if (stokInput) stokInput.value = stok;
                    });
                    // Trigger change on load to autofill if already selected
                    if (select.value) {
                        const event = new Event('change');
                        select.dispatchEvent(event);
                    }
                }
                if (removeBtn) {
                    removeBtn.addEventListener('click', function () {
                        row.remove();
                        if (wrapper.querySelectorAll('.item-row').length === 0) { addNewRow(); }
                    });
                }
            }

            function addNewRow() {
                const template = wrapper.querySelector('.item-row');
                const clone = template.cloneNode(true);
                // Remove hidden id input for new rows
                const hiddenId = clone.querySelector('input[type="hidden"][name*="[id]"]');
                if (hiddenId) { hiddenId.remove(); }
                clone.querySelectorAll('input, select').forEach((el) => {
                    if (el.name) {
                        el.name = el.name.replace(/items\[\d+\]/, `items[${index}]`);
                    }
                    if (el.classList.contains('stok-input')) {
                        el.value = '';
                    } else if (el.tagName === 'SELECT') {
                        el.selectedIndex = 0;
                    } else {
                        el.value = '';
                    }
                });
                const removeBtn = clone.querySelector('.remove-row');
                if (removeBtn) { removeBtn.classList.remove('hidden'); }
                wrapper.appendChild(clone);
                wireRow(clone);
                index++;
            }

            addBtn.addEventListener('click', addNewRow);
            wrapper.querySelectorAll('.item-row').forEach(wireRow);

            // Preview & removal for new uploads (edit form)
            const newImagesInputEdit = document.getElementById('newImagesInputEdit');
            const newPreviewEdit = document.getElementById('new-images-preview-edit');
            if (newImagesInputEdit) {
                newImagesInputEdit.addEventListener('change', function () {
                    newPreviewEdit.innerHTML = '';
                    Array.from(this.files).forEach((file, idx) => {
                        const reader = new FileReader();
                        const slot = document.createElement('div');
                        slot.className = 'relative border rounded overflow-hidden';
                        slot.style.height = '96px';
                        slot.style.display = 'flex';
                        slot.style.alignItems = 'center';
                        slot.style.justifyContent = 'center';
                        const removeBtn = document.createElement('button');
                        removeBtn.type = 'button';
                        removeBtn.className = 'absolute top-1 right-1 bg-white/80 text-red-600 rounded-full p-1 border';
                        removeBtn.innerHTML = '&times;';

                        removeBtn.addEventListener('click', function () {
                            const dt = new DataTransfer();
                            Array.from(newImagesInputEdit.files).forEach((f, i) => { if (i !== idx) dt.items.add(f); });
                            newImagesInputEdit.files = dt.files;
                            slot.remove();
                        });

                        reader.onload = function (e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.className = 'object-cover w-full h-24';
                            slot.appendChild(img);
                            slot.appendChild(removeBtn);
                        }
                        reader.readAsDataURL(file);
                        newPreviewEdit.appendChild(slot);
                    });
                });
            }

            // Remove existing images (mark for deletion)
            document.querySelectorAll('.remove-existing').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    // confirmation before marking image for deletion
                    if (!confirm('Yakin ingin menghapus gambar ini? Tindakan ini akan dihapus saat Anda menyimpan perubahan.')) {
                        return;
                    }
                    const imgPath = this.getAttribute('data-img');
                    const slot = this.closest('.existing-image-slot');
                    // add hidden input to signal server to remove this image
                    const holder = document.getElementById('removed-images-inputs');
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'removed_images[]';
                    input.value = imgPath;
                    holder.appendChild(input);
                    slot.remove();
                });
            });

            // Dynamic image input rows for edit form (reuse wiring for initial rows)
            const imageInputsContainerEdit = document.getElementById('image-inputs-edit');
            const addImageBtnEdit = document.getElementById('add-image-input-edit');
            let imageRowIndexEdit = 1;

            function wireImageInputRowEdit(row) {
                const input = row.querySelector('.image-input-edit');
                const preview = row.querySelector('.images-preview-edit');
                const removeBtn = row.querySelector('.remove-image-input-edit');
                if (!input || !preview) return;

                input.addEventListener('change', function () {
                    preview.innerHTML = '';
                    Array.from(this.files).forEach((file, idx) => {
                        const reader = new FileReader();
                        const slot = document.createElement('div');
                        slot.className = 'relative border rounded overflow-hidden';
                        slot.style.height = '96px';
                        reader.onload = function (e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.className = 'object-cover w-full h-24';
                            slot.appendChild(img);
                            const rb = document.createElement('button'); rb.type = 'button'; rb.className = 'absolute top-1 right-1 bg-white/80 text-red-600 rounded-full p-1 border'; rb.innerHTML = '&times;';
                            rb.addEventListener('click', function () {
                                const dt = new DataTransfer();
                                Array.from(input.files).forEach((f, i) => { if (i !== idx) dt.items.add(f); });
                                input.files = dt.files;
                                slot.remove();
                            });
                            slot.appendChild(rb);
                        };
                        reader.readAsDataURL(file);
                        preview.appendChild(slot);
                    });
                });

                if (removeBtn) { removeBtn.addEventListener('click', function () { row.remove(); }); }
            }

            function createImageRowEdit(index) {
                const row = document.createElement('div');
                row.className = 'image-input-row flex items-start space-x-3';
                row.innerHTML = `
                                                                                                                                                                                                                                            <input class="image-input-edit" name="images[]" type="file" accept="image/*" />
                                                                                                                                                                                                                                            <div class="flex-1">
                                                                                                                                                                                                                                                <div class="images-preview-edit grid grid-cols-3 gap-3" data-preview-id="${index}"></div>
                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                            <button type="button" class="remove-image-input-edit px-2 py-1 bg-slate-100 text-red-600 rounded">&times;</button>
                                                                                                                                                                                                                                        `;
                wireImageInputRowEdit(row);
                return row;
            }

            // Wire existing static rows (initial row in markup)
            imageInputsContainerEdit.querySelectorAll('.image-input-row').forEach(function (r) {
                wireImageInputRowEdit(r);
            });

            addImageBtnEdit.addEventListener('click', function () {
                const r = createImageRowEdit(imageRowIndexEdit++);
                imageInputsContainerEdit.appendChild(r);
            });
        });
    </script>
@endsection
<!-- SweetAlert2 (popup for validation) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Flatpickr: disable already-booked ranges -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    /* Custom styling for booked ranges in flatpickr (distinct from generic disabled) */
    .flatpickr-day.flatpickr-booked-range,
    .flatpickr-day.flatpickr-booked-range:hover {
        background: repeating-linear-gradient(45deg,
                #fee2e2,
                #fee2e2 10px,
                #fecaca 10px,
                #fecaca 20px) !important;
        color: #991b1b !important;
        cursor: not-allowed !important;
        text-decoration: line-through;
        opacity: 0.8 !important;
        position: relative;
        font-weight: bold;
    }

    .flatpickr-day.flatpickr-booked-range::before {
        content: '🔒';
        position: absolute;
        top: 2px;
        right: 2px;
        font-size: 14px;
        pointer-events: none;
        z-index: 10;
    }

    .flatpickr-day:not(.flatpickr-disabled):hover {
        background-color: #dbeafe !important;
        border-color: #3b82f6 !important;
    }

    .flatpickr-day.flatpickr-disabled,
    .flatpickr-day.flatpickr-disabled:hover {
        background: #f1f5f9 !important;
        /* light gray */
        color: #9ca3af !important;
        /* gray text */
        cursor: not-allowed !important;
        opacity: 0.6 !important;
        text-decoration: none !important;
        font-weight: normal;
    }

    .flatpickr-day.selected {
        background-color: #dc2626 !important;
        border-color: #dc2626 !important;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const startError = {!! json_encode($errors->first('start')) !!};
        if (startError) {
            Swal.fire({
                title: 'Terjadi kesalahan!',
                text: startError,
                icon: 'error',
                confirmButtonText: 'Tutup',
                confirmButtonColor: '#dc2626',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-3 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200'
                }
            });
        }

        const booked = @json($bookedRanges ?? []);
        const joborderStart = @json($joborder->start ?? '');
        const joborderEnd = @json($joborder->end ?? '');


        const rawBooked = booked.map(function (r) { return { from: r.from, to: r.to }; }).filter(function (x) { return x && x.from && x.to; });
        rawBooked.sort(function (a, b) { return a.from.localeCompare(b.from); });
        const bookedDateRanges = rawBooked.map(function (r) { try { var pf = String(r.from).split('-'); var pt = String(r.to).split('-'); var fd = new Date(parseInt(pf[0], 10), parseInt(pf[1], 10) - 1, parseInt(pf[2], 10)); var td = new Date(parseInt(pt[0], 10), parseInt(pt[1], 10) - 1, parseInt(pt[2], 10)); td.setHours(23, 59, 59, 999); return { from: fd, to: td }; } catch (e) { return null; } }).filter(function (x) { return !!x; });
        const disabledDateRanges = bookedDateRanges.map(function (br) { return { from: new Date(br.from.getFullYear(), br.from.getMonth(), br.from.getDate()), to: new Date(br.to.getFullYear(), br.to.getMonth(), br.to.getDate()) }; });
        const disabled = rawBooked.slice(0);

        const fpInstances = [];

        document.querySelectorAll('.datepicker').forEach(function (el) {
            const rawDate = (el.getAttribute('data-date') || '').trim();

            let parsedDate = null;
            if (rawDate) {
                // Accept many date formats including datetimes and ISO strings
                parsedDate = parseDateInput(rawDate);
                if (!parsedDate) {
                    // fallback to simple Y-m-d format
                    if (/^\d{4}-\d{2}-\d{2}$/.test(rawDate)) {
                        const [y, m, d] = rawDate.split('-');
                        parsedDate = new Date(parseInt(y), parseInt(m) - 1, parseInt(d));
                    }
                }
            }

            var disableFn = function (date) {
                try { var dd = new Date(date.getFullYear(), date.getMonth(), date.getDate()).getTime(); for (var i = 0; i < bookedDateRanges.length; i++) { var br = bookedDateRanges[i]; if (br && br.from && br.to && dd >= br.from.getTime() && dd <= br.to.getTime()) return true; } } catch (e) { return false; } return false;
            };

            const opts = {
                dateFormat: 'd-m-Y',
                disable: ((disabledDateRanges && disabledDateRanges.length) ? disabledDateRanges.concat([disableFn]) : [disableFn]),
                // Disable manual typing to prevent invalid date formats; rely on calendar selection
                allowInput: false,
                defaultDate: parsedDate,
                onDayCreate: function (dObj, dStr, fp, dayElem) {
                    try {
                        var dd = new Date(dayElem.dateObj.getFullYear(), dayElem.dateObj.getMonth(), dayElem.dateObj.getDate()).getTime();
                        var isBooked = false;
                        for (var k = 0; k < bookedDateRanges.length; k++) {
                            var br = bookedDateRanges[k];
                            if (!br) continue;
                            if (dd >= br.from.getTime() && dd <= br.to.getTime()) {
                                dayElem.classList.add('flatpickr-booked-range');
                                // Do NOT manually add flatpickr-disabled; rely on flatpickr disable logic
                                var fm = br.from.getDate().toString().padStart(2, '0') + '-' + (br.from.getMonth() + 1).toString().padStart(2, '0') + '-' + br.from.getFullYear();
                                var tm = br.to.getDate().toString().padStart(2, '0') + '-' + (br.to.getMonth() + 1).toString().padStart(2, '0') + '-' + br.to.getFullYear();
                                dayElem.setAttribute('title', 'Booked: ' + fm + ' → ' + tm);
                                dayElem.setAttribute('aria-disabled', 'true');
                                dayElem.setAttribute('aria-label', 'Booked: ' + fm + ' to ' + tm + ' (unavailable)');
                                dayElem.setAttribute('tabindex', '-1');
                                dayElem.dataset.bookedFrom = fm;
                                dayElem.dataset.bookedTo = tm;
                                isBooked = true;
                                break;
                            }
                        }
                        if (!isBooked) {
                            dayElem.classList.remove('flatpickr-booked-range');
                            dayElem.removeAttribute('aria-disabled');
                            dayElem.removeAttribute('aria-label');
                            try {
                                if (el && el.name === 'start') {
                                    dayElem.classList.remove('flatpickr-disabled');
                                    dayElem.removeAttribute('tabindex');
                                }
                            } catch (e) { }
                        }
                    } catch (e) { }
                },
                onChange: function (selectedDates, dateStr, instance) {
                },
                onReady: function (dObj, dStr, fp) { try { fp.redraw(); } catch (e) { } try { updateMonthNavigation(fp, getMinDateForFp(el)); } catch (e) { } },
                onOpen: function (dObj, dStr, fp) { try { fp.redraw(); } catch (e) { } try { updateMonthNavigation(fp, getMinDateForFp(el)); } catch (e) { } },
                onMonthChange: function (dObj, dStr, fp) { try { fp.redraw(); } catch (e) { } try { updateMonthNavigation(fp, getMinDateForFp(el)); } catch (e) { } },
                onYearChange: function (dObj, dStr, fp) { try { fp.redraw(); } catch (e) { } try { updateMonthNavigation(fp, getMinDateForFp(el)); } catch (e) { } }
            };

            // If defaultDate was not set but rawDate exists and is parseable, use it
            try {
                if (!parsedDate && rawDate) {
                    var fb = parseDateInput(rawDate);
                    if (fb) { opts.defaultDate = fb; parsedDate = fb; }
                }
            } catch (e) { }

            const fp = flatpickr(el, opts);
            try { updateMonthNavigation(fp, getMinDateForFp(el)); } catch (e) { }
            fpInstances.push({ el: el, instance: fp });
            if (el.name === 'start') {
                window._fpStart = fp;
                el.addEventListener('blur', function () {
                    try {
                        if (!window._fpEnd) return;
                        var endPicker = window._fpEnd;
                        var parsed = parseDateInput(el.value);
                        if (!parsed) { endPicker.set('minDate', null); endPicker.set('maxDate', null); return; }
                        endPicker.set('minDate', parsed);
                        try { endPicker.jumpToDate(parsed); } catch (e) { }
                        var t = new Date(parsed.getFullYear(), parsed.getMonth(), parsed.getDate()).getTime();
                        var ns = null;
                        for (var i = 0; i < bookedDateRanges.length; i++) { var b = bookedDateRanges[i]; if (b && b.from && b.from.getTime() > t) { ns = b.from; break; } }
                        if (ns) { var newMax = new Date(ns.getTime() - 86400000); endPicker.set('maxDate', newMax); try { endPicker.redraw(); } catch (e) { } } else { endPicker.set('maxDate', null); }
                        if (endPicker.selectedDates && endPicker.selectedDates[0] && ns && endPicker.selectedDates[0].getTime() > newMax.getTime()) endPicker.clear();
                        try { updateMonthNavigation(endPicker, getMinDateForFp(document.querySelector('input[name="end"]'))); } catch (e) { }
                    } catch (e) { console.warn('Error updating end on blur (admin edit)', e); }
                });
            }
            if (el.name === 'end') window._fpEnd = fp;
            if (fp && fp.calendarContainer) {
                fp.calendarContainer.addEventListener('click', function (ev) { var day = ev.target.closest('.flatpickr-day.flatpickr-booked-range'); if (day) { ev.preventDefault(); ev.stopImmediatePropagation(); day.classList.add('flatpickr-booked-attempt'); setTimeout(function () { day.classList.remove('flatpickr-booked-attempt'); }, 300); } }, true);
                fp.calendarContainer.addEventListener('keydown', function (ev) { var focused = document.activeElement; if (focused && focused.classList && focused.classList.contains('flatpickr-day') && focused.classList.contains('flatpickr-booked-range')) { if (ev.key === 'Enter' || ev.key === ' ') { ev.preventDefault(); ev.stopImmediatePropagation(); } } }, true);
            }

            if (parsedDate) {
                setTimeout(function () {
                    try { fp.setDate(parsedDate, true); } catch (e) { }
                    try {
                        var ddv = String(parsedDate.getDate()).padStart(2, '0');
                        var mmv = String(parsedDate.getMonth() + 1).padStart(2, '0');
                        var yv = String(parsedDate.getFullYear());
                        el.value = ddv + '-' + mmv + '-' + yv;
                    } catch (e) { }
                }, 100);
            }
            else {
                // If no parsed Date but rawDate is present, attempt to present a formatted value
                try {
                    if (rawDate && (!el.value || !el.value.trim())) {
                        var b = String(rawDate).split(' ')[0].split('T')[0];
                        if (/^\d{4}-\d{2}-\d{2}$/.test(b)) {
                            var [yy, mm2, dd2] = b.split('-');
                            el.value = dd2.padStart(2, '0') + '-' + mm2.padStart(2, '0') + '-' + yy;
                        } else if (/^\d{2}-\d{2}-\d{4}$/.test(b)) {
                            el.value = b;
                        }
                    }
                } catch (er) { }
            }

            if (el.name === 'start') {
                fp.config.onChange.push(function (selectedDates) {
                    try {
                        if (!window._fpEnd) return;
                        var endPicker = window._fpEnd;
                        if (!selectedDates || !selectedDates[0]) { endPicker.set('minDate', null); endPicker.set('maxDate', null); return; }
                        var sel = selectedDates[0];
                        endPicker.set('minDate', sel);
                        try { endPicker.jumpToDate(sel); } catch (e) { }
                        var selTime = new Date(sel.getFullYear(), sel.getMonth(), sel.getDate()).getTime();
                        var ns = null;
                        for (var i = 0; i < bookedDateRanges.length; i++) { var b = bookedDateRanges[i]; if (b && b.from && b.from.getTime() > selTime) { ns = b.from; break; } }
                        if (ns) {
                            var newMax = new Date(ns.getTime() - 86400000);
                            endPicker.set('maxDate', newMax);
                            try { endPicker.redraw(); } catch (e) { }
                            if (endPicker.selectedDates && endPicker.selectedDates[0] && endPicker.selectedDates[0].getTime() > newMax.getTime()) endPicker.clear();
                        } else {
                            endPicker.set('maxDate', null);
                        }
                    } catch (e) { console.warn('Error linking start->end:', e); }
                    try { if (window._fpEnd) updateMonthNavigation(window._fpEnd, getMinDateForFp(document.querySelector('input[name="end"]'))); } catch (e) { }
                });
            }

            function fmtYmd(d) { var y = d.getFullYear(); var m = (d.getMonth() + 1).toString().padStart(2, '0'); var dd = d.getDate().toString().padStart(2, '0'); return y + '-' + m + '-' + dd; }

            function parseDateInput(str) {
                if (!str) return null;
                str = String(str).trim();
                var bare = str.split(' ')[0].split('T')[0];
                if (/^\d{2}-\d{2}-\d{4}$/.test(bare)) { const [dd, mm, yyyy] = bare.split('-'); return new Date(parseInt(yyyy, 10), parseInt(mm, 10) - 1, parseInt(dd, 10)); }
                if (/^\d{4}-\d{2}-\d{2}$/.test(bare)) { const [yyyy, mm, dd] = bare.split('-'); return new Date(parseInt(yyyy, 10), parseInt(mm, 10) - 1, parseInt(dd, 10)); }
                try { return new Date(bare); } catch (e) { return null; }
            }

            function getMinDateForFp(el) {
                if (!el) return null;
                if (el.name === 'start') return null;
                if (el.name === 'end') {
                    const startVal = (document.querySelector('input[name="start"]') || {}).value;
                    if (startVal) return parseDateInput(startVal);
                    return null;
                }
                return null;
            }

            function updateMonthNavigation(fp, minDate) { if (!fp || !fp.calendarContainer) return; const prevBtn = fp.calendarContainer.querySelector('.flatpickr-prev-month'); if (!prevBtn) return; if (!minDate) { prevBtn.style.pointerEvents = ''; prevBtn.style.opacity = ''; return; } const displayedFirst = new Date(fp.currentYear, fp.currentMonth, 1); const minFirst = new Date(minDate.getFullYear(), minDate.getMonth(), 1); if (displayedFirst.getTime() <= minFirst.getTime()) { prevBtn.style.pointerEvents = 'none'; prevBtn.style.opacity = '0.45'; } else { prevBtn.style.pointerEvents = ''; prevBtn.style.opacity = ''; } }
        });

        const formEl = document.querySelector('form');
        if (formEl) {
            formEl.addEventListener('submit', function () {
                document.querySelectorAll('.datepicker').forEach(function (el) {
                    const inst = el._flatpickr;
                    if (inst && inst.selectedDates && inst.selectedDates[0]) {
                        const d = inst.selectedDates[0];
                        const dd = String(d.getDate()).padStart(2, '0');
                        const mm = String(d.getMonth() + 1).padStart(2, '0');
                        const yyyy = String(d.getFullYear());

                        el.value = dd + '-' + mm + '-' + yyyy;
                        // Converted submit value logging removed
                    }
                });
            });
        }
    });
</script>