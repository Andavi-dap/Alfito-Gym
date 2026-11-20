<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramBooking;
use Illuminate\Http\Request;

class ProgramBookingController extends Controller
{
    public function index()
    {
        $bookings = ProgramBooking::with(['user', 'program', 'trainer'])
            ->latest('booking_date')
            ->get();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function update(Request $request, ProgramBooking $booking)
    {
        $validated = $request->validate([
            'decision' => 'required|in:approve,reject',
        ]);

        $booking->update([
            'status' => $validated['decision'] === 'approve' ? 'approved' : 'rejected',
        ]);

        return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil diproses.');
    }
}
