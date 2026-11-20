
@extends('layouts.Alfito')

@section('title', 'Dashboard - Alfito Fitness')

@section('content')
    <div class="eyebrow">MEMBER AREA</div>

    <h1>Dashboard</h1>

    <div class="card" style="margin-bottom: 25px;">
        <p class="muted">Selamat datang kembali,</p>

        <h2>{{ auth()->user()->name }}!</h2>

        <p class="muted">
            Kamu berhasil login ke Alfito Fitness.
        </p>

        @if(auth()->user()->role === 'admin')
            <div class="actions" style="margin-top: 15px;">
                <a href="{{ route('admin.applications.index') }}" class="btn">
                    Kelola Pengajuan
                </a>

                <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">
                    Kelola Pembayaran
                </a>
            </div>
        @else
            <div class="actions" style="margin-top: 15px;">
                <a href="{{ route('member.applications.index') }}" class="btn">
                    Kelola Membership & Pengajuan
                </a>
            </div>
        @endif
    </div>

    @if(auth()->user()->role !== 'admin')
        <h2>Status Membership Aktif</h2>
        
        <div class="grid" style="margin-bottom: 30px;">
            @forelse($memberships as $membership)
                <div class="card">
                    <h3>{{ $membership->membershipPlan->name ?? 'Paket Membership' }}</h3>
                    <p>Status: <span class="status">{{ strtoupper($membership->status) }}</span></p>
                    <p class="muted">Mulai: {{ $membership->starts_at?->format('d M Y') }}</p>
                    <p class="muted">Berakhir: {{ $membership->ends_at?->format('d M Y') }}</p>
                </div>
            @empty
                <div class="card">
                    <p class="muted">Belum ada membership aktif. Silakan ajukan paket membership terlebih dahulu.</p>
                    <a href="{{ route('member.applications.index') }}" class="btn" style="margin-top: 10px; display: inline-block;">Pilih Paket</a>
                </div>
            @endforelse
        </div>

        <h2>Riwayat Pembayaran & Pengajuan</h2>
        <div class="card">
            @if($payments->count() > 0)
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--border);">
                            <th style="padding: 10px;">ID Bayar</th>
                            <th style="padding: 10px;">Jumlah</th>
                            <th style="padding: 10px;">Status</th>
                            <th style="padding: 10px;">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td style="padding: 10px;">#{{ $payment->id }}</td>
                                <td style="padding: 10px;">Rp {{ number_format((float) $payment->amount, 0, ',', '.') }}</td>
                                <td style="padding: 10px;"><span class="status">{{ strtoupper($payment->status) }}</span></td>
                                <td style="padding: 10px; color: var(--muted);">{{ $payment->created_at->format('d M Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="muted">Belum ada riwayat pembayaran.</p>
            @endif
        </div>
    @endif
@endsection

