@extends('layouts.Alfito')

@section('title', 'Detail Trainer | Alfito Fitness')

@section('content')
    <p class="eyebrow">ADMINISTRATION</p>
    <h1>{{ $trainer->name }}</h1>
    <div class="card">
        <p><strong>Nama:</strong> {{ $trainer->name }}</p>
        <p><strong>Specialization:</strong> {{ $trainer->specialization }}</p>
        <p><strong>Lokasi Cabang:</strong> {{ $trainer->location->name ?? '-' }}</p>
        <a href="{{ route('admin.trainers.index') }}">Kembali</a>
    </div>
@endsection
