<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimUJM extends Model
{
    use HasFactory;

    protected $table = 'tim_ujm';

    protected $fillable = ['program_studi_id', 'nama', 'jabatan', 'nuptk', 'email', 'telepon', 'foto', 'urutan', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }
}
