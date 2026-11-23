@extends('layouts.Alfito')

@section('title', 'Detail Membership Plan | Alfito Fitness')

@section('content')
    <p class="eyebrow">ADMINISTRATION</p>
    <h1>{{ $plan->name }}</h1>
    <div class="card">
        <p><strong>Nama Paket:</strong> {{ $plan->name }}</p>
        <p><strong>Durasi:</strong> {{ $plan->duration_months }} Bulan</p>
        <p><strong>Harga:</strong> Rp {{ number_format((float) $plan->price, 0, ',', '.') }}</p>
        <p><strong>Status:</strong> {{ $plan->is_active ? 'Aktif' : 'Nonaktif' }}</p>
        <a href="{{ route('admin.plans.index') }}">Kembali</a>
    </div>
@endsection
