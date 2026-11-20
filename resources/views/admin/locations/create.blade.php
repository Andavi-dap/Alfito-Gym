@extends('layouts.Alfito')

@section('title', 'Tambah Lokasi | Alfito Fitness')

@section('content')
    <p class="eyebrow">ADMINISTRATION</p>
    <h1>Tambah Lokasi Cabang</h1>

    <div class="card" style="max-width: 600px; margin-top: 20px;">
        <form action="{{ route('admin.locations.store') }}" method="POST">
            @csrf

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Nama Cabang</label>
                <input type="text" name="name" value="{{ old('name') }}" required style="width: 100%; padding: 10px; background: var(--surface); border: 1px solid var(--border); color: var(--text);">
                @error('name') <span style="color: #ff6b6b; font-size: 12px;">{{ $message }}</span> @enderror
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Kota</label>
                <input type="text" name="city" value="{{ old('city') }}" required style="width: 100%; padding: 10px; background: var(--surface); border: 1px solid var(--border); color: var(--text);">
                @error('city') <span style="color: #ff6b6b; font-size: 12px;">{{ $message }}</span> @enderror
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px;">Alamat Lengkap</label>
                <textarea name="address" rows="3" required style="width: 100%; padding: 10px; background: var(--surface); border: 1px solid var(--border); color: var(--text);">{{ old('address') }}</textarea>
                @error('address') <span style="color: #ff6b6b; font-size: 12px;">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn">Simpan Lokasi</button>
            <a href="{{ route('admin.locations.index') }}" style="margin-left: 15px; color: var(--muted);">Batal</a>
        </form>
    </div>
@endsection
