<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public string $status) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)->subject('Status pembayaran berubah')->line("Status pembayaran kamu: {$this->status}.");
    }

    public function toArray(object $notifiable): array
    {
        return ['type' => 'payment', 'status' => $this->status, 'message' => "Status pembayaran: {$this->status}."];
    }
}
