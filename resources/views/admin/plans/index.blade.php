@extends('layouts.Alfito')

@section('title', 'Kelola Membership Plan | Alfito Fitness')

@section('content')
    <div class="page-header">
        <div>
            <p class="eyebrow">ADMINISTRATION</p>
            <h1>Kelola Membership Plan</h1>
        </div>
        <a href="{{ route('admin.plans.create') }}" class="btn">Tambah Plan</a>
    </div>

    @if(session('success'))
        <div style="background: var(--surface); border: 1px solid var(--accent); padding: 15px; margin-bottom: 20px; border-radius: 4px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="border-bottom: 1px solid var(--border);">
                    <th style="padding: 10px;">Nama Paket</th>
                    <th style="padding: 10px;">Durasi (Bulan)</th>
                    <th style="padding: 10px;">Harga (Rp)</th>
                    <th style="padding: 10px;">Status</th>
                    <th style="padding: 10px; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($plans as $plan)
                    <tr style="border-bottom: 1px solid var(--border);">
                        <td style="padding: 10px; font-weight: bold;">{{ $plan->name }}</td>
                        <td style="padding: 10px;">{{ $plan->duration_months }} Bulan</td>
                        <td style="padding: 10px;">Rp {{ number_format((float) $plan->price, 0, ',', '.') }}</td>
                        <td style="padding: 10px;">
                            @if($plan->is_active)
                                <span style="color: var(--accent);">Aktif</span>
                            @else
                                <span style="color: var(--muted);">Nonaktif</span>
                            @endif
                        </td>
                        <td style="padding: 10px; text-align: right;">
                            <a href="{{ route('admin.plans.show', $plan->id) }}" style="margin-right: 10px;">Detail</a>
                            <a href="{{ route('admin.plans.edit', $plan->id) }}" style="margin-right: 10px;">Edit</a>
                            <form action="{{ route('admin.plans.destroy', $plan->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus plan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background:none; border:none; color: #ff6b6b; cursor:pointer;">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 20px; text-align: center; color: var(--muted);">Belum ada data membership plan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div style="margin-top: 20px;">
            {{ $plans->links() }}
        </div>
    </div>
@endsection
