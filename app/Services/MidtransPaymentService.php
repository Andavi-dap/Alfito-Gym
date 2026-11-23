<?php

namespace App\Services;

use App\Models\MembershipApplication;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class MidtransPaymentService
{
    public function __construct(
        private MembershipWorkflowService $workflow
    ) {}

    public function createSnapToken(MembershipApplication $application, User $user): string
    {
        $serverKey = config('services.midtrans.server_key');
        if (!$serverKey) {
            throw ValidationException::withMessages([
                'payment' => 'Payment gateway belum dikonfigurasi.',
            ]);
        }

        $orderId = 'ALFITO-'.$application->id.'-'.now()->format('YmdHis');
        $response = Http::withBasicAuth($serverKey, '')
            ->post(config('services.midtrans.snap_url').'/transactions', [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => (int) $application->price_snapshot,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                ],
            ])
            ->throw();

        $payment = $application->payments()->create([
            'amount' => $application->price_snapshot,
            'method' => 'midtrans_snap',
            'gateway' => 'midtrans',
            'gateway_order_id' => $orderId,
            'status' => 'pending',
        ]);

        $payment->update(['gateway_transaction_id' => $response->json('token')]);

        return $response->json('token');
    }

    public function handleNotification(array $payload): Payment
    {
        $orderId = $payload['order_id'] ?? null;
        $status = $payload['transaction_status'] ?? null;
        $payment = Payment::where('gateway_order_id', $orderId)->firstOrFail();
        $payment->update([
            'status' => in_array($status, ['settlement', 'capture'], true) ? 'verified' : ($status === 'cancel' || $status === 'deny' ? 'rejected' : 'pending'),
            'gateway_transaction_id' => $payload['transaction_id'] ?? $payment->gateway_transaction_id,
            'gateway_payload' => $payload,
            'verified_at' => in_array($status, ['settlement', 'capture'], true) ? now() : null,
        ]);

        $payment = $payment->refresh();
        if ($payment->status === 'verified') {
            $this->workflow->settleGatewayPayment($payment->id);
        }

        return $payment;
    }
}
