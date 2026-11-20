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
        $verifiedPayments = Payment::where('status', 'verified')
            ->whereBetween('verified_at', [$from, $to]);

        $stats = [
            'members' => User::where('role', 'member')->count(),
            'active_memberships' => Membership::query()
                ->whereNull('cancelled_at')
                ->where('starts_at', '<=', now())
                ->where('ends_at', '>=', now())
                ->count(),
            'applications' => MembershipApplication::count(),
            'pending_applications' => MembershipApplication::where('status', 'pending')->count(),
            'payments' => Payment::count(),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'bookings' => ProgramBooking::count(),
            'pending_bookings' => ProgramBooking::where('status', 'pending')->count(),
            'verified_payment_count' => (clone $verifiedPayments)->count(),
            'verified_payment_total' => (clone $verifiedPayments)->sum('amount'),
        ];

        return view('admin.reports.index', compact('stats', 'from', 'to'));
    }
}
