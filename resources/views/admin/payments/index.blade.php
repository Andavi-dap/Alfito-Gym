@extends('layouts.Alfito')

@section('title', 'Verifikasi Pembayaran | Alfito Fitness')

@section('content')
    <p class="eyebrow">ADMINISTRATION</p>
    <h1>Payment Verification</h1>
    <p class="muted">
        Periksa bukti pembayaran sebelum mengaktifkan membership.
    </p>

    @forelse($payments as $payment)
        <div class="card">
            <h3>
                Pembayaran #{{ $payment->id }}
            </h3>

            <p>
                Member: {{ $payment->application->user->name }}
            </p>

            <p>
                Paket: {{ $payment->application->membershipPlan->name }}
            </p>

            <p>
                Jumlah:
                Rp {{ number_format((float) $payment->amount, 0, ',', '.') }}
            </p>

            <p>
                Referensi:
                {{ $payment->reference_number ?: '-' }}
            </p>

            <p>
                Status:
                <span class="status">{{ $payment->status }}</span>
            </p>

            @if($payment->proof_path)
                @php
                    $isPdf = str_ends_with(strtolower($payment->proof_path), '.pdf');
                @endphp
                <p>
                    <a
                        href="{{ route('admin.payments.proof', $payment->id) }}"
                        target="_blank"
                        rel="noopener"
                        style="display: inline-block; margin-bottom: 10px; color: var(--accent); font-weight: bold;"
                    >
                        🔍 Buka File Bukti Pembayaran ({{ $isPdf ? 'PDF' : 'Gambar' }})
                    </a>
                    @if(!$isPdf)
                        <div style="max-width: 300px; border: 1px solid var(--border); border-radius: 8px; overflow: hidden; background: #000;">
                            <img src="data:{{ in_array(strtolower(pathinfo($payment->proof_path, PATHINFO_EXTENSION)), ['jpg', 'jpeg']) ? 'image/jpeg' : 'image/png' }};base64,{{ base64_encode(Storage::disk('local')->get($payment->proof_path)) }}" alt="Bukti Pembayaran" style="width: 100%; height: auto; display: block;" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                            <p style="display:none; padding: 10px; color: #ff6b6b; font-size: 12px; margin:0;">Gagal memuat preview gambar.</p>
                        </div>
                    @else
                        <div style="padding: 10px; background: rgba(255,255,255,.05); border-radius: 8px; font-size: 13px; color: var(--muted);">
                            Format file PDF. Klik tautan di atas untuk melihat dokumen.
                        </div>
                    @endif
                </p>
            @endif

            @if($payment->status === 'pending')
                <form
                    action="{{ route('admin.payments.decision', $payment->id) }}"
                    method="POST"
                >
                    @csrf
                    @method('PATCH')

                    <label for="decision-{{ $payment->id }}">
                        Keputusan pembayaran
                    </label>

                    <select
                        id="decision-{{ $payment->id }}"
                        name="decision"
                        required
                    >
                        <option value="approve">Verifikasi pembayaran</option>
                        <option value="reject">Tolak pembayaran</option>
                    </select>

                    <label for="notes-{{ $payment->id }}">
                        Catatan (opsional)
                    </label>

                    <textarea
                        id="notes-{{ $payment->id }}"
                        name="notes"
                        maxlength="1000"
                        rows="3"
                    ></textarea>

                    <button class="btn" type="submit">
                        Proses Pembayaran
                    </button>
                </form>
            @endif
        </div>
    @empty
        <p>Belum ada pembayaran yang tercatat.</p>
    @endforelse
@endsection