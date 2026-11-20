@extends('layouts.Alfito')

@section('title', 'Kelola Program | Alfito Fitness')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <p class="eyebrow">ADMINISTRATION</p>
            <h1>Kelola Program Gym</h1>
        </div>
        <a href="{{ route('admin.programs.create') }}" class="btn">Tambah Program</a>
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
                    <th style="padding: 10px;">Nama Program</th>
                    <th style="padding: 10px;">Kategori</th>
                    <th style="padding: 10px;">Status</th>
                    <th style="padding: 10px; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($programs as $program)
                    <tr style="border-bottom: 1px solid var(--border);">
                        <td style="padding: 10px; font-weight: bold;">{{ $program->name }}</td>
                        <td style="padding: 10px;">{{ $program->category }}</td>
                        <td style="padding: 10px;">
                            @if($program->is_active)
                                <span style="color: var(--accent);">Aktif</span>
                            @else
                                <span style="color: var(--muted);">Nonaktif</span>
                            @endif
                        </td>
                        <td style="padding: 10px; text-align: right;">
                            <a href="{{ route('admin.programs.edit', $program->id) }}" style="margin-right: 10px;">Edit</a>
                            <form action="{{ route('admin.programs.destroy', $program->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus program ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background:none; border:none; color: #ff6b6b; cursor:pointer;">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="padding: 20px; text-align: center; color: var(--muted);">Belum ada data program.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div style="margin-top: 20px;">
            {{ $programs->links() }}
        </div>
    </div>
@endsection
