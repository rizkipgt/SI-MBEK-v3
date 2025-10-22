<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatusDijualChanged extends Notification
{
    public $hewan;
    public $oldStatus;
    public $oldHarga;
    public $jenisHewan;
    public $namaHewan;
    public $newStatus;
    public $newHarga;
    public $statusBerubah;
    public $hargaBerubah;

    /**
     * Create a new notification instance.
     *
     * @param mixed $hewan
     * @param string $oldStatus
     * @param int|float|null $oldHarga
     * @param string $jenisHewan
     */
    public function __construct($hewan, $oldStatus, $oldHarga, $jenisHewan)
    {
        $this->hewan = $hewan;
        $this->oldStatus = $oldStatus;
        $this->oldHarga = $oldHarga;
        $this->jenisHewan = $jenisHewan;
        $this->namaHewan = ucfirst($jenisHewan);
        $this->newStatus = $this->hewan->for_sale;
        $this->newHarga = $this->hewan->harga;
        $this->statusBerubah = $this->oldStatus != $this->newStatus;
        $this->hargaBerubah = $this->oldHarga != $this->newHarga;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {

        $subject = "Perubahan ";

        if ($this->statusBerubah) {
            $subject .= "Status {$this->namaHewan}";
        } elseif ($this->hargaBerubah) {
            $subject .= "Harga {$this->namaHewan}";
        }


        return (new MailMessage())
            ->subject($subject)
            ->view('emails.status_dijual_changed', [
                'namaHewan' => $this->namaHewan,
                'user'=>$notifiable,
                'hewan' => $this->hewan,
                'oldStatus' => $this->oldStatus,
                'newStatus' => $this->newStatus,
                'statusBerubah' => $this->statusBerubah,
                'hargaBerubah' => $this->hargaBerubah,
                'oldHarga' => $this->oldHarga,
                'newHarga' => $this->newHarga,
                'jenisHewan' => $this->jenisHewan
            ]);
    }

    public function toArray($notifiable)
    {
        return [];
    }
}
