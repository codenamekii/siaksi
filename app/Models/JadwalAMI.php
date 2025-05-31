<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalAMI extends Model
{
    use HasFactory;

    protected $table = 'jadwal_ami';

    protected $fillable = ['fakultas_id', 'program_studi_id', 'nama_kegiatan', 'deskripsi', 'tanggal_mulai', 'tanggal_selesai', 'tempat', 'status'];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
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
