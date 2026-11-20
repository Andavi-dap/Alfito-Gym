<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\ProgramBooking;
use App\Models\Trainer;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'program_id' => 'required|exists:programs,id',
            'trainer_id' => 'nullable|exists:trainers,id',
            'booking_date' => 'required|date|after_or_equal:today',
        ]);

        $program = Program::where('is_active', true)->findOrFail($validated['program_id']);

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
