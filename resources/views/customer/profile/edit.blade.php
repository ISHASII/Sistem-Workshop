@extends('layouts.customer')

@section('title', 'Profil Saya')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold">Edit Profil</h2>
            <a href="{{ route('customer.dashboard') }}" class="inline-flex items-center px-3 py-2 bg-slate-100 text-slate-700 rounded-md">Kembali</a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded text-sm">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded text-sm text-red-700">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    <form id="profileForm" action="{{ route('customer.profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all duration-200">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Username</label>
                <input type="text" name="username" value="{{ old('username', $user->username) }}" required class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all duration-200">
                <p class="text-xs text-slate-400 mt-1">Username unik yang dipakai untuk login.</p>
            </div>

            <div class="pt-4 border-t border-slate-100">
                <div class="text-sm font-medium text-slate-700 mb-2">Ubah Password (opsional)</div>
                <div class="grid grid-cols-1 gap-3">
                    <div>
                        <label class="block text-sm mb-1">Current Password</label>
                        <div class="relative">
                            <input id="current_password" type="password" name="current_password" autocomplete="current-password" class="w-full pr-12 px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all duration-200">
                            <button type="button" data-toggle-target="current_password" class="absolute right-2 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 toggle-password z-10 pointer-events-auto" aria-label="Toggle current password visibility">
                                <svg class="eye-open w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg class="eye-closed w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.223-3.396M6.1 6.1A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.98 9.98 0 01-4.1 5.2M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm mb-1">New Password</label>
                        <div class="relative">
                            <input id="new_password" type="password" name="password" autocomplete="new-password" class="w-full pr-12 px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all duration-200">
                            <button type="button" data-toggle-target="new_password" class="absolute right-2 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 toggle-password z-10 pointer-events-auto" aria-label="Toggle new password visibility">
                                <svg class="eye-open w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg class="eye-closed w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.223-3.396M6.1 6.1A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.98 9.98 0 01-4.1 5.2M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                        <p class="text-xs text-slate-400 mt-1">Minimum 8 karakter. Kosongkan jika tidak ingin mengubah.</p>
                    </div>
                    <div>
                        <label class="block text-sm mb-1">Confirm New Password</label>
                        <div class="relative">
                            <input id="confirm_password" type="password" name="password_confirmation" autocomplete="new-password" class="w-full pr-12 px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all duration-200">
                            <button type="button" data-toggle-target="confirm_password" class="absolute right-2 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 toggle-password z-10 pointer-events-auto" aria-label="Toggle confirm password visibility">
                                <svg class="eye-open w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg class="eye-closed w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.223-3.396M6.1 6.1A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.98 9.98 0 01-4.1 5.2M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('customer.dashboard') }}" class="px-4 py-2 mr-2 bg-slate-100 text-slate-700 rounded-md">Batal</a>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function registerPasswordToggles(){
        function bindToggles() {
            document.querySelectorAll('.toggle-password').forEach(function(btn) {
                if (btn.dataset.toggleBound) return;
                btn.dataset.toggleBound = '1';

                btn.addEventListener('click', function () {
                    const targetId = btn.getAttribute('data-toggle-target');
                    const input = document.getElementById(targetId);
                    if (!input) return;

                    const eyeOpen = btn.querySelector('.eye-open');
                    const eyeClosed = btn.querySelector('.eye-closed');

                    if (input.type === 'password') {
                        input.type = 'text';
                        if (eyeOpen) eyeOpen.classList.add('hidden');
                        if (eyeClosed) eyeClosed.classList.remove('hidden');
                    } else {
                        input.type = 'password';
                        if (eyeOpen) eyeOpen.classList.remove('hidden');
                        if (eyeClosed) eyeClosed.classList.add('hidden');
                    }
                });
            });
        }

        try { bindToggles(); } catch(e) { /* ignore */ }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', bindToggles);
        } else {
            bindToggles();
        }
    })();
</script>
<script>
    (function(){
        const form = document.getElementById('profileForm');
        if (!form) return;

        form.addEventListener('submit', function(e){
            const newPwd = document.getElementById('new_password');
            const currentPwd = document.getElementById('current_password');

            if (newPwd && newPwd.value.trim() !== '' ) {
                if (!currentPwd || currentPwd.value.trim() === '') {
                    e.preventDefault();
                    alert('Silakan masukkan Current Password sebelum mengganti password.');
                    if (currentPwd) currentPwd.focus();
                    return false;
                }
            }
        });
    })();
</script>
@endpush
