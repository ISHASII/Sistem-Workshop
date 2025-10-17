@extends('layouts.customer')

@section('title', 'Customer Dashboard')

@section('content')
    <div class="w-full max-w-3xl p-8 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-6 text-center">Customer Dashboard</h2>
        <p class="mb-4">Selamat datang, <span class="font-semibold">{{ auth()->user()->username ?? auth()->user()->name }}</span>!</p>
        <p>Role: <span class="font-semibold">{{ ucfirst(auth()->user()->role) }}</span></p>
    </div>
@endsection
