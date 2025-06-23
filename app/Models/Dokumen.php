<?php

// Lokasi file: app/Models/Dokumen.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

class Dokumen extends Model implements HasMedia
{
  use HasFactory, InteractsWithMedia;

  protected $table = 'dokumen';

  protected $fillable = [
    'user_id',
    'nama',
    'deskripsi',
    'tipe',
    'path',
    'url',
    'kriteria',
    'sub_kriteria',
    'catatan',
    'kategori',
    'sub_kategori',    // untuk detail jenis laporan
    'periode',         // untuk periode laporan
    'tahun',          // untuk tahun laporan
    'temuan',         // untuk temuan laporan (JSON)
    'level',
    'fakultas_id',
    'program_studi_id',
    'is_visible_to_asesor',
    'can_access_asesor', // Add this if column exists
    'is_active'
  ];

  protected $casts = [
    'is_visible_to_asesor' => 'boolean',
    'can_access_asesor' => 'boolean',
    'is_active' => 'boolean',
    'temuan' => 'array', // Cast JSON field to array
    'created_at' => 'datetime',
    'updated_at' => 'datetime'
  ];

  const KATEGORI_OPTIONS = [
    'kebijakan_mutu' => 'Kebijakan Mutu',
    'standar_mutu' => 'Standar Mutu',
    'manual_mutu' => 'Manual Mutu',
    'prosedur_mutu' => 'Prosedur Mutu',
    'instruksi_kerja' => 'Instruksi Kerja',
    'formulir' => 'Formulir',
    'laporan_ami' => 'Laporan AMI',
    'laporan_survei' => 'Laporan Survei',
    'evaluasi_diri' => 'Evaluasi Diri',
    'lkps' => 'LKPS',
    'sertifikat_akreditasi' => 'Sertifikat Akreditasi',
    'rencana_strategis' => 'Rencana Strategis',
    'data_pendukung' => 'Data Pendukung',
    'kurikulum' => 'Kurikulum',
    'lainnya' => 'Lainnya'
  ];

  const LEVEL_OPTIONS = [
    'universitas' => 'Universitas',
    'fakultas' => 'Fakultas',
    'prodi' => 'Program Studi'
  ];

  /**
   * Boot method to handle model events
   */
  protected static function boot()
  {
    parent::boot();

    static::creating(function ($model) {
      // Set default values if not set
      $model->is_active = $model->is_active ?? true;

      // Default visibility for asesor should be true unless explicitly set to false
      $model->is_visible_to_asesor = $model->is_visible_to_asesor ?? true;

      // Auto-set level based on ownership
      if (!$model->level) {
        if ($model->program_studi_id) {
          $model->level = 'prodi';
        } elseif ($model->fakultas_id) {
          $model->level = 'fakultas';
        } else {
          $model->level = 'universitas';
        }
      }
    });
  }

  /**
   * Register media collections
   */
  public function registerMediaCollections(): void
  {
    $this->addMediaCollection('dokumen')
      ->acceptsMimeTypes([
        'application/pdf',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'image/jpeg',
        'image/png',
        'image/webp'
      ])
      ->singleFile();
  }

  /**
   * Relationships
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }

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

  /**
   * Updated scope to be more flexible
   */
  public function scopeVisibleToAsesor($query)
  {
    // Check if column exists
    if (Schema::hasColumn('dokumen', 'can_access_asesor')) {
      return $query->where('can_access_asesor', true);
    }

    // Fallback to is_visible_to_asesor
    return $query->where('is_visible_to_asesor', true);
  }

  /**
   * Scope for getting all documents accessible by asesor
   */
  public function scopeAccessibleByAsesor($query)
  {
    // If user is GJM viewing as asesor, show all documents
    $user = Auth::user();
    if ($user && $user->role === 'gjm') {
      return $query->where('is_active', true);
    }

    // Otherwise check visibility flag
    return $query->where('is_active', true)
      ->where('is_visible_to_asesor', true);
  }

  public function scopeLaporan($query)
  {
    return $query->whereIn('kategori', [
      'laporan_ami',
      'laporan_survei',
      'analisis_capaian',
      'rencana_tindak_lanjut',
      'laporan_kinerja'
    ]);
  }

  public function scopeByLevel($query, $level)
  {
    return $query->where('level', $level);
  }

  public function scopeByKategori($query, $kategori)
  {
    return $query->where('kategori', $kategori);
  }

  /**
   * Attributes
   */
  public function getIsFileAttribute()
  {
    return $this->tipe === 'file';
  }

  public function getIsUrlAttribute()
  {
    return $this->tipe === 'url';
  }

  public function getIsImageAttribute()
  {
    return $this->tipe === 'image';
  }

  /**
   * Get the download URL for the document
   */
  public function getDownloadUrlAttribute()
  {
    if ($this->tipe === 'url') {
      return $this->url;
    }

    if ($this->tipe === 'file' && $this->path) {
      return asset('storage/' . $this->path);
    }

    // If using Spatie Media Library
    if ($this->getFirstMedia('dokumen')) {
      return $this->getFirstMediaUrl('dokumen');
    }

    return null;
  }

  /**
   * Get formatted kategori name
   */
  public function getKategoriLabelAttribute()
  {
    $labels = [
      'kebijakan_mutu' => 'Kebijakan Mutu',
      'standar_mutu' => 'Standar Mutu',
      'prosedur' => 'Prosedur',
      'instrumen' => 'Instrumen',
      'laporan_ami' => 'Laporan AMI',
      'laporan_survei' => 'Laporan Survei',
      'evaluasi_diri' => 'Evaluasi Diri',
      'lkps' => 'LKPS',
      'sertifikat_akreditasi' => 'Sertifikat Akreditasi',
      'kurikulum' => 'Kurikulum',
      'data_pendukung' => 'Data Pendukung',
      'rencana_strategis' => 'Rencana Strategis',
      'dokumentasi_kegiatan' => 'Dokumentasi Kegiatan',
      'analisis_capaian' => 'Analisis Capaian',
      'rencana_tindak_lanjut' => 'Rencana Tindak Lanjut',
      'laporan_kinerja' => 'Laporan Kinerja'
    ];

    return $labels[$this->kategori] ?? ucwords(str_replace('_', ' ', $this->kategori));
  }

  /**
   * Get periode tahun combined
   */
  public function getPeriodeTahunAttribute()
  {
    $periode = $this->periode ? ucwords(str_replace('_', ' ', $this->periode)) : '';
    $tahun = $this->tahun ?? date('Y');

    return trim($periode . ' ' . $tahun);
  }

  /**
   * Check if user can edit this document
   */
  public function canEdit($user = null)
  {
    $user = $user ?? Auth::user();

    if (!$user) return false;

    // GJM can edit all documents
    if ($user->role === 'gjm') {
      return true;
    }

    // Owner can always edit
    if ($user->id === $this->user_id) {
      return true;
    }

    // Check based on user role and document level
    if ($user->isGJM() && $this->level === 'fakultas' && Schema::hasColumn('users', 'fakultas_id')) {
      return $this->fakultas_id === $user->fakultas_id;
    }

    if ($user->isUJM() && $this->level === 'prodi' && Schema::hasColumn('users', 'program_studi_id')) {
      return $this->program_studi_id === $user->program_studi_id;
    }

    return false;
  }
}
