<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GaleriKegiatan extends Model
{
    use HasFactory;

    protected $table = 'galeri_kegiatan';

    protected $fillable = ['program_studi_id', 'judul', 'deskripsi', 'tipe', 'file_path', 'video_url', 'tanggal_kegiatan', 'is_active'];

    protected $casts = [
        'tanggal_kegiatan' => 'date',
        'is_active' => 'boolean',
    ];

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }
}
