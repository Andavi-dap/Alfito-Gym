<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Alfito Fitness')</title>

    <style>
        :root { --bg: #090b0e; --surface: #12161b; --card: #1a2027; --accent: #c7f36b; --text: #f4f7ef; --muted: #94a0ad; --border: #29323b; --danger: #ff8585; }
        * { box-sizing: border-box; }
        html { background: var(--bg); }
        body { margin: 0; min-height: 100vh; background: radial-gradient(circle at 80% -10%, #26351d 0, transparent 32%), var(--bg); color: var(--text); font-family: Inter, ui-sans-serif, system-ui, -apple-system, sans-serif; line-height: 1.6; }
        a { color: var(--accent); transition: opacity .2s, color .2s; }
        a:hover { opacity: .78; }
        .topbar { position: sticky; top: 0; z-index: 10; padding: 14px 5%; background: rgba(9, 11, 14, .88); backdrop-filter: blur(18px); border-bottom: 1px solid rgba(255,255,255,.08); display: flex; align-items: center; justify-content: space-between; gap: 24px; }
        .brand { color: var(--text); font-weight: 900; font-size: 22px; line-height: 1; letter-spacing: 3px; text-decoration: none; }
        .brand span { display: block; margin-top: 5px; color: var(--accent); font-size: 9px; letter-spacing: 4px; }
        nav { display: flex; gap: 6px; flex-wrap: wrap; justify-content: flex-end; }
        nav a { padding: 8px 10px; border-radius: 8px; color: var(--muted); text-decoration: none; font-size: 13px; }
        nav a:hover { color: var(--text); background: var(--card); opacity: 1; }
        .container { width: min(1160px, calc(100% - 40px)); margin: 0 auto; padding: 52px 0 80px; }
        .eyebrow { margin: 0 0 12px; color: var(--accent); font-size: 11px; font-weight: 800; letter-spacing: 3px; text-transform: uppercase; }
        h1, h2, h3 { letter-spacing: -.03em; }
        h1 { margin: 0 0 14px; font-size: clamp(34px, 5vw, 60px); line-height: 1.05; }
        h2 { margin: 0 0 16px; font-size: clamp(22px, 3vw, 30px); }
        h3 { margin-top: 0; }
         .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; align-items: stretch; }
         .grid > .card { display: flex; flex-direction: column; }
         .grid > .card form:last-child { margin-top: auto; }
        .card { background: linear-gradient(145deg, rgba(30,37,44,.96), rgba(16,20,25,.96)); border: 1px solid var(--border); border-radius: 16px; padding: 24px; margin-bottom: 20px; box-shadow: 0 14px 35px rgba(0,0,0,.16); }
        .card:hover { border-color: #46545f; }
        .price { color: var(--accent); font-size: 28px; font-weight: 800; }
        .muted { color: var(--muted); }
        .btn { display: inline-flex; align-items: center; justify-content: center; min-height: 42px; padding: 10px 17px; border: 1px solid transparent; border-radius: 9px; background: var(--accent); color: #0b0e09; font-weight: 800; cursor: pointer; text-decoration: none; transition: transform .2s, filter .2s; }
        .btn:hover { opacity: 1; filter: brightness(1.08); transform: translateY(-1px); }
         .btn-secondary { background: transparent; color: var(--text); border-color: var(--border); }
         .btn-danger { background: var(--danger); color: #180708; }
        input, select, textarea { width: 100%; margin: 7px 0 16px; padding: 12px 13px; border-radius: 9px; border: 1px solid var(--border); outline: none; background: #0d1115; color: var(--text); font: inherit; }
        input:focus, select:focus, textarea:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(199,243,107,.12); }
        label { display: block; color: var(--muted); font-size: 13px; font-weight: 600; }
        .alert { padding: 14px 16px; border: 1px solid rgba(199,243,107,.45); border-radius: 10px; margin-bottom: 20px; background: rgba(199,243,107,.08); }
        .error { color: var(--danger); font-size: 13px; }
        .status { color: var(--accent); font-weight: 800; }
        .actions { display: flex; gap: 10px; flex-wrap: wrap; }
        table { overflow: hidden; border: 1px solid var(--border); border-radius: 12px; background: rgba(9,11,14,.25); }
        th { color: var(--muted); font-size: 12px; text-transform: uppercase; letter-spacing: .08em; }
           table { width: 100%; border-collapse: collapse; overflow: hidden; border: 1px solid var(--border); border-radius: 12px; background: rgba(9,11,14,.25); }
         th, td { padding: 14px 16px; border-bottom: 1px solid var(--border); text-align: left; }
         th { color: var(--muted); font-size: 12px; text-transform: uppercase; letter-spacing: .08em; background: rgba(255,255,255,.02); }
         tr:last-child td { border-bottom: 0; }
         .page-header { display: flex; align-items: flex-end; justify-content: space-between; gap: 20px; margin-bottom: 28px; }
         .page-header h1 { margin-bottom: 0; }
         .page-actions { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
         .table-wrap { overflow-x: auto; border: 1px solid var(--border); border-radius: 12px; }
         .table-wrap table { width: 100%; min-width: 680px; border: 0; border-radius: 0; }
         .form-card { max-width: 720px; }
         .form-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 0 18px; }
         .form-full { grid-column: 1 / -1; }
         nav[role="navigation"] { display: flex; align-items: center; justify-content: space-between; gap: 18px; margin-top: 20px; color: var(--muted); font-size: 13px; }
         nav[role="navigation"] > div { display: flex; align-items: center; gap: 6px; }
         nav[role="navigation"] a, nav[role="navigation"] span { display: inline-flex; align-items: center; justify-content: center; min-width: 36px; height: 36px; padding: 0 10px; border: 1px solid var(--border); border-radius: 8px; background: var(--surface); color: var(--text); text-decoration: none; }
         nav[role="navigation"] a:hover { border-color: var(--accent); color: var(--accent); opacity: 1; }
         nav[role="navigation"] span[aria-current="page"] { border-color: var(--accent); background: var(--accent); color: #0b0e09; font-weight: 800; }
         nav[role="navigation"] span[aria-disabled="true"] { opacity: .45; }
         nav[role="navigation"] svg { width: 16px; height: 16px; }
         @media (max-width: 760px) { .topbar { align-items: flex-start; flex-direction: column; } nav { justify-content: flex-start; width: 100%; } .container { width: min(100% - 28px, 1160px); padding-top: 34px; } .card { padding: 18px; } table { display: block; overflow-x: auto; white-space: nowrap; } .page-header { align-items: flex-start; flex-direction: column; } .page-actions { width: 100%; } .form-grid { grid-template-columns: 1fr; } .form-full { grid-column: auto; } nav[role="navigation"] { align-items: flex-start; flex-direction: column; } nav[role="navigation"] > div { flex-wrap: wrap; } }
    </style>
</head>

<body>
    <header class="topbar">
        
@auth
    <form method="POST" action="{{ route('logout') }}">
        @csrf

            <button type="submit" class="btn">
            Logout
        </button>
    </form>
@endauth

        <a class="brand" href="/">
            ALFITO
            <span>FITNESS</span>
        </a>

        <nav>
            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.applications.index') }}" style="margin-right: 15px;">Pengajuan</a>
                    <a href="{{ route('admin.payments.index') }}" style="margin-right: 15px;">Pembayaran</a>
                    <a href="{{ route('admin.bookings.index') }}" style="margin-right: 15px;">Booking</a>
                    <a href="{{ route('admin.reports.index') }}" style="margin-right: 15px;">Laporan</a>
                    <a href="{{ route('admin.locations.index') }}" style="margin-right: 15px;">Lokasi</a>
                    <a href="{{ route('admin.trainers.index') }}" style="margin-right: 15px;">Trainer</a>
                    <a href="{{ route('admin.programs.index') }}" style="margin-right: 15px;">Program</a>
                    <a href="{{ route('admin.plans.index') }}">Plan</a>
                @else
                    <a href="{{ route('member.applications.index') }}" style="margin-right: 15px;">
                        Membership Saya
                    </a>
                    <a href="{{ route('member.bookings.index') }}">
                        Booking Program
                    </a>
                @endif
            @endauth
        </nav>
    </header>

    <main class="container">
        @if(session('success'))
            <div class="alert">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert">
                <strong>Periksa kembali data yang dikirim:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li class="error">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>