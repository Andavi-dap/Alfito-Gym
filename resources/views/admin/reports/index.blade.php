@extends('layouts.Alfito')

@section('title', 'Laporan Admin | Alfito Fitness')

@section('content')
    <style>
        .report-filter { display: grid; grid-template-columns: minmax(180px, 1fr) minmax(180px, 1fr) auto auto; align-items: end; gap: 15px; }
        .report-filter-field input { margin-bottom: 0; }
        .report-filter .btn { white-space: nowrap; }
        @media (max-width: 760px) { .report-filter { grid-template-columns: 1fr 1fr; } .report-filter .btn { width: 100%; } }
        @media (max-width: 480px) { .report-filter { grid-template-columns: 1fr; } }
    </style>
    <p class="eyebrow">ADMINISTRATION</p>
    <h1>Laporan Ringkas</h1>
    <p class="muted">Ringkasan data operasional sesuai rentang tanggal terpilih.</p>

    <form method="GET" class="card report-filter">
        <div class="report-filter-field">
            <label for="from">Dari tanggal</label>
            <input id="from" type="date" name="from" value="{{ request('from', $from->toDateString()) }}">
        </div>
        <div class="report-filter-field">
            <label for="to">Sampai tanggal</label>
            <input id="to" type="date" name="to" value="{{ request('to', $to->toDateString()) }}">
        </div>
        <button class="btn" type="submit">Tampilkan</button>
        <a class="btn btn-secondary" href="{{ route('admin.reports.payments.csv', request()->only(['from', 'to'])) }}">Export CSV Pemasukan</a>
    </form>

    <div class="grid">
        <div class="card"><p class="muted">Member Aktif Unik</p><h2>{{ $stats['members'] }}</h2></div>
        <div class="card"><p class="muted">Membership Aktif (Record)</p><h2>{{ $stats['active_memberships'] }}</h2></div>
        <div class="card"><p class="muted">Total Pengajuan</p><h2>{{ $stats['applications'] }}</h2><p class="muted">Pending: {{ $stats['pending_applications'] }}</p></div>
        <div class="card"><p class="muted">Total Pembayaran</p><h2>{{ $stats['payments'] }}</h2><p class="muted">Pending: {{ $stats['pending_payments'] }}</p></div>
        <div class="card"><p class="muted">Pemasukan Terverifikasi</p><h2>Rp {{ number_format((float) $stats['verified_payment_total'], 0, ',', '.') }}</h2><p class="muted">{{ $stats['verified_payment_count'] }} pembayaran</p></div>
        <div class="card"><p class="muted">Total Booking</p><h2>{{ $stats['bookings'] }}</h2><p class="muted">Pending: {{ $stats['pending_bookings'] }}</p></div>
    </div>
@endsection
