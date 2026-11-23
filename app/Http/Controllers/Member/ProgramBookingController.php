<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\ProgramBooking;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProgramBookingController extends Controller
{
    public function index(Request $request)
    {
        $programs = Program::where('is_active', true)->orderBy('name')->get();
        $trainers = Trainer::orderBy('name')->get();
        $bookings = ProgramBooking::with(['program', 'trainer'])
            ->where('user_id', $request->user()->id)
            ->latest('booking_date')
            ->get();

        return view('member.bookings.index', compact('programs', 'trainers', 'bookings'));
    }

    public function checkout(Request $request, Program $program)
    {
        abort_unless($program->is_active, 404);
        $program->load('trainers');

        return view('member.bookings.checkout', compact('program'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'program_id' => 'required|exists:programs,id',
            'trainer_id' => 'nullable|exists:trainers,id',
            'booking_date' => 'required|date|after_or_equal:today',
        ]);

        $program = Program::where('is_active', true)->findOrFail($validated['program_id']);
        $hasMembership = $request->user()->memberships()
            ->whereNull('cancelled_at')
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>=', now())
            ->exists();

        if (!$hasMembership) {
            throw ValidationException::withMessages([
                'booking' => 'Booking hanya tersedia untuk member dengan membership aktif.',
            ]);
        }

        if (!empty($validated['trainer_id']) && !$program->trainers()->whereKey($validated['trainer_id'])->exists()) {
            throw ValidationException::withMessages([
                'trainer_id' => 'Trainer tidak tersedia untuk program ini.',
            ]);
        }

        $bookingDate = $validated['booking_date'];
        $conflict = ProgramBooking::query()
            ->whereDate('booking_date', $bookingDate)
            ->whereIn('status', ['pending', 'approved'])
            ->where(function ($query) use ($validated, $request) {
                if (!empty($validated['trainer_id'])) {
                    $query->where('trainer_id', $validated['trainer_id']);
                } else {
                    $query->where('user_id', $request->user()->id)
                        ->where('program_id', $validated['program_id']);
                }
            })
            ->exists();

        if ($conflict) {
            throw ValidationException::withMessages([
                'booking_date' => 'Jadwal booking bentrok. Pilih tanggal atau trainer lain.',
            ]);
        }

        ProgramBooking::create([
            ...$validated,
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('member.bookings.index')->with('success', 'Booking berhasil dibuat.');
    }

    public function destroy(Request $request, ProgramBooking $booking)
    {
        abort_unless($booking->user_id === $request->user()->id, 403);
        $booking->update(['status' => 'cancelled']);

        return redirect()->route('member.bookings.index')->with('success', 'Booking berhasil dibatalkan.');
    }
}
