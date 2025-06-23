<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosen';

    protected $fillable = [
        'program_studi_id',
        'nuptk', // Akan digunakan untuk NUPTK
        'nidn',
        'nama',
        'jabatan_akademik',
        'pendidikan_terakhir',
        'bidang_keahlian', // Field baru
        'email',
        'telepon',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    // Accessor untuk gelar
    public function getGelarAttribute()
    {
        $gelar = '';
        if ($this->jabatan_akademik === 'Profesor') {
            $gelar = 'Prof. ';
        }

        if ($this->pendidikan_terakhir === 'S3') {
            $gelar .= 'Dr. ';
        }

        return $gelar;
    }

    // Accessor untuk nama lengkap dengan gelar
    public function getNamaLengkapAttribute()
    {
        return $this->gelar . $this->nama;
    }

    // Scopes
    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeDoktor($query)
    {
        return $query->where('pendidikan_terakhir', 'S3');
    }

    public function scopeProfesor($query)
    {
        return $query->where('jabatan_akademik', 'Profesor');
    }
}
