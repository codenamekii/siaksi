<?php

// Lokasi file: app/Models/StrukturOrganisasi.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class StrukturOrganisasi extends Model
{
    use HasFactory;

    protected $table = 'struktur_organisasi';

    protected $fillable = [
        'nama',
        'level',
        'fakultas_id',
        'program_studi_id',
        'file_path', // Changed from 'gambar' to 'file_path'
        'tipe', // Added tipe
        'deskripsi',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = ['file_url'];

    /**
     * Boot method to handle model events
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // If this is set as active, deactivate others
            if ($model->is_active) {
                static::where('level', $model->level)
                    ->when($model->level === 'prodi', function ($query) use ($model) {
                        return $query->where('program_studi_id', $model->program_studi_id);
                    })
                    ->when($model->level === 'fakultas', function ($query) use ($model) {
                        return $query->where('fakultas_id', $model->fakultas_id);
                    })
                    ->update(['is_active' => false]);
            }
        });

        static::updating(function ($model) {
            // If this is being set as active, deactivate others
            if ($model->is_active && $model->isDirty('is_active')) {
                static::where('level', $model->level)
                    ->where('id', '!=', $model->id)
                    ->when($model->level === 'prodi', function ($query) use ($model) {
                        return $query->where('program_studi_id', $model->program_studi_id);
                    })
                    ->when($model->level === 'fakultas', function ($query) use ($model) {
                        return $query->where('fakultas_id', $model->fakultas_id);
                    })
                    ->update(['is_active' => false]);
            }
        });

        static::deleting(function ($model) {
            // Delete the file when deleting the record
            if ($model->file_path && Storage::disk('public')->exists($model->file_path)) {
                Storage::disk('public')->delete($model->file_path);
            }
        });
    }

    /**
     * Get the URL for the file
     */
    public function getFileUrlAttribute()
    {
        if (!$this->file_path) {
            return null;
        }

        // Return the proper URL
        return asset('storage/' . $this->file_path);
    }

    /**
     * Get the URL for the gambar (backward compatibility)
     */
    public function getGambarUrlAttribute()
    {
        return $this->file_url;
    }

    /**
     * Relationships
     */
    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class);
    }

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeProdi($query)
    {
        return $query->where('level', 'prodi');
    }

    public function scopeFakultas($query)
    {
        return $query->where('level', 'fakultas');
    }

    public function scopeUniversitas($query)
    {
        return $query->where('level', 'universitas');
    }

    /**
     * Get the active struktur for a specific level and entity
     */
    public static function getActive($level, $entityId = null)
    {
        $query = static::where('level', $level)->where('is_active', true);

        switch ($level) {
            case 'prodi':
                return $query->where('program_studi_id', $entityId)->first();
            case 'fakultas':
                return $query->where('fakultas_id', $entityId)->first();
            case 'universitas':
                return $query->first();
        }

        return null;
    }
}
