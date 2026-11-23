@extends('layouts.public')

@section('content')
    <main style="max-width: 900px; margin: 80px auto; padding: 0 24px; color: #fff;">
        <p style="color: #c8ff36; letter-spacing: 3px;">{{ strtoupper($program->category) }}</p>
        <h1>{{ $program->name }}</h1>
        <p>{{ $program->description ?: 'Program latihan untuk membantu mencapai target kebugaran.' }}</p>
        <p>Durasi: {{ $program->duration_minutes }} menit</p>
        <p>Harga: Rp {{ number_format((float) $program->price, 0, ',', '.') }}</p>
        <h2>Trainer</h2>
        @forelse($program->trainers as $trainer)
            <p>{{ $trainer->name }} — {{ $trainer->specialization }}</p>
        @empty
            <p>Trainer belum tersedia.</p>
        @endforelse
        @auth
            <a href="{{ route('member.bookings.checkout', $program) }}">Booking program</a>
        @else
            <a href="{{ route('login') }}">Login untuk booking</a>
        @endauth
    </main>
@endsection
