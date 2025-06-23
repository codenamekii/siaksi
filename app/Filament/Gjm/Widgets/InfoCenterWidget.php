<?php

namespace App\Filament\Gjm\Widgets;

use App\Models\Dokumen;
use App\Models\JadwalAMI;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class InfoCenterWidget extends Widget
{
    protected static string $view = 'filament.gjm.widgets.info-center-widget';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 3;

    public function getNotifications()
    {
        $user = Auth::user();

        if (!$user) {
            return collect([]);
        }

        // Alternative approach using DatabaseNotification model directly
        return DatabaseNotification::where('notifiable_type', get_class($user))->where('notifiable_id', $user->id)->where('type', 'App\Notifications\DokumenUploadedNotification')->latest()->limit(5)->get();
    }

    public function getUpcomingAMI()
    {
        $fakultasId = Auth::user()->fakultas_id;

        return JadwalAMI::with(['fakultas', 'programStudi'])
            ->where('status', 'scheduled')
            ->where('tanggal_mulai', '>=', now())
            ->when($fakultasId, function ($query) use ($fakultasId) {
                return $query->where('fakultas_id', $fakultasId);
            })
            ->orderBy('tanggal_mulai')
            ->limit(3)
            ->get();
    }

    public function getRecentDocuments()
    {
        $fakultasId = Auth::user()->fakultas_id;

        return Dokumen::with(['user', 'programStudi'])
            ->where('is_active', true)
            ->when($fakultasId, function ($query) use ($fakultasId) {
                return $query->where(function ($q) use ($fakultasId) {
                    $q->where('fakultas_id', $fakultasId)->orWhereHas('programStudi', function ($sq) use ($fakultasId) {
                        $sq->where('fakultas_id', $fakultasId);
                    });
                });
            })
            ->latest()
            ->limit(5)
            ->get();
    }

    public function markNotificationAsRead($notificationId)
    {
        $user = Auth::user();

        if (!$user) {
            return;
        }

        DatabaseNotification::where('notifiable_type', get_class($user))
            ->where('notifiable_id', $user->id)
            ->where('type', 'App\Notifications\DokumenUploadedNotification')
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $this->dispatch('allNotificationsRead');
    }
}
