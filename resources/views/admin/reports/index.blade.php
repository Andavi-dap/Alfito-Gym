@extends('layouts.Alfito')

@section('title', 'Laporan Admin | Alfito Fitness')

@section('content')
    <p class="eyebrow">ADMINISTRATION</p>
    <h1>Laporan Ringkas</h1>
    <p class="muted">Ringkasan data operasional Alfito Fitness.</p>

    <form method="GET" class="card" style="display: flex; gap: 15px; align-items: end; flex-wrap: wrap;">
        <div>
            <label for="from">Dari tanggal</label>
            <input id="from" type="date" name="from" value="{{ request('from', $from->toDateString()) }}">
        </div>
        <div>
            <label for="to">Sampai tanggal</label>
            <input id="to" type="date" name="to" value="{{ request('to', $to->toDateString()) }}">
        </div>
        <button class="btn" type="submit">Tampilkan</button>
        <a class="btn btn-secondary" href="{{ route('admin.reports.payments.csv', request()->only(['from', 'to'])) }}">Export CSV Pemasukan</a>
    </form>

    <div class="grid">
        <div class="card"><p class="muted">Total Member</p><h2>{{ $stats['members'] }}</h2></div>
        <div class="card"><p class="muted">Membership Aktif</p><h2>{{ $stats['active_memberships'] }}</h2></div>
        <div class="card"><p class="muted">Total Pengajuan</p><h2>{{ $stats['applications'] }}</h2><p class="muted">Pending: {{ $stats['pending_applications'] }}</p></div>
        <div class="card"><p class="muted">Total Pembayaran</p><h2>{{ $stats['payments'] }}</h2><p class="muted">Pending: {{ $stats['pending_payments'] }}</p></div>
        <div class="card"><p class="muted">Pemasukan Terverifikasi</p><h2>Rp {{ number_format((float) $stats['verified_payment_total'], 0, ',', '.') }}</h2><p class="muted">{{ $stats['verified_payment_count'] }} pembayaran</p></div>
        <div class="card"><p class="muted">Total Booking</p><h2>{{ $stats['bookings'] }}</h2><p class="muted">Pending: {{ $stats['pending_bookings'] }}</p></div>
    </div>
@endsection
