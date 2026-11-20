@extends('layouts.Alfito')

@section('title', 'Booking Program | Alfito Fitness')

@section('content')
    <p class="eyebrow">ADMINISTRATION</p>
    <h1>Booking Program</h1>

    @forelse($bookings as $booking)
        <div class="card">
            <h3>{{ $booking->program->name }} — {{ $booking->user->name }}</h3>
            <p>Trainer: {{ $booking->trainer->name ?? 'Tidak ada trainer khusus' }}</p>
            <p>Tanggal: {{ $booking->booking_date->format('d M Y') }}</p>
            <p>Status: <span class="status">{{ strtoupper($booking->status) }}</span></p>

            @if($booking->status === 'pending')
                <form action="{{ route('admin.bookings.decision', $booking) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <select name="decision" required>
                        <option value="approve">ACC Booking</option>
                        <option value="reject">Tolak Booking</option>
                    </select>
                    <button class="btn" type="submit">Proses Booking</button>
                </form>
            @endif
        </div>
    @empty
        <p class="muted">Belum ada pengajuan booking program.</p>
    @endforelse
@endsection
