@extends('layouts.Alfito')

@section('title', 'Edit Program | Alfito Fitness')

@section('content')
    <p class="eyebrow">ADMINISTRATION</p>
    <h1>Edit Program Gym</h1>

    <div class="card" style="max-width: 600px; margin-top: 20px;">
        <form action="{{ route('admin.programs.update', $program->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Nama Program</label>
                <input type="text" name="name" value="{{ old('name', $program->name) }}" required style="width: 100%; padding: 10px; background: var(--surface); border: 1px solid var(--border); color: var(--text);">
                @error('name') <span style="color: #ff6b6b; font-size: 12px;">{{ $message }}</span> @enderror
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Kategori</label>
                <input type="text" name="category" value="{{ old('category', $program->category) }}" required style="width: 100%; padding: 10px; background: var(--surface); border: 1px solid var(--border); color: var(--text);">
                @error('category') <span style="color: #ff6b6b; font-size: 12px;">{{ $message }}</span> @enderror
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Deskripsi</label>
                <textarea name="description" rows="4" style="width: 100%;">{{ old('description', $program->description) }}</textarea>
            </div>

            <div style="display: flex; gap: 15px; margin-bottom: 15px;">
                <div><label>Harga</label><input type="number" name="price" min="0" step="0.01" value="{{ old('price', $program->price) }}" required></div>
                <div><label>Durasi (menit)</label><input type="number" name="duration_minutes" min="1" value="{{ old('duration_minutes', $program->duration_minutes) }}" required></div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px;">Trainer Program</label>
                <select name="trainers[]" multiple style="min-height: 110px;">
                    @foreach($trainers as $trainer)
                        <option value="{{ $trainer->id }}" {{ in_array($trainer->id, old('trainers', $program->trainers->pluck('id')->all())) ? 'selected' : '' }}>{{ $trainer->name }} — {{ $trainer->specialization }}</option>
                    @endforeach
                </select>
                @error('trainers') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $program->is_active) ? 'checked' : '' }} style="width: 18px; height: 18px;">
                    Program Aktif
                </label>
            </div>

            <button type="submit" class="btn">Perbarui Program</button>
            <a href="{{ route('admin.programs.index') }}" style="margin-left: 15px; color: var(--muted);">Batal</a>
        </form>
    </div>
@endsection
