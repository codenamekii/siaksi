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
    'level',
    'fakultas_id',
    'program_studi_id',
    'gambar',
    'judul',
    'deskripsi',
    'is_active'
  ];

  protected $casts = [
    'is_active' => 'boolean',
  ];

  protected $appends = ['gambar_url'];

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
      // Delete the image file when deleting the record
      if ($model->gambar && Storage::disk('public')->exists($model->gambar)) {
        Storage::disk('public')->delete($model->gambar);
      }
    });
  }

  /**
   * Get the URL for the gambar
   */
  public function getGambarUrlAttribute()
  {
    if (!$this->gambar) {
      return null;
    }

    // Clean path from prefixes
    $path = $this->gambar;
    $path = ltrim($path, '/');
    $path = str_replace(['storage/', '/storage/'], '', $path);

    // Check if file exists
    if (Storage::disk('public')->exists($path)) {
      return asset('storage/' . $path);
    }

    // Try to find file in alternative locations
    $filename = basename($path);
    $alternatives = [
      'struktur/prodi/' . $filename,
      'struktur/' . $filename,
      $filename
    ];

    foreach ($alternatives as $altPath) {
      if (Storage::disk('public')->exists($altPath)) {
        return asset('storage/' . $altPath);
      }
    }

    // Return placeholder or null
    return null;
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