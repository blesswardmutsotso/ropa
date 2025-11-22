<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewRopaSubmitted extends Notification implements ShouldQueue
{
    use Queueable;

    public $ropa;

    public function __construct($ropa)
    {
        $this->ropa = $ropa;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('New ROPA Submission')
            ->greeting('Hello Admin,')
            ->line('A new ROPA has been submitted.')
            ->line('Organisation: ' . ($this->ropa->organisation_name ?? 'N/A'))
            ->line('Department: ' . ($this->ropa->department ?? 'N/A'))
            ->line('Status: ' . $this->ropa->status)
            ->action('View ROPA', url('/ropa/' . $this->ropa->id))
            ->line('Submitted by User ID: ' . $this->ropa->user_id);
    }

    public function toArray($notifiable)
    {
        return [
            'ropa_id' => $this->ropa->id,
            'organisation_name' => $this->ropa->organisation_name,
            'department' => $this->ropa->department,
            'status' => $this->ropa->status,
        ];
    }
}
