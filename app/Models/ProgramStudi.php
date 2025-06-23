<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    use HasFactory;

    protected $table = 'program_studi';

    protected $fillable = ['fakultas_id', 'ujm_id', 'kode', 'nama', 'jenjang', 'visi', 'misi', 'tujuan', 'kaprodi', 'email', 'telepon', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class);
    }

    public function ujm()
    {
        return $this->belongsTo(User::class, 'ujm_id');
    }

    public function akreditasi()
    {
        return $this->hasMany(AkreditasiProdi::class);
    }

    public function akreditasiAktif()
    {
        return $this->hasOne(AkreditasiProdi::class)->where('is_active', true)->where('tanggal_berakhir', '>', now())->latest('tanggal_akreditasi');
    }

    public function akreditasiTerakhir()
    {
      return $this->hasOne(AkreditasiProdi::class)
        ->latest('tanggal_akreditasi');
    }

    public function berita()
    {
        return $this->hasMany(Berita::class);
    }

    public function dokumen()
    {
        return $this->hasMany(Dokumen::class);
    }

    public function jadwalAMI()
    {
        return $this->hasMany(JadwalAMI::class);
    }

    public function timUJM()
    {
        return $this->hasMany(TimUJM::class);
    }

    public function tautanCepat()
    {
        return $this->hasMany(TautanCepat::class);
    }

    public function strukturOrganisasi()
    {
        return $this->hasOne(StrukturOrganisasi::class);
    }

    public function galeriKegiatan()
    {
        return $this->hasMany(GaleriKegiatan::class);
    }

    public function dosen()
    {
        return $this->hasMany(Dosen::class);
    }

    public function tenagaKependidikan()
    {
        return $this->hasMany(TenagaKependidikan::class);
    }
}
