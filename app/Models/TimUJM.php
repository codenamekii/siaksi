<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class TimUJM extends Model
{
    use HasFactory;

    protected $table = 'tim_ujm';

    protected $fillable = ['nama', 'jabatan', 'nuptk', 'email', 'no_hp', 'foto', 'program_studi_id', 'is_active', 'sort_order'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = ['foto_url'];

    /**
     * Get the URL for the foto
     */
    public function getFotoUrlAttribute()
    {
        if (!$this->foto) {
            // Return default avatar
            return 'https://ui-avatars.com/api/?background=0D8ABC&color=fff&name=' . urlencode($this->nama);
        }

        // If it's already a full URL
        if (filter_var($this->foto, FILTER_VALIDATE_URL)) {
            return $this->foto;
        }

        // Check if file exists
        if (Storage::disk('public')->exists($this->foto)) {
            return asset('storage/' . $this->foto);
        }

        // Return default avatar if file doesn't exist
        return 'https://ui-avatars.com/api/?background=0D8ABC&color=fff&name=' . urlencode($this->nama);
    }

    /**
     * Relationships
     */
    public function programStudi(): BelongsTo
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('jabatan');
    }

    /**
     * Boot method
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            // Delete foto when deleting record
            if ($model->foto && Storage::disk('public')->exists($model->foto)) {
                Storage::disk('public')->delete($model->foto);
            }
        });
    }
}
