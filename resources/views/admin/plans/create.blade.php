@extends('layouts.Alfito')

@section('title', 'Tambah Membership Plan | Alfito Fitness')

@section('content')
    <p class="eyebrow">ADMINISTRATION</p>
    <h1>Tambah Membership Plan</h1>

    <div class="card" style="max-width: 600px; margin-top: 20px;">
        <form action="{{ route('admin.plans.store') }}" method="POST">
            @csrf

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Nama Paket</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Gold Annual Pass" style="width: 100%; padding: 10px; background: var(--surface); border: 1px solid var(--border); color: var(--text);">
                @error('name') <span style="color: #ff6b6b; font-size: 12px;">{{ $message }}</span> @enderror
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Durasi (Bulan)</label>
                <input type="number" name="duration_months" value="{{ old('duration_months', 1) }}" min="1" required style="width: 100%; padding: 10px; background: var(--surface); border: 1px solid var(--border); color: var(--text);">
                @error('duration_months') <span style="color: #ff6b6b; font-size: 12px;">{{ $message }}</span> @enderror
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Harga (Rp)</label>
                <input type="number" step="0.01" name="price" value="{{ old('price') }}" required min="0" placeholder="Contoh: 350000" style="width: 100%; padding: 10px; background: var(--surface); border: 1px solid var(--border); color: var(--text);">
                @error('price') <span style="color: #ff6b6b; font-size: 12px;">{{ $message }}</span> @enderror
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} style="width: 18px; height: 18px;">
                    Plan Aktif
                </label>
            </div>

            <button type="submit" class="btn">Simpan Plan</button>
            <a href="{{ route('admin.plans.index') }}" style="margin-left: 15px; color: var(--muted);">Batal</a>
        </form>
    </div>
@endsection
