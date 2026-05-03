@extends('layouts.management-epp')

@section('title', 'Request Approval')

@section('content')
    <div class="space-y-6">
        <div class="rounded-[2rem] bg-white shadow-xl border border-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Request Approval JO</h1>
                    <p class="text-sm text-slate-500">Departement {{ $user->departement->name ?? '-' }} | Request by,
                        tanggal, dan status approval.</p>
                </div>
                <div class="flex gap-2 text-sm font-semibold flex-wrap justify-end">
                    <span class="px-3 py-1.5 rounded-full bg-amber-100 text-amber-700">Pending: {{ $pendingCount }}</span>
                    <span class="px-3 py-1.5 rounded-full bg-green-100 text-green-700">Approved: {{ $approvedCount }}</span>
                </div>
            </div>

            <div class="p-6 border-b border-slate-200">
                <form method="GET" class="grid gap-3 md:grid-cols-[1fr_200px_200px_auto]">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari project / seksi"
                        class="w-full rounded-xl border-slate-300 focus:border-orange-500 focus:ring-orange-500" />
                    
                    <select name="department_id" class="w-full rounded-xl border-slate-300 focus:border-orange-500 focus:ring-orange-500">
                        <option value="">Semua Departemen</option>
                        @foreach($departements as $dept)
                            <option value="{{ $dept->id }}" @selected(request('department_id') == $dept->id)>{{ $dept->name }}</option>
                        @endforeach
                    </select>

                    <select name="status"
                        class="w-full rounded-xl border-slate-300 focus:border-orange-500 focus:ring-orange-500">
                        <option value="">Semua Status</option>
                        <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                        <option value="approved" @selected(request('status') === 'approved')>Approved</option>
                    </select>
                    <button class="px-4 py-2 rounded-xl bg-slate-900 text-white font-semibold hover:bg-slate-800 transition-colors">Filter</button>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                Request By</th>
                            <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                Project</th>
                            <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                Tanggal</th>
                            <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Status
                            </th>
                            <th class="px-5 py-3 text-center text-xs font-bold uppercase tracking-wider text-slate-500">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($requests as $request)
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-amber-100 text-amber-700',
                                    'approved' => 'bg-green-100 text-green-700',
                                ][$request->epp_approval_status ?? 'pending'];
                            @endphp
                            <tr>
                                <td class="px-5 py-4">
                                    <div class="font-semibold text-slate-900">{{ $request->creator->name ?? '-' }}</div>
                                    <div class="text-xs text-slate-500">{{ $request->creator->username ?? '' }}</div>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="font-semibold text-slate-900">{{ $request->project }}</div>
                                    <div class="text-xs text-slate-500">{{ $request->seksi ?? '-' }}</div>
                                </td>
                                <td class="px-5 py-4 text-slate-700">
                                    {{ optional($request->approval_requested_at ?? $request->created_at)->format('d M Y, H:i') }}
                                </td>
                                <td class="px-5 py-4"><span
                                        class="px-3 py-1.5 rounded-full text-xs font-bold {{ $statusClasses }}">{{ strtoupper($request->epp_approval_status ?? 'pending') }}</span>
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <div class="inline-flex flex-wrap items-center justify-center gap-2">
                                        @include('admin.partials.action-buttons', [
                                            'showRoute' => route('management-epp.requests.show', $request),
                                            'pdfRoute' => route('management-epp.requests.exportPdf', $request) . '?stream=1',
                                            'labelAlign' => 'center',
                                        ])
                                        @if(($request->epp_approval_status ?? 'pending') === 'pending')
                                            <div class="flex flex-col items-center text-center" style="display:flex;flex-direction:column;align-items:center;text-align:center;">
                                                <button type="button"
                                                    class="js-approve text-green-600 hover:text-green-800 hover:bg-green-100 rounded-md transition-all duration-200" style="padding:8px;"
                                                    data-url="{{ route('management-epp.requests.approve', $request) }}"
                                                    data-project="{{ $request->project }}"
                                                    title="Approve">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </button>
                                                <span class="text-xs text-slate-600" style="margin-top:4px;">Approve</span>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-10 text-center text-slate-500">Belum ada request.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-slate-200">
                {{ $requests->links() }}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function submitAction(url, reason = null) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = url;

            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken;
            form.appendChild(csrfInput);

            if (reason !== null) {
                const reasonInput = document.createElement('input');
                reasonInput.type = 'hidden';
                reasonInput.name = 'rejection_reason';
                reasonInput.value = reason;
                form.appendChild(reasonInput);
            }

            document.body.appendChild(form);
            form.submit();
        }

        document.querySelectorAll('.js-approve').forEach((button) => {
            button.addEventListener('click', () => {
                const project = button.dataset.project || 'request ini';
                const url = button.dataset.url;

                Swal.fire({
                    title: 'Approve request?',
                    text: `Approve JO "${project}"?`,
                    icon: 'question',
                    showCancelButton: true,
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-xl font-semibold hover:bg-green-700 focus:outline-none',
                        cancelButton: 'inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 focus:outline-none'
                    },
                    confirmButtonText: 'Yes, approve',
                    cancelButtonText: 'Cancel',
                    didOpen: () => {
                        const confirmButton = Swal.getConfirmButton();
                        const cancelButton = Swal.getCancelButton();

                        if (confirmButton) {
                            confirmButton.style.backgroundColor = '#16a34a';
                            confirmButton.style.color = '#ffffff';
                            confirmButton.style.borderRadius = '0.75rem';
                            confirmButton.style.fontWeight = '600';
                            confirmButton.style.boxShadow = '0 1px 2px 0 rgb(0 0 0 / 0.05)';
                        }

                        if (cancelButton) {
                            cancelButton.style.backgroundColor = '#f3f4f6';
                            cancelButton.style.color = '#374151';
                            cancelButton.style.borderRadius = '0.75rem';
                            cancelButton.style.fontWeight = '600';
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        submitAction(url);
                    }
                });
            });
        });

        // js-reject removed

        @if(session('success'))
            Swal.fire({
                title: 'Success!',
                text: @json(session('success')),
                icon: 'success',
                confirmButtonText: 'OK',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'px-6 py-2 !bg-green-600 !text-white rounded-lg font-semibold hover:bg-green-700 focus:ring-2 focus:ring-green-500'
                },
                didOpen: () => {
                    const confirmButton = Swal.getConfirmButton();
                    if (confirmButton) {
                        confirmButton.style.backgroundColor = '#16a34a';
                        confirmButton.style.color = '#ffffff';
                        confirmButton.style.borderRadius = '0.75rem';
                        confirmButton.style.fontWeight = '600';
                    }
                }
            });
        @endif

        @if(session('error'))
            Swal.fire({
                title: 'Error!',
                text: @json(session('error')),
                icon: 'error',
                confirmButtonText: 'OK',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'inline-flex items-center gap-2 px-4 py-2 bg-rose-600 text-white rounded-xl font-semibold hover:bg-rose-700 focus:outline-none'
                },
                didOpen: () => {
                    const confirmButton = Swal.getConfirmButton();
                    if (confirmButton) {
                        confirmButton.style.backgroundColor = '#e11d48';
                        confirmButton.style.color = '#ffffff';
                        confirmButton.style.borderRadius = '0.75rem';
                        confirmButton.style.fontWeight = '600';
                    }
                }
            });
        @endif
    </script>
@endsection
