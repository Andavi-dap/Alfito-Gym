@extends('layouts.Alfito')

@section('title', 'Detail Program | Alfito Fitness')

@section('content')
    <p class="eyebrow">ADMINISTRATION</p>
    <h1>{{ $program->name }}</h1>
    <div class="card">
        <p><strong>Nama:</strong> {{ $program->name }}</p>
        <p><strong>Kategori:</strong> {{ $program->category }}</p>
        <p><strong>Status:</strong> {{ $program->is_active ? 'Aktif' : 'Nonaktif' }}</p>
        <p><strong>Trainer Terkait:</strong>
            @foreach($program->trainers as $t)
                {{ $t->name }}{{ !$loop->last ? ', ' : '' }}
            @endforeach
        </p>
        <a href="{{ route('admin.programs.index') }}">Kembali</a>
    </div>
@endsection
