<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TenagaKependidikan extends Model
{
    use HasFactory;

    protected $table = 'tenaga_kependidikan';

    // PERSIS sesuai output dari check:table
    protected $fillable = ['nuptk', 'nama', 'jabatan', 'unit_kerja', 'pendidikan_terakhir', 'status_kepegawaian', 'email', 'program_studi_id', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relations
    public function programStudi(): BelongsTo
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeTetap($query)
    {
        return $query->where('status_kepegawaian', 'Tetap');
    }

    public function scopeKontrak($query)
    {
        return $query->where('status_kepegawaian', 'Kontrak');
    }
}
