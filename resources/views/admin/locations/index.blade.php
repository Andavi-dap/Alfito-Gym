@extends('layouts.Alfito')

@section('title', 'Kelola Lokasi | Alfito Fitness')

@section('content')
    <div class="page-header">
        <div>
            <p class="eyebrow">ADMINISTRATION</p>
            <h1>Kelola Lokasi Cabang</h1>
        </div>
        <a href="{{ route('admin.locations.create') }}" class="btn">Tambah Lokasi</a>
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
                    <th style="padding: 10px;">Kota</th>
                    <th style="padding: 10px;">Alamat</th>
                    <th style="padding: 10px; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($locations as $loc)
                    <tr style="border-bottom: 1px solid var(--border);">
                        <td style="padding: 10px; font-weight: bold;">{{ $loc->name }}</td>
                        <td style="padding: 10px;">{{ $loc->city }}</td>
                        <td style="padding: 10px; color: var(--muted);">{{ $loc->address }}</td>
                        <td style="padding: 10px; text-align: right;">
                            <a href="{{ route('admin.locations.show', $loc->id) }}" style="margin-right: 10px;">Detail</a>
                            <a href="{{ route('admin.locations.edit', $loc->id) }}" style="margin-right: 10px;">Edit</a>
                            <form action="{{ route('admin.locations.destroy', $loc->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus lokasi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background:none; border:none; color: #ff6b6b; cursor:pointer;">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="padding: 20px; text-align: center; color: var(--muted);">Belum ada data lokasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div style="margin-top: 20px;">
            {{ $locations->links() }}
        </div>
    </div>
@endsection
