@extends('layouts.Alfito')

@section('title', 'Detail Lokasi | Alfito Fitness')

@section('content')
    <p class="eyebrow">ADMINISTRATION</p>
    <h1>{{ $location->name }}</h1>
    <div class="card">
        <p><strong>Nama:</strong> {{ $location->name }}</p>
        <p><strong>Kota:</strong> {{ $location->city }}</p>
        <p><strong>Alamat:</strong> {{ $location->address }}</p>
        <a href="{{ route('admin.locations.index') }}">Kembali</a>
    </div>
@endsection
