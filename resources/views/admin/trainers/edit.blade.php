@extends('layouts.Alfito')

@section('title', 'Edit Trainer | Alfito Fitness')

@section('content')
    <p class="eyebrow">ADMINISTRATION</p>
    <h1>Edit Data Trainer</h1>

    <div class="card" style="max-width: 600px; margin-top: 20px;">
        <form action="{{ route('admin.trainers.update', $trainer->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Nama Trainer</label>
                <input type="text" name="name" value="{{ old('name', $trainer->name) }}" required style="width: 100%; padding: 10px; background: var(--surface); border: 1px solid var(--border); color: var(--text);">
                @error('name') <span style="color: #ff6b6b; font-size: 12px;">{{ $message }}</span> @enderror
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Spesialisasi</label>
                <input type="text" name="specialization" value="{{ old('specialization', $trainer->specialization) }}" required style="width: 100%; padding: 10px; background: var(--surface); border: 1px solid var(--border); color: var(--text);">
                @error('specialization') <span style="color: #ff6b6b; font-size: 12px;">{{ $message }}</span> @enderror
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px;">Lokasi Cabang</label>
                <select name="location_id" required style="width: 100%; padding: 10px; background: var(--surface); border: 1px solid var(--border); color: var(--text);">
                    <option value="">Pilih Cabang</option>
                    @foreach($locations as $loc)
                        <option value="{{ $loc->id }}" {{ old('location_id', $trainer->location_id) == $loc->id ? 'selected' : '' }}>{{ $loc->name }} ({{ $loc->city }})</option>
                    @endforeach
                </select>
                @error('location_id') <span style="color: #ff6b6b; font-size: 12px;">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn">Perbarui Trainer</button>
            <a href="{{ route('admin.trainers.index') }}" style="margin-left: 15px; color: var(--muted);">Batal</a>
        </form>
    </div>
@endsection
