@extends('layouts.Alfito')

@section('title', 'Dashboard - Alfito Fitness')

@section('content')
    <div class="eyebrow">{{ auth()->user()->role === 'admin' ? 'ADMINISTRATOR CONTROL PANEL' : 'MEMBER AREA' }}</div>

    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1>Dashboard</h1>
            <p class="muted">Halo kembali, <strong>{{ auth()->user()->name }}</strong>. Semoga latihan hari ini maksimal!</p>
        </div>
        <div>
            @if(auth()->user()->role === 'admin')
                <div style="display: flex; gap: 10px;">
                    <a href="{{ route('admin.applications.index') }}" class="btn">Kelola Pengajuan</a>
                    <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">Verifikasi Pembayaran</a>
                </div>
            @else
                <a href="{{ route('member.applications.index') }}" class="btn">Kelola Membership</a>
            @endif
        </div>
    </div>

    @if(auth()->user()->role === 'admin')
        <!-- Admin Stats Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 30px;">
            <div class="card" style="background: linear-gradient(145deg, #1b2228, #101419); border-color: var(--border);">
                <p class="muted" style="font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">Total Member</p>
                <h2 style="font-size: 36px; margin: 8px 0 0; color: var(--text);">{{ number_format($adminStats['members']) }}</h2>
            </div>
            <div class="card" style="background: linear-gradient(145deg, #1b2228, #101419); border-color: var(--border);">
                <p class="muted" style="font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">Pengajuan Pending</p>
                <h2 style="font-size: 36px; margin: 8px 0 0; color: var(--accent);">{{ number_format($adminStats['pendingApplications']) }}</h2>
            </div>
            <div class="card" style="background: linear-gradient(145deg, #1b2228, #101419); border-color: var(--border);">
                <p class="muted" style="font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">Bayar Perlu Verifikasi</p>
                <h2 style="font-size: 36px; margin: 8px 0 0; color: #ffb703;">{{ number_format($adminStats['pendingPayments']) }}</h2>
            </div>
            <div class="card" style="background: linear-gradient(145deg, #1b2228, #101419); border-color: var(--border);">
                <p class="muted" style="font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">Total Pemasukan</p>
                <h2 style="font-size: 28px; margin: 8px 0 0; color: var(--text);">Rp {{ number_format((float) $adminStats['revenue'], 0, ',', '.') }}</h2>
            </div>
        </div>

        <!-- Admin Quick Navigation & Recent Activities -->
        <div style="display: grid; grid-template-columns: 1fr; gap: 24px;">
            <div class="card">
                <h2>Pembayaran Terbaru</h2>
                <p class="muted" style="margin-bottom: 20px;">Daftar transaksi pembayaran membership terbaru dari member.</p>

                @if(count($recentPayments) > 0)
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
                            <thead>
                                <tr style="border-bottom: 1px solid var(--border); color: var(--muted);">
                                    <th style="padding: 12px;">ID</th>
                                    <th style="padding: 12px;">Member</th>
                                    <th style="padding: 12px;">Jumlah</th>
                                    <th style="padding: 12px;">Status</th>
                                    <th style="padding: 12px;">Waktu</th>
                                    <th style="padding: 12px; text-align: right;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentPayments as $payment)
                                    <tr style="border-bottom: 1px solid var(--border);">
                                        <td style="padding: 12px;">#{{ $payment->id }}</td>
                                        <td style="padding: 12px; font-weight: 600;">{{ $payment->application?->user?->name ?? 'User' }}</td>
                                        <td style="padding: 12px;">Rp {{ number_format((float) $payment->amount, 0, ',', '.') }}</td>
                                        <td style="padding: 12px;"><span class="status">{{ strtoupper($payment->status) }}</span></td>
                                        <td style="padding: 12px; color: var(--muted);">{{ $payment->created_at->format('d M Y H:i') }}</td>
                                        <td style="padding: 12px; text-align: right;">
                                            <a href="{{ route('admin.payments.index') }}" style="color: var(--accent); font-weight: 700; text-decoration: none;">Periksa →</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="muted">Belum ada data pembayaran.</p>
                @endif
            </div>
        </div>

    @else
        <!-- Member View -->
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
