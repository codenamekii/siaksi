<?php

namespace Database\Seeders;

use App\Models\TenagaKependidikan;
use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;

class TenagaKependidikanSeeder extends Seeder
{
    public function run(): void
    {
        $prodiTI = ProgramStudi::where('kode', 'TI')->first();
        $prodiTF = ProgramStudi::where('kode', 'TF')->first();
        $prodiTS = ProgramStudi::where('kode', 'TS')->first();

        // Tendik Prodi TI
        TenagaKependidikan::updateOrCreate(
            ['nuptk' => '199201012018011001'],
            [
                'program_studi_id' => $prodiTI->id,
                'nama' => 'Ahmad Yusuf',
                'jabatan' => 'Staf Administrasi',
                'unit_kerja' => 'Program Studi TI',
                'pendidikan_terakhir' => 'S1 Administrasi',
                'email' => 'ahmad.yusuf@ti.fakultas.ac.id',
                'is_active' => true,
            ],
        );

        TenagaKependidikan::updateOrCreate(
            ['nuptk' => '199505052019032001'],
            [
                'program_studi_id' => $prodiTI->id,
                'nama' => 'Rina Susanti',
                'jabatan' => 'Laboran',
                'unit_kerja' => 'Laboratorium TI',
                'pendidikan_terakhir' => 'S1 Teknik Informatika',
                'email' => 'rina.susanti@ti.fakultas.ac.id',
                'is_active' => true,
            ],
        );

        // Tendik Prodi SI
        TenagaKependidikan::updateOrCreate(
            ['nuptk' => '199303032018031001'],
            [
                'program_studi_id' => $prodiTS->id,
                'nama' => 'Budi Hartono',
                'jabatan' => 'Staf Administrasi',
                'unit_kerja' => 'Program Studi SI',
                'pendidikan_terakhir' => 'S1 Manajemen',
                'email' => 'budi.hartono@si.fakultas.ac.id',
                'is_active' => true,
            ],
        );

        // Tendik Prodi IF
        TenagaKependidikan::updateOrCreate(
            ['nuptk' => '199404042019011001'],
            [
                'program_studi_id' => $prodiTF->id,
                'nama' => 'Deni Firmansyah',
                'jabatan' => 'Teknisi Laboratorium',
                'unit_kerja' => 'Laboratorium IF',
                'pendidikan_terakhir' => 'D3 Teknik Komputer',
                'email' => 'deni.firmansyah@if.fakultas.ac.id',
                'is_active' => true,
            ],
        );
    }
}
