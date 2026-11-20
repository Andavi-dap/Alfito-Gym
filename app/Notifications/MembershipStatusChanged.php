<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MembershipStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public string $status) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)->subject('Status membership berubah')->line("Status membership kamu: {$this->status}.");
    }

    public function toArray(object $notifiable): array
    {
        return ['type' => 'membership', 'status' => $this->status, 'message' => "Status membership: {$this->status}."];
    }
}
