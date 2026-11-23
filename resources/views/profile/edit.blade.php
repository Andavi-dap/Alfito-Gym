@extends('layouts.Alfito')

@section('title', 'Profile | Alfito Fitness')

@section('content')
    <p class="eyebrow">ACCOUNT</p>
    <h1>Profile</h1>

    <div class="card form-card">
        <h2>Informasi Profile</h2>
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')
            <label for="name">Nama</label>
            <input id="name" name="name" value="{{ old('name', $user->name) }}" required>
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required>
            <button class="btn" type="submit">Simpan</button>
        </form>
    </div>

    <div class="card form-card">
        <h2>Hapus Akun</h2>
        <p class="muted">Tindakan ini menghapus akun secara permanen.</p>
        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('DELETE')
            <label for="password">Password saat ini</label>
            <input id="password" name="password" type="password" required>
            <button class="btn btn-danger" type="submit">Hapus Akun</button>
        </form>
    </div>
@endsection
