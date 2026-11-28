@extends('layouts.Alfito')

@section('title', 'Checkout Booking | Alfito Fitness')

@section('content')
    <p class="eyebrow">MEMBER AREA</p>
    <h1>Checkout Booking Program</h1>

    <div class="card" style="max-width: 600px; margin-top: 20px;">
        <h2>{{ $program->name }}</h2>
        <p class="muted">Kategori: {{ $program->category }}</p>
        <p>{{ $program->description ?: 'Program latihan optimal.' }}</p>
        <p><strong>Durasi:</strong> {{ $program->duration_minutes }} menit</p>
        <p><strong>Biaya:</strong> Rp {{ number_format((float) $program->price, 0, ',', '.') }}</p>

        <form action="{{ route('member.bookings.store') }}" method="POST" style="margin-top: 20px;">
            @csrf
            <input type="hidden" name="program_id" value="{{ $program->id }}">

            <div style="margin-bottom: 15px;">
                <label for="trainer_id" style="display: block; margin-bottom: 5px;">Pilih Trainer (Opsional)</label>
                <select id="trainer_id" name="trainer_id" style="width: 100%; padding: 10px; background: var(--surface); border: 1px solid var(--border); color: var(--text);">
                    <option value="">Tanpa trainer khusus</option>
                    @foreach($program->trainers as $trainer)
                        <option value="{{ $trainer->id }}">{{ $trainer->name }} — {{ $trainer->specialization }}</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <label for="booking_date" style="display: block; margin-bottom: 5px;">Tanggal Booking</label>
                <input id="booking_date" type="date" name="booking_date" min="{{ now()->toDateString() }}" required style="width: 100%; padding: 10px; background: var(--surface); border: 1px solid var(--border); color: var(--text);">
            </div>

            <button type="submit" class="btn">Konfirmasi & Booking</button>
            <a href="{{ route('programs.index') }}" style="margin-left: 15px; color: var(--muted);">Batal</a>
        </form>
    </div>
@endsection
