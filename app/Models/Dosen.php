<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosen';

    protected $fillable = ['program_studi_id', 'nuptk', 'nidn', 'nama', 'jabatan_akademik', 'pendidikan_terakhir', 'email', 'telepon', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }
}
