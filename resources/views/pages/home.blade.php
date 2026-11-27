
@extends('layouts.public')

@section('title', 'ALFITO Gym — Train Beyond Limits')

@section('meta_description', 'Discover your next level with ALFITO Gym.')

@section('content')

@push('styles')
<style>
    .home-plans-section {
        background: #090b09;
        padding: 80px 0;
    }

    .home-plans-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 22px;
        align-items: stretch;
        margin-top: 35px;
    }

    .home-plan-card {
        background: #151815;
        border: 1px solid #292e28;
        padding: 30px 25px;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        transition: .25s ease;
    }

    .home-plan-card:hover {
        border-color: #c7f36b;
        transform: translateY(-5px);
    }

    .home-plan-card.featured {
        border: 1px solid #c7f36b;
        background: linear-gradient(180deg, rgba(199, 243, 107, .09), #151815 45%);
    }

    .home-plan-badge {
        display: inline-block;
        width: fit-content;
        padding: 7px 12px;
        background: rgba(199, 243, 107, .1);
        color: #c7f36b;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 1px;
        border-radius: 3px;
        margin-bottom: 25px;
    }

    .home-plan-card h3 {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 31px;
        margin-bottom: 5px;
    }

    .home-plan-duration {
        color: #999e94;
        font-size: 12px;
        margin-bottom: 25px;
    }

    .home-plan-price {
        font-size: 32px;
        font-weight: 800;
        margin-bottom: 5px;
        color: #fff;
    }

    .home-plan-price-label {
        color: #858b80;
        font-size: 11px;
        margin-bottom: 25px;
    }

    .home-plan-divider {
        height: 1px;
        background: #30362e;
        margin-bottom: 25px;
    }

    .home-plan-benefits {
        list-style: none;
        padding: 0;
        margin: 0 0 30px;
        flex: 1;
    }

    .home-plan-benefits li {
        color: #b4b9af;
        font-size: 12px;
        margin-bottom: 14px;
    }

    .home-plan-benefits li::before {
        content: '✓';
        color: #c7f36b;
        font-weight: bold;
        margin-right: 10px;
    }

    .home-plan-button {
        display: block;
        width: 100%;
        padding: 14px;
        text-align: center;
        text-decoration: none;
        background: transparent;
        color: #c7f36b;
        border: 1px solid #c7f36b;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 1px;
        border-radius: 3px;
        transition: .2s;
    }

    .home-plan-button:hover {
        background: #c7f36b;
        color: #090b09;
    }

    .featured .home-plan-button {
        background: #c7f36b;
        color: #090b09;
    }

    .featured .home-plan-button:hover {
        background: #d8ff87;
    }

    .home-plans-empty {
        padding: 40px;
        text-align: center;
        background: #151815;
        border: 1px solid #292e28;
        color: #999e94;
    }

    .home-plans-note {
        color: #777e72;
        text-align: center;
        font-size: 11px;
        margin-top: 25px;
    }

    @media (max-width: 850px) {
        .home-plans-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 600px) {
        .home-plans-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

<section class="hero-section">
    <div class="container hero-grid">

        <div class="hero-copy">
            <p class="eyebrow">
                <span class="eyebrow-line"></span>
                BUILT FOR YOUR NEXT LEVEL
            </p>

            <h1>
                TRAIN HARD.<br>
                LIVE <span class="text-accent">STRONG.</span>
            </h1>

            <p class="hero-description">
                More than a workout. Build your discipline,
                push your limits, and make progress every day
                with ALFITO Gym.
            </p>

            <div class="hero-actions">
                <a href="{{ url('/membership') }}" class="btn btn-primary">
                    Explore Membership <span aria-hidden="true">↗</span>
                </a>

                <a href="{{ url('/programs') }}" class="btn btn-outline">
                    Explore Programs
                </a>
            </div>

            <div class="hero-principles">
                <div>
                    <span class="principle-number">01</span>
                    <span class="principle-label">DISCIPLINE</span>
                </div>

                <div>
                    <span class="principle-number">02</span>
                    <span class="principle-label">STRENGTH</span>
                </div>

                <div>
                    <span class="principle-number">03</span>
                    <span class="principle-label">PROGRESS</span>
                </div>
            </div>
        </div>

        <div class="hero-visual">
            <div class="visual-grid"></div>
            <div class="visual-glow"></div>

            <div class="visual-top">
                <span class="live-dot"></span>
                ALFITO / PERFORMANCE CLUB
            </div>

            <div class="visual-main">
                <span class="visual-kicker">YOUR NEXT LEVEL</span>

                <div class="visual-word">
                    NO<br>
                    LIMITS<span>.</span>
                </div>
            </div>

            <div class="visual-bottom">
                <span>BUILT THROUGH DISCIPLINE</span>
                <span>ALFITO®</span>
            </div>
        </div>

    </div>
</section>

<section class="principles-section">
    <div class="container">

        <div class="section-heading">
            <p class="eyebrow">THE ALFITO MINDSET</p>
            <h2>PROGRESS IS <span class="text-accent">EARNED.</span></h2>
            <p>
                Every session is an opportunity to become stronger
                than yesterday.
            </p>
        </div>

        <div class="principle-cards">
            <article class="principle-card">
                <span class="card-index">01 / MINDSET</span>
                <h3>STAY DISCIPLINED.</h3>
                <p>
                    Build a consistent routine and show up for your goals.
                </p>
            </article>

            <article class="principle-card">
                <span class="card-index">02 / TRAINING</span>
                <h3>MOVE WITH PURPOSE.</h3>
                <p>
                    Find a training approach that fits your needs and goals.
                </p>
            </article>

            <article class="principle-card">
                <span class="card-index">03 / PROGRESS</span>
                <h3>KEEP EVOLVING.</h3>
                <p>
                    Focus on steady improvement, one session at a time.
                </p>
            </article>
        </div>

    </div>
</section>

<section class="home-plans-section">
    <div class="container">

        <div class="section-heading">
            <p class="eyebrow">MEMBERSHIP PLANS</p>
            <h2>FIND YOUR PERFECT <span class="text-accent">PLAN.</span></h2>
            <p>Choose the membership that matches your fitness goals.</p>
        </div>

        @if($plans->isNotEmpty())

            <div class="home-plans-grid">

                @foreach($plans as $index => $plan)

                    <div class="home-plan-card {{ $index === 1 ? 'featured' : '' }}">

                        <div class="home-plan-badge">
                            {{ $index === 1 ? 'MOST POPULAR' : 'MEMBERSHIP PLAN' }}
                        </div>

                        <h3>{{ $plan->name }}</h3>

                        <div class="home-plan-duration">
                            {{ $plan->duration_months }}
                            {{ $plan->duration_months == 1 ? 'MONTH' : 'MONTHS' }}
                        </div>

                        <div class="home-plan-price">
                            Rp{{ number_format((float) $plan->price, 0, ',', '.') }}
                        </div>

                        <div class="home-plan-price-label">
                            Total membership price
                        </div>

                        <div class="home-plan-divider"></div>

                        <ul class="home-plan-benefits">
                            <li>Access to gym facilities</li>
                            <li>Membership account</li>
                            <li>Membership status tracking</li>
                            <li>Payment verification</li>
                            <li>Dedicated member dashboard</li>
                        </ul>

                        <a href="{{ route('register') }}" class="home-plan-button">
                            CHOOSE THIS PLAN →
                        </a>

                    </div>

                @endforeach

            </div>

            <p class="home-plans-note">
                Membership activation is subject to application approval and payment verification.
            </p>

        @else

            <div class="home-plans-empty">
                <h3>No Membership Plans Available</h3>
                <p>Please check again later.</p>
            </div>

        @endif

    </div>
</section>

<section class="cta-section">
    <div class="container cta-inner">
        <div>
            <p class="eyebrow">YOUR JOURNEY STARTS HERE</p>
            <h2>READY FOR YOUR <span class="text-accent">NEXT LEVEL?</span></h2>
        </div>

        <a href="{{ route('register') }}" class="btn btn-primary">
            Join ALFITO <span aria-hidden="true">↗</span>
        </a>
    </div>
</section>

@endsection
