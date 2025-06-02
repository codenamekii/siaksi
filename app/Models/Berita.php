<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Support\Facades\Auth;

class Berita extends Model implements HasMedia
{
  use HasFactory, InteractsWithMedia;

  protected $table = 'berita';

  protected $fillable = [
    'user_id',
    'judul',
    'slug',
    'konten',
    'kategori',
    'level',
    'program_studi_id',
    'is_published',
    'published_at'
  ];

  protected $casts = [
    'is_published' => 'boolean',
    'published_at' => 'datetime',
  ];

  protected static function boot()
  {
    parent::boot();

    static::creating(function ($model) {
      if (empty($model->slug)) {
        $model->slug = Str::slug($model->judul);
      }

      $originalSlug = $model->slug;
      $count = 0;

      while (static::where('slug', $model->slug)->exists()) {
        $count++;
        $model->slug = $originalSlug . '-' . $count;
      }
    });

    static::updating(function ($model) {
      if ($model->is_published && !$model->published_at) {
        $model->published_at = now();
      }
    });
  }

  public function registerMediaCollections(): void
  {
    $this->addMediaCollection('gambar')
      ->singleFile()
      ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function programStudi()
  {
    return $this->belongsTo(ProgramStudi::class);
  }

  public function getFakultasAttribute()
  {
    if ($this->level === 'prodi' && $this->programStudi) {
      return $this->programStudi->fakultas;
    }

    if ($this->level === 'fakultas' && $this->user && $this->user->fakultas_id) {
      return $this->user->fakultas;
    }

    return null;
  }

  public function scopePublished($query)
  {
    return $query->where('is_published', true)
      ->whereNotNull('published_at')
      ->where('published_at', '<=', now());
  }

  public function scopeDraft($query)
  {
    return $query->where('is_published', false);
  }

  public function scopeFakultas($query)
  {
    return $query->where('level', 'fakultas')
      ->whereNull('program_studi_id');
  }

  public function scopeProdi($query)
  {
    return $query->where('level', 'prodi')
      ->whereNotNull('program_studi_id');
  }

  public function scopeInFakultas($query, $fakultasId)
  {
    return $query->where(function ($q) use ($fakultasId) {
      $q->where('level', 'fakultas')
        ->whereHas('user', function ($q2) use ($fakultasId) {
          $q2->where('fakultas_id', $fakultasId);
        })
        ->orWhere(function ($q2) use ($fakultasId) {
          $q2->where('level', 'prodi')
            ->whereHas('programStudi', function ($q3) use ($fakultasId) {
              $q3->where('fakultas_id', $fakultasId);
            });
        });
    });
  }

  public function getFormattedPublishedDateAttribute()
  {
    return $this->published_at ? $this->published_at->format('d M Y') : null;
  }

  public function getExcerptAttribute($length = 150)
  {
    return Str::limit(strip_tags($this->konten), $length);
  }

  public function canEdit()
  {
    $user = Auth::user();

    if ($user->id === $this->user_id) {
      return true;
    }

    if ($user->isGJM() && $this->level === 'fakultas') {
      return optional($this->user)->fakultas_id === $user->fakultas_id;
    }

    if ($user->isUJM() && $this->level === 'prodi') {
      return $this->program_studi_id === $user->program_studi_id;
    }

    return false;
  }
}