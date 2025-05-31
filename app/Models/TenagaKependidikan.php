<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenagaKependidikan extends Model
{
    use HasFactory;

    protected $table = 'tenaga_kependidikan';

    protected $fillable = ['program_studi_id', 'nuptk', 'nama', 'jabatan', 'unit_kerja', 'pendidikan_terakhir', 'email', 'telepon', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }
}
