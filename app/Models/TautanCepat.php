<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TautanCepat extends Model
{
    use HasFactory;

    protected $table = 'tautan_cepat';

    protected $fillable = ['nama', 'url', 'icon', 'level', 'fakultas_id', 'program_studi_id', 'urutan', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class);
    }

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }
}
