<?php

namespace App\Http\Controllers;

use App\Services\MidtransPaymentService;
use Illuminate\Http\Request;

class MidtransWebhookController extends Controller
{
    public function __invoke(Request $request, MidtransPaymentService $midtrans)
    {
        $payload = $request->all();
        $signature = hash('sha512', ($payload['order_id'] ?? '').($payload['status_code'] ?? '').($payload['gross_amount'] ?? '').config('services.midtrans.server_key'));
        abort_unless(hash_equals($signature, (string) ($payload['signature_key'] ?? '')), 403);
        $midtrans->handleNotification($payload);

        return response()->json(['status' => 'ok']);
    }
}
