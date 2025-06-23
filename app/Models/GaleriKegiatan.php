<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class GaleriKegiatan extends Model
{
    use HasFactory;

    protected $table = 'galeri_kegiatan';

    protected $fillable = ['judul', 'deskripsi', 'gambar', 'tanggal_kegiatan', 'kategori', 'program_studi_id', 'fakultas_id', 'is_active', 'urutan', 'created_by'];

    protected $casts = [
        'gambar' => 'array', // Cast to array for multiple images
        'tanggal_kegiatan' => 'date',
        'is_active' => 'boolean',
        'urutan' => 'integer',
    ];

    // Relations
    public function programStudi(): BelongsTo
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }

    public function fakultas(): BelongsTo
    {
        return $this->belongsTo(Fakultas::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Fixed Accessor for gambar URL
    public function getGambarUrlAttribute()
    {
        // Get the first image
        $image = $this->first_image;

        if (empty($image)) {
            return null;
        }

        // If it's already a full URL, return as is
        if (filter_var($image, FILTER_VALIDATE_URL)) {
            return $image;
        }

        // Remove 'storage/' prefix if exists
        $path = $image;
        if (is_string($path) && str_starts_with($path, 'storage/')) {
            $path = substr($path, 8);
        }

        // Check if file exists directly
        if (file_exists(storage_path('app/public/' . $path))) {
            return asset('storage/' . $path);
        }

        // Try without any subfolder (just filename)
        $filename = basename($path);
        if (file_exists(storage_path('app/public/' . $filename))) {
            return asset('storage/' . $filename);
        }

        // Try common galeri paths
        $possiblePaths = ['galeri/' . $filename, 'galeri-kegiatan/' . $filename, 'images/galeri/' . $filename, 'images/' . $filename];

        foreach ($possiblePaths as $tryPath) {
            if (file_exists(storage_path('app/public/' . $tryPath))) {
                return asset('storage/' . $tryPath);
            }
        }

        // Return the original path as asset (might work if storage link is correct)
        return asset('storage/' . $path);
    }

    // Get first image from array
    public function getFirstImageAttribute()
    {
        if (empty($this->gambar)) {
            return null;
        }

        return is_array($this->gambar) ? reset($this->gambar) : $this->gambar;
    }

    // Get all images as URLs
    public function getAllImageUrlsAttribute()
    {
        if (empty($this->gambar)) {
            return [];
        }

        $images = is_array($this->gambar) ? $this->gambar : [$this->gambar];
        $urls = [];

        foreach ($images as $image) {
            if (empty($image)) {
                continue;
            }

            // If URL, add directly
            if (filter_var($image, FILTER_VALIDATE_URL)) {
                $urls[] = $image;
                continue;
            }

            // Process path
            $path = is_string($image) && str_starts_with($image, 'storage/') ? substr($image, 8) : $image;

            if (file_exists(storage_path('app/public/' . $path))) {
                $urls[] = asset('storage/' . $path);
            } else {
                // Try to find file
                $filename = basename($path);
                $found = false;

                $possiblePaths = [$filename, 'galeri/' . $filename, 'galeri-kegiatan/' . $filename, 'images/galeri/' . $filename];

                foreach ($possiblePaths as $tryPath) {
                    if (file_exists(storage_path('app/public/' . $tryPath))) {
                        $urls[] = asset('storage/' . $tryPath);
                        $found = true;
                        break;
                    }
                }

                if (!$found) {
                    $urls[] = asset('storage/' . $path);
                }
            }
        }

        return $urls;
    }

    // Check if has valid image
    public function hasImage()
    {
        $image = $this->first_image;

        if (empty($image)) {
            return false;
        }

        // URL is considered valid
        if (filter_var($image, FILTER_VALIDATE_URL)) {
            return true;
        }

        // Check file existence
        $path = is_string($image) && str_starts_with($image, 'storage/') ? substr($image, 8) : $image;

        // Direct check
        if (file_exists(storage_path('app/public/' . $path))) {
            return true;
        }

        // Check common paths
        $filename = basename($path);
        $possiblePaths = [$filename, 'galeri/' . $filename, 'galeri-kegiatan/' . $filename, 'images/galeri/' . $filename];

        foreach ($possiblePaths as $tryPath) {
            if (file_exists(storage_path('app/public/' . $tryPath))) {
                return true;
            }
        }

        return false;
    }

    // Get image count
    public function getImageCountAttribute()
    {
        if (empty($this->gambar)) {
            return 0;
        }

        return is_array($this->gambar) ? count($this->gambar) : 1;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('tanggal_kegiatan', 'desc');
    }

    // Boot
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->created_by) && Auth::check()) {
                $model->created_by = Auth::id();
            }

            // Set default empty array if gambar is null
            if (is_null($model->gambar)) {
                $model->gambar = [];
            }
        });
    }

    // Mutator to handle setting gambar
    public function setGambarAttribute($value)
    {
        if (is_string($value)) {
            $this->attributes['gambar'] = json_encode([$value]);
        } elseif (is_array($value)) {
            $this->attributes['gambar'] = json_encode($value);
        } else {
            $this->attributes['gambar'] = json_encode([]);
        }
    }
}
