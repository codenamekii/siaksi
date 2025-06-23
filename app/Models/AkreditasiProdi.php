<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkreditasiProdi extends Model
{
    use HasFactory;

    protected $table = 'akreditasi_prodi';

    protected $fillable = ['program_studi_id', 'lembaga_akreditasi', 'status_akreditasi', 'tanggal_akreditasi', 'tanggal_berakhir', 'nomor_sk', 'sertifikat', 'is_active'];
    protected $casts = [
        'tanggal_akreditasi' => 'date',
        'tanggal_berakhir' => 'date',
        'is_active' => 'boolean',
    ];

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }
}
