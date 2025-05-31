<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;

    protected $table = 'dokumen';

    protected $fillable = ['user_id', 'nama', 'deskripsi', 'tipe', 'path', 'url', 'kriteria', 'sub_kriteria', 'catatan', 'kategori', 'level', 'fakultas_id', 'program_studi_id', 'is_visible_to_asesor', 'is_active'];

    protected $casts = [
        'is_visible_to_asesor' => 'boolean',
        'is_active' => 'boolean',
    ];

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

    public function scopeVisibleToAsesor($query)
    {
        return $query->where('is_visible_to_asesor', true)->where('is_active', true);
    }
}
