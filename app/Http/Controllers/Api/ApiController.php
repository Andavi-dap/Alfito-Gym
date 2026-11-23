<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MembershipApplication;
use App\Models\MembershipPlan;
use App\Models\Program;
use App\Models\ProgramBooking;
use App\Models\Trainer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ApiController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $data = $request->validate(['email' => 'required|email', 'password' => 'required|string']);
        $user = User::where('email', $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 422);
        }
        return response()->json(['token' => $user->createToken('api')->plainTextToken, 'user' => $user]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }

    public function members(Request $request): JsonResponse
    {
        return response()->json($request->user()->load(['memberships.membershipPlan', 'applications']));
    }

    public function trainers(): JsonResponse
    {
        return response()->json(Trainer::with(['location', 'programs'])->latest()->paginate(15));
    }

    public function programs(): JsonResponse
    {
        return response()->json(Program::with('trainers')->where('is_active', true)->latest()->paginate(15));
    }

    public function plans(): JsonResponse
    {
        return response()->json(MembershipPlan::where('is_active', true)->latest()->paginate(15));
    }

    public function applications(Request $request): JsonResponse
    {
        return response()->json($request->user()->applications()->with('membershipPlan')->latest()->paginate(15));
    }

    public function storeApplication(Request $request): JsonResponse
    {
        $data = $request->validate(['membership_plan_id' => 'required|exists:membership_plans,id']);
        $plan = MembershipPlan::whereKey($data['membership_plan_id'])->where('is_active', true)->firstOrFail();
        $application = $request->user()->applications()->create([
            'membership_plan_id' => $plan->id,
            'price_snapshot' => $plan->price,
            'duration_months_snapshot' => $plan->duration_months,
            'status' => 'pending',
        ]);
        return response()->json($application->load('membershipPlan'), 201);
    }

    public function bookings(Request $request): JsonResponse
    {
        return response()->json($request->user()->bookings()->with(['program', 'trainer'])->latest()->paginate(15));
    }

    public function storeBooking(Request $request): JsonResponse
    {
        $data = $request->validate([
            'program_id' => 'required|exists:programs,id',
            'trainer_id' => 'nullable|exists:trainers,id',
            'booking_date' => 'required|date|after_or_equal:today',
        ]);
        $booking = $request->user()->bookings()->create($data + ['status' => 'pending']);
        return response()->json($booking->load(['program', 'trainer']), 201);
    }

    public function destroyBooking(Request $request, ProgramBooking $booking): JsonResponse
    {
        abort_unless($booking->user_id === $request->user()->id, 403);
        $booking->delete();
        return response()->json(['message' => 'Booking cancelled']);
    }
}
