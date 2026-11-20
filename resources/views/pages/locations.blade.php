@extends('layouts.public')

@section('title', 'Locations | Alfito Fitness')
@section('meta_description', 'Temukan cabang Alfito Fitness terdekat dan mulai latihan hari ini.')

@section('content')
    <section class="page-hero">
        <div class="container">
            <p class="eyebrow">ALFITO FITNESS NETWORK</p>
            <h1>Find your <span class="text-accent">strongest place.</span></h1>
            <p class="hero-copy">Pilih lokasi latihan yang paling dekat dengan target dan rutinitasmu.</p>
        </div>
    </section>

    <section class="section-space">
        <div class="container">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">OUR LOCATIONS</p>
                    <h2>Train without limits.</h2>
                </div>
                <p class="muted">{{ $locations->count() }} lokasi tersedia</p>
            </div>

            <div class="location-grid">
                @forelse($locations as $location)
                    <article class="location-card">
                        <div class="location-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                        <h3>{{ $location->name }}</h3>
                        <p class="location-city">{{ $location->city }}</p>
                        <p class="muted">{{ $location->address }}</p>
                        <div class="location-meta">
                            <span>{{ $location->trainers->count() }} trainer</span>
                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($location->address . ', ' . $location->city) }}" target="_blank" rel="noopener">Lihat peta ↗</a>
                        </div>
                    </article>
                @empty
                    <div class="empty-state">Belum ada lokasi tersedia.</div>
                @endforelse
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
    .page-hero { padding: 110px 0 90px; border-bottom: 1px solid rgba(255,255,255,.08); background: radial-gradient(circle at 75% 30%, rgba(199,243,107,.13), transparent 32%); }
    .hero-copy { max-width: 520px; color: var(--muted); font-size: 18px; }
    .section-space { padding: 90px 0; }
    .section-heading { display: flex; justify-content: space-between; align-items: end; gap: 24px; margin-bottom: 32px; }
    .location-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px; }
    .location-card { position: relative; min-height: 245px; padding: 26px; border: 1px solid var(--border); border-radius: 16px; background: linear-gradient(145deg, #1b2228, #101419); transition: transform .2s, border-color .2s; }
    .location-card:hover { transform: translateY(-4px); border-color: var(--accent); }
    .location-number { color: var(--accent); font-weight: 800; letter-spacing: 2px; }
    .location-card h3 { margin: 34px 0 4px; font-size: 22px; }
    .location-city { margin: 0 0 14px; color: var(--accent); font-weight: 700; }
    .location-meta { display: flex; justify-content: space-between; gap: 12px; align-items: center; margin-top: 28px; padding-top: 16px; border-top: 1px solid var(--border); color: var(--muted); font-size: 13px; }
    .location-meta a { font-weight: 700; }
    .empty-state { padding: 30px; border: 1px dashed var(--border); color: var(--muted); }
    @media (max-width: 650px) { .page-hero { padding: 75px 0 60px; } .section-space { padding: 60px 0; } .section-heading { align-items: start; flex-direction: column; } }
</style>
@endpush
