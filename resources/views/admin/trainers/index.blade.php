@extends('layouts.Alfito')

@section('title', 'Kelola Trainer | Alfito Fitness')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <p class="eyebrow">ADMINISTRATION</p>
            <h1>Kelola Trainer</h1>
        </div>
        <a href="{{ route('admin.trainers.create') }}" class="btn">Tambah Trainer</a>
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
                    <th style="padding: 10px;">Nama</th>
                    <th style="padding: 10px;">Spesialisasi</th>
                    <th style="padding: 10px;">Lokasi Cabang</th>
                    <th style="padding: 10px; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($trainers as $trainer)
                    <tr style="border-bottom: 1px solid var(--border);">
                        <td style="padding: 10px; font-weight: bold;">{{ $trainer->name }}</td>
                        <td style="padding: 10px;">{{ $trainer->specialization }}</td>
                        <td style="padding: 10px; color: var(--muted);">{{ $trainer->location->name ?? '-' }}</td>
                        <td style="padding: 10px; text-align: right;">
                            <a href="{{ route('admin.trainers.edit', $trainer->id) }}" style="margin-right: 10px;">Edit</a>
                            <form action="{{ route('admin.trainers.destroy', $trainer->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus trainer ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background:none; border:none; color: #ff6b6b; cursor:pointer;">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="padding: 20px; text-align: center; color: var(--muted);">Belum ada data trainer.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div style="margin-top: 20px;">
            {{ $trainers->links() }}
        </div>
    </div>
@endsection
