@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="w-full max-w-3xl p-4 sm:p-8 bg-white rounded shadow mx-auto">
        <h2 class="text-2xl font-bold mb-6 text-center">Admin Dashboard</h2>
        <p class="mb-4">Selamat datang, <span class="font-semibold">{{ auth()->user()->name }}</span>!</p>
        <p>Role: <span class="font-semibold">{{ ucfirst(auth()->user()->role) }}</span></p>
        <!-- Add admin-specific links here -->
        <ul class="mt-4">
            <li><a href="#" class="text-blue-600">Manage users</a></li>
            <li><a href="#" class="text-blue-600">Reports</a></li>
        </ul>
    </div>
@endsection
