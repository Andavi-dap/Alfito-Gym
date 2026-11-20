@extends('layouts.Alfito')

@section('title', 'Booking Program | Alfito Fitness')

@section('content')
    <p class="eyebrow">MEMBER AREA</p>
    <h1>Booking Program & Trainer</h1>

    @if($errors->any())
        <div class="alert error">{{ $errors->first() }}</div>
    @endif

    <div class="grid">
        @forelse($programs as $program)
            <div class="card">
                <h2>{{ $program->name }}</h2>
                <p class="muted">{{ $program->category }}</p>
                <form action="{{ route('member.bookings.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="program_id" value="{{ $program->id }}">
                    <label for="trainer-{{ $program->id }}">Trainer</label>
                    <select id="trainer-{{ $program->id }}" name="trainer_id">
                        <option value="">Tanpa trainer khusus</option>
                        @foreach($trainers as $trainer)
                            <option value="{{ $trainer->id }}">{{ $trainer->name }} — {{ $trainer->specialization }}</option>
                        @endforeach
                    </select>
                    <label for="date-{{ $program->id }}">Tanggal</label>
                    <input id="date-{{ $program->id }}" type="date" name="booking_date" min="{{ now()->toDateString() }}" required>
                    <button class="btn" type="submit">Booking Sekarang</button>
                </form>
            </div>
        @empty
            <p class="muted">Belum ada program aktif.</p>
        @endforelse
    </div>

    <h2 style="margin-top: 45px;">Booking Saya</h2>
    @forelse($bookings as $booking)
        <div class="card">
            <h3>{{ $booking->program->name }}</h3>
            <p>Trainer: {{ $booking->trainer->name ?? 'Tidak ada trainer khusus' }}</p>
            <p>Tanggal: {{ $booking->booking_date->format('d M Y') }}</p>
            <p>Status: <span class="status">{{ strtoupper($booking->status) }}</span></p>
            @if($booking->status !== 'cancelled' && $booking->booking_date->isFuture())
                <form action="{{ route('member.bookings.destroy', $booking) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-secondary">Batalkan Booking</button>
                </form>
            @endif
        </div>
    @empty
        <p class="muted">Belum ada booking.</p>
    @endforelse
@endsection
