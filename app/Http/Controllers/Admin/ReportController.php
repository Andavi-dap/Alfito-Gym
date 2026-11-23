<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\MembershipApplication;
use App\Models\Payment;
use App\Models\ProgramBooking;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->date('from')?->startOfDay() ?? now()->startOfMonth();
        $to = $request->date('to')?->endOfDay() ?? now()->endOfDay();
        $activeMemberships = Membership::query()
            ->whereNull('cancelled_at')
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>=', now());
        $verifiedPayments = Payment::where('status', 'verified')
            ->whereBetween('verified_at', [$from, $to]);

        $stats = [
            'members' => (clone $activeMemberships)->distinct('user_id')->count('user_id'),
            'active_memberships' => (clone $activeMemberships)->count(),
            'applications' => MembershipApplication::whereBetween('created_at', [$from, $to])->count(),
            'pending_applications' => MembershipApplication::where('status', 'pending')
                ->whereBetween('created_at', [$from, $to])->count(),
            'payments' => Payment::whereBetween('created_at', [$from, $to])->count(),
            'pending_payments' => Payment::where('status', 'pending')
                ->whereBetween('created_at', [$from, $to])->count(),
            'bookings' => ProgramBooking::whereBetween('booking_date', [$from->toDateString(), $to->toDateString()])->count(),
            'pending_bookings' => ProgramBooking::where('status', 'pending')
                ->whereBetween('booking_date', [$from->toDateString(), $to->toDateString()])->count(),
            'verified_payment_count' => (clone $verifiedPayments)->count(),
            'verified_payment_total' => (clone $verifiedPayments)->sum('amount'),
        ];

        return view('admin.reports.index', compact('stats', 'from', 'to'));
    }
}
