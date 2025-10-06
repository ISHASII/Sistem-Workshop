@extends('layouts.admin')

@section('title', 'Detail Performance')

@section('content')
<div class="bg-white rounded-lg shadow p-6 w-full mx-auto">
  <div class="flex items-center justify-between mb-4">
    <h2 class="text-2xl font-semibold">Detail Performance</h2>

    <div class="space-x-2">
      <a href="{{ route('admin.performance.edit', $performance) }}" class="px-3 py-2 bg-amber-100 text-amber-800 rounded">Edit</a>
      <a href="{{ route('admin.performance.index') }}" class="px-3 py-2 border rounded">Kembali</a>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div>
            <div class="text-sm text-slate-500">NRP</div>
            <div class="font-medium">{{ $performance->manpower?->nrp }}</div>
        </div>

        <div>
            <div class="text-sm text-slate-500">Nama</div>
            <div class="font-medium">{{ $performance->manpower?->nama }}</div>
        </div>

        <div>
            <div class="text-sm text-slate-500">Project</div>
            <div class="font-medium">{{ $performance->jobOrder?->project ?? '-' }}</div>
        </div>

        <div>
            <div class="text-sm text-slate-500">Tanggal</div>
            <div class="font-medium">{{ $performance->created_at->format('d-m-Y H:i') }}</div>
        </div>
    </div>

  <div class="border rounded p-4 mb-4">
    <h3 class="font-semibold mb-3">Checklist</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm">
      @php
        $checks = [
          'material_sesuai_jo' => 'Material sesuai JO',
          'dimensi_sesuai_jo' => 'Dimensi sesuai JO',
          'item_sesuai_design' => 'Item sesuai desain',
          'pengelasan_tidak_retak' => 'Pengelasan tidak retak',
          'item_bebas_spatter' => 'Item bebas spatter',
          'baut_terpasang_baik_lengkap' => 'Baut terpasang baik & lengkap',
          'tidak_ada_bagian_tajam' => 'Tidak ada bagian tajam',
          'finishing_standar' => 'Finishing sesuai standar',
          'tidak_ada_kotoran' => 'Bersih dari kotoran/minyak',
          'berfungsi_dengan_baik' => 'Berfungsi dengan baik',
        ];
      @endphp
      @foreach($checks as $name => $label)
        <div class="flex items-center justify-between p-2 rounded border">
          <span>{{ $label }}</span>
          <span class="ml-4 px-2 py-0.5 rounded text-xs {{ $performance->{$name} ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
            {{ $performance->{$name} ? 'Ya' : 'Tidak' }}
          </span>
        </div>
      @endforeach
    </div>
  </div>

  <div class="flex items-center justify-end space-x-3">
    <div>
      <span class="text-sm text-slate-600">Score:</span>
      <span class="font-semibold">{{ $performance->score }}%</span>
    </div>
    <div>
      <span class="text-sm text-slate-600">Rating:</span>
      <span class="px-2 py-1 text-xs rounded-full
        {{ $performance->rating == 'Excellent' ? 'bg-green-100 text-green-800' :
           ($performance->rating == 'Good' ? 'bg-blue-100 text-blue-800' :
           ($performance->rating == 'Average' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')) }}">
        {{ $performance->rating }}
      </span>
    </div>
  </div>
</div>
@endsection
