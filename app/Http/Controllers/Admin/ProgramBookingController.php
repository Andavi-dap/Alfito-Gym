<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramBooking;
use App\Notifications\BookingStatusChanged;
use Illuminate\Http\Request;

class ProgramBookingController extends Controller
{
    public function index()
    {
        $bookings = ProgramBooking::with(['user', 'program', 'trainer'])
            ->latest('booking_date')
            ->paginate(10);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function update(Request $request, ProgramBooking $booking)
    {
        $validated = $request->validate([
            'decision' => 'required|in:approve,reject',
        ]);

        $status = $validated['decision'] === 'approve' ? 'approved' : 'rejected';
        $booking->update(['status' => $status]);
        $booking->load('user');
        $booking->user->notify(new BookingStatusChanged($status));

        return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil diproses.');
    }
}
