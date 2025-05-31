<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    use HasFactory;

    protected $table = 'fakultas';

    protected $fillable = ['kode', 'nama', 'visi', 'misi', 'tujuan', 'dekan', 'alamat', 'telepon', 'email', 'website'];

    public function programStudi()
    {
        return $this->hasMany(ProgramStudi::class);
    }

    public function timGJM()
    {
        return $this->hasMany(TimGJM::class);
    }

    public function dokumen()
    {
        return $this->hasMany(Dokumen::class);
    }

    public function jadwalAMI()
    {
        return $this->hasMany(JadwalAMI::class);
    }

    public function tautanCepat()
    {
        return $this->hasMany(TautanCepat::class);
    }

    public function strukturOrganisasi()
    {
        return $this->hasOne(StrukturOrganisasi::class);
    }
}
