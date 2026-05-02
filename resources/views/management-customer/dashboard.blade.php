@extends('layouts.management-customer')

@section('title', 'Dashboard Management Customer')

@section('content')
    <div class="space-y-6">
        <div class="rounded-[2rem] overflow-hidden bg-white shadow-xl border border-orange-100">
            <div class="p-8 sm:p-10 bg-gradient-to-br from-orange-600 via-red-600 to-rose-600 text-white">
                <p class="text-sm uppercase tracking-[0.3em] text-orange-100">Management Customer</p>
                <h1 class="mt-3 text-3xl sm:text-4xl font-black">Welcome, {{ $user->name ?? $user->username }}</h1>
                <p class="mt-3 max-w-2xl text-orange-50">Ini adalah halaman khusus Management Customer. Gunakan navbar untuk membuka dashboard atau request approval dari customer di departement Anda.</p>

                <div class="mt-6 flex flex-wrap gap-3 text-sm">
                    <span class="px-3 py-1.5 rounded-full bg-white/15 border border-white/15">Departement: {{ $user->departement->name ?? '-' }}</span>
                    <span class="px-3 py-1.5 rounded-full bg-white/15 border border-white/15">Jabatan: {{ $user->jabatan->name ?? '-' }}</span>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-6">
            <div class="rounded-[2rem] bg-white shadow-xl border border-slate-200 p-6 sm:p-8">
                <h2 class="text-xl font-bold text-slate-900">Ringkasan Request</h2>
                <div class="mt-5 grid grid-cols-2 gap-4">
                    <div class="rounded-2xl bg-orange-50 border border-orange-100 p-4">
                        <div class="text-sm font-semibold text-orange-700">Total</div>
                        <div class="mt-2 text-3xl font-black text-slate-900">{{ $totalCount }}</div>
                    </div>
                    <div class="rounded-2xl bg-amber-50 border border-amber-100 p-4">
                        <div class="text-sm font-semibold text-amber-700">Pending</div>
                        <div class="mt-2 text-3xl font-black text-slate-900">{{ $pendingCount }}</div>
                    </div>
                    <div class="rounded-2xl bg-green-50 border border-green-100 p-4">
                        <div class="text-sm font-semibold text-green-700">Approved</div>
                        <div class="mt-2 text-3xl font-black text-slate-900">{{ $approvedCount }}</div>
                    </div>
                    <div class="rounded-2xl bg-rose-50 border border-rose-100 p-4">
                        <div class="text-sm font-semibold text-rose-700">Rejected</div>
                        <div class="mt-2 text-3xl font-black text-slate-900">{{ $rejectedCount }}</div>
                    </div>
                </div>
            </div>

            <div class="rounded-[2rem] bg-slate-950 text-white shadow-xl p-6 sm:p-8">
                <p class="text-sm uppercase tracking-[0.25em] text-orange-100">Quick Access</p>
                <h3 class="mt-2 text-2xl font-black">Buka Request Approval</h3>
                <p class="mt-3 text-slate-300">Lihat request pending dari customer di departement Anda dan lakukan approve atau reject.</p>
                <a href="{{ route('management-customer.requests.index') }}" class="mt-6 inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-white text-slate-900 font-semibold hover:bg-orange-50 transition-colors">
                    Ke Halaman Request
                </a>
            </div>
        </div>

        <div class="rounded-[2rem] bg-white shadow-xl border border-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-slate-900">Request Terbaru</h2>
                    <p class="text-sm text-slate-500">Permintaan approval dari customer di departement Anda</p>
                </div>
                <a href="{{ route('management-customer.requests.index') }}" class="text-sm font-semibold text-orange-700 hover:text-orange-800">Lihat Semua</a>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($recentRequests as $request)
                    <div class="p-5 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <h3 class="font-bold text-slate-900">{{ $request->project }}</h3>
                                @php
                                    $badge = [
                                        'pending' => 'bg-amber-100 text-amber-700',
                                        'approved' => 'bg-green-100 text-green-700',
                                        'rejected' => 'bg-rose-100 text-rose-700',
                                    ][$request->approval_status ?? 'pending'];
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $badge }}">{{ strtoupper($request->approval_status ?? 'pending') }}</span>
                            </div>
                            <p class="mt-1 text-sm text-slate-600">Request by {{ $request->creator->name ?? '-' }} pada {{ optional($request->approval_requested_at ?? $request->created_at)->format('d M Y, H:i') }}</p>
                        </div>
                        <a href="{{ route('management-customer.requests.index') }}" class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-slate-900 text-white text-sm font-semibold">Buka Request</a>
                    </div>
                @empty
                    <div class="p-8 text-center text-slate-500">Belum ada request approval.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
