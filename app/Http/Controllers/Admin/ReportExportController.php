<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class ReportExportController extends Controller
{
    public function payments(Request $request)
    {
        $from = $request->date('from')?->startOfDay() ?? now()->startOfMonth();
        $to = $request->date('to')?->endOfDay() ?? now()->endOfDay();
        $payments = Payment::with('application.user')
            ->where('status', 'verified')
            ->whereBetween('verified_at', [$from, $to])
            ->latest('verified_at')
            ->get();

        return response()->streamDownload(function () use ($payments) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Member', 'Email', 'Jumlah', 'Metode', 'Tanggal Verifikasi']);
            foreach ($payments as $payment) {
                fputcsv($handle, [
                    $payment->id,
                    $payment->application?->user?->name,
                    $payment->application?->user?->email,
                    $payment->amount,
                    $payment->method,
                    $payment->verified_at?->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($handle);
        }, 'laporan-pemasukan-' . now()->format('Y-m-d') . '.csv', ['Content-Type' => 'text/csv']);
    }
}
