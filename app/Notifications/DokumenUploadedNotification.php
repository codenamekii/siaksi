<?php

namespace App\Notifications;

use App\Models\Dokumen;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class DokumenUploadedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $dokumen;
    protected $uploader;

    /**
     * Create a new notification instance.
     */
    public function __construct(Dokumen $dokumen, User $uploader)
    {
        $this->dokumen = $dokumen;
        $this->uploader = $uploader;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database']; // Bisa tambah 'mail' jika ingin email juga
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('Dokumen Baru Diupload')
            ->greeting('Halo ' . $notifiable->name . '!')
            ->line('Ada dokumen baru yang diupload oleh ' . $this->uploader->name)
            ->line('Nama Dokumen: ' . $this->dokumen->nama)
            ->line('Kategori: ' . $this->dokumen->kategori_label)
            ->line('Program Studi: ' . ($this->dokumen->programStudi->nama ?? 'N/A'))
            ->action('Lihat Dokumen', url('/gjm/dokumens/' . $this->dokumen->id . '/edit'))
            ->line('Terima kasih telah menggunakan aplikasi kami!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Dokumen Baru Diupload',
            'body' => $this->uploader->name . ' telah mengupload dokumen "' . $this->dokumen->nama . '"',
            'icon' => 'heroicon-o-document-arrow-up',
            'icon_color' => 'success',
            'actions' => [
                [
                    'name' => 'view',
                    'label' => 'Lihat Dokumen',
                    'url' => '/gjm/dokumens/' . $this->dokumen->id . '/edit',
                    'color' => 'primary',
                    'icon' => 'heroicon-o-eye',
                ],
            ],
            'dokumen_id' => $this->dokumen->id,
            'dokumen_nama' => $this->dokumen->nama,
            'dokumen_kategori' => $this->dokumen->kategori_label,
            'uploader_id' => $this->uploader->id,
            'uploader_name' => $this->uploader->name,
            'uploader_role' => $this->uploader->role_name,
            'program_studi' => $this->dokumen->programStudi->nama ?? null,
            'fakultas' => $this->dokumen->fakultas->nama ?? null,
            'uploaded_at' => $this->dokumen->created_at->format('d M Y H:i'),
        ];
    }

    /**
     * Get the type of the notification.
     */
    public function type(): string
    {
        return 'dokumen-uploaded';
    }

    /**
     * Get the notification's database type.
     */
    public function databaseType(object $notifiable): string
    {
        return 'dokumen-uploaded';
    }
}
