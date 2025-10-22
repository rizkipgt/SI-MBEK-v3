<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ContactMessage extends Notification
{
    use Queueable;

    public $data;

    /**
     * Create a new notification instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Pesan Kontak dari ' . $this->data['nama'])
            ->view('emails.contact_message', [
                'nama'    => $this->data['nama'],
                'email'   => $this->data['email'],
                'telepon' => $this->data['telepon'] ?? null,
                'pesan'   => $this->data['pesan'],
            ]);
    }
}
