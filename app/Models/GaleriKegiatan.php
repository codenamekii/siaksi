<?php

// 1. Update app/Models/GaleriKegiatan.php jika perlu handle multiple files
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GaleriKegiatan extends Model
{
  use HasFactory;

  protected $table = 'galeri_kegiatan';

  protected $fillable = [
    'program_studi_id',
    'judul',
    'deskripsi',
    'tipe',
    'file_path',
    'video_url',
    'tanggal_kegiatan',
    'is_active'
  ];

  protected $casts = [
    'tanggal_kegiatan' => 'date',
    'is_active' => 'boolean',
  ];

  public function programStudi()
  {
    return $this->belongsTo(ProgramStudi::class);
  }

  // Accessor untuk mendapatkan URL lengkap file
  public function getFileUrlAttribute()
  {
    if ($this->tipe === 'foto' && $this->file_path) {
      return asset('storage/' . $this->file_path);
    }
    return null;
  }

  // Accessor untuk mendapatkan YouTube video ID
  public function getYoutubeIdAttribute()
  {
    if ($this->tipe === 'video' && $this->video_url) {
      preg_match('/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $this->video_url, $matches);
      return $matches[1] ?? null;
    }
    return null;
  }

  // Scope untuk galeri aktif
  public function scopeActive($query)
  {
    return $query->where('is_active', true);
  }

  // Scope untuk filter by type
  public function scopeOfType($query, $type)
  {
    return $query->where('tipe', $type);
  }
}