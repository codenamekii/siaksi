<?php

namespace App\Observers;

use App\Models\Dokumen;
use App\Models\User;
use App\Notifications\DokumenUploadedNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class DokumenObserver
{
    /**
     * Handle the Dokumen "created" event.
     */
    public function created(Dokumen $dokumen): void
    {
        Log::info('DokumenObserver: created method called', [
            'dokumen_id' => $dokumen->id,
            'user_id' => $dokumen->user_id,
            'user_role' => $dokumen->user ? $dokumen->user->role : null,
        ]);

        // Hanya kirim notifikasi jika dokumen diupload oleh UJM
        if ($dokumen->user && $dokumen->user->isUJM()) {
            Log::info('DokumenObserver: User is UJM, sending notifications');

            // Ambil semua user GJM
            $gjmUsers = User::where('role', 'gjm')->where('is_active', true)->get();

            Log::info('DokumenObserver: Found GJM users', ['count' => $gjmUsers->count()]);

            // Jika dokumen level prodi, notifikasi juga ke GJM yang satu fakultas
            if ($dokumen->level === 'prodi' && $dokumen->programStudi) {
                $gjmUsers = $gjmUsers->filter(function ($gjm) use ($dokumen) {
                    // Kirim ke semua GJM atau GJM yang satu fakultas dengan prodi tersebut
                    return !$gjm->fakultas_id || $gjm->fakultas_id === $dokumen->programStudi->fakultas_id;
                });
            }

            // Kirim notifikasi ke setiap GJM
            foreach ($gjmUsers as $gjm) {
                try {
                    $gjm->notify(new DokumenUploadedNotification($dokumen, $dokumen->user));
                    Log::info('DokumenObserver: Notification sent to GJM', ['gjm_id' => $gjm->id]);
                } catch (\Exception $e) {
                    Log::error('DokumenObserver: Failed to send notification', [
                        'gjm_id' => $gjm->id,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        } else {
            Log::info('DokumenObserver: User is not UJM, skipping notification');
        }
    }

    /**
     * Handle the Dokumen "updated" event.
     */
    public function updated(Dokumen $dokumen): void
    {
        // Bisa tambahkan notifikasi untuk update jika diperlukan
    }

    /**
     * Handle the Dokumen "deleted" event.
     */
    public function deleted(Dokumen $dokumen): void
    {
        // Bisa tambahkan notifikasi untuk delete jika diperlukan
    }

    /**
     * Handle the Dokumen "restored" event.
     */
    public function restored(Dokumen $dokumen): void
    {
        //
    }

    /**
     * Handle the Dokumen "force deleted" event.
     */
    public function forceDeleted(Dokumen $dokumen): void
    {
        //
    }
}
