<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Berita extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'berita';

    protected $fillable = ['fakultas_id', 'program_studi_id', 'judul', 'slug', 'konten', 'gambar', 'kategori', 'status', 'tanggal_publikasi', 'views', 'created_by', 'updated_by'];

    protected $casts = [
        'tanggal_publikasi' => 'datetime',
        'views' => 'integer',
    ];

    /**
     * Boot method to auto-generate slug
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($berita) {
            if (empty($berita->slug)) {
                $berita->slug = Str::slug($berita->judul);
            }
        });

        static::updating(function ($berita) {
            if ($berita->isDirty('judul') && empty($berita->slug)) {
                $berita->slug = Str::slug($berita->judul);
            }
        });
    }

    /**
     * Relations
     */
    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class);
    }

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Alias for creator - some parts of the app expect 'user' relationship
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scopes
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')->where('tanggal_publikasi', '<=', now());
    }

    public function scopeBerita($query)
    {
        return $query->where('kategori', 'berita');
    }

    public function scopePengumuman($query)
    {
        return $query->where('kategori', 'pengumuman');
    }

    public function scopeForFakultas($query, $fakultasId)
    {
        return $query->where('fakultas_id', $fakultasId)->whereNull('program_studi_id');
    }

    public function scopeForProdi($query, $prodiId)
    {
        return $query->where('program_studi_id', $prodiId);
    }

    /**
     * Accessors
     */
    public function getIsPublishedAttribute()
    {
        return $this->status === 'published' && $this->tanggal_publikasi <= now();
    }

    public function getOwnerAttribute()
    {
        if ($this->program_studi_id) {
            return $this->programStudi->nama;
        } elseif ($this->fakultas_id) {
            return $this->fakultas->nama;
        }
        return 'Unknown';
    }

    public function getOwnerTypeAttribute()
    {
        if ($this->program_studi_id) {
            return 'Program Studi';
        } elseif ($this->fakultas_id) {
            return 'Fakultas';
        }
        return 'Unknown';
    }

    /**
     * Accessor untuk published_at (alias untuk tanggal_publikasi)
     */
    public function getPublishedAtAttribute()
    {
        return $this->tanggal_publikasi;
    }

    /**
     * Mutator untuk published_at (alias untuk tanggal_publikasi)
     */
    public function setPublishedAtAttribute($value)
    {
        $this->attributes['tanggal_publikasi'] = $value;
    }

    /**
     * Media Library Configuration
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('gambar')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/gif']);
    }
}
