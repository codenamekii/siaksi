<?php

namespace Database\Seeders;

use App\Models\TimUJM;
use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;

class TimUJMSeeder extends Seeder
{
    public function run(): void
    {
        $prodiTI = ProgramStudi::where('kode', 'TI')->first();
        $prodiTF = ProgramStudi::where('kode', 'TF')->first();
        $prodiTM = ProgramStudi::where('kode', 'TM')->first();
        $prodiTE = ProgramStudi::where('kode', 'TE')->first();
        $prodiTS = ProgramStudi::where('kode', 'TS')->first();

        // Tim UJM Prodi TI - Update NUPTK to avoid conflicts
        $timUJMTI = [
            [
                'nama' => 'Dr. Budi Santoso, M.T',
                'jabatan' => 'Ketua UJM',
                'nuptk' => '198001012005011002', // Changed to avoid conflict
                'email' => 'budi.santoso.ujm@ti.fakultas.ac.id',
                'urutan' => 1,
            ],
            [
                'nama' => 'Rina Wulandari, M.Kom',
                'jabatan' => 'Sekretaris UJM',
                'nuptk' => '198505052010012002', // New NUPTK
                'email' => 'rina.wulandari@ti.fakultas.ac.id',
                'urutan' => 2,
            ],
            [
                'nama' => 'Agus Prasetyo, M.T',
                'jabatan' => 'Anggota',
                'nuptk' => '198210102008011002', // New NUPTK
                'email' => 'agus.prasetyo@ti.fakultas.ac.id',
                'urutan' => 3,
            ],
        ];

        foreach ($timUJMTI as $anggota) {
            TimUJM::updateOrCreate(
                ['nuptk' => $anggota['nuptk']],
                array_merge($anggota, [
                    'program_studi_id' => $prodiTI->id,
                    'is_active' => true,
                ]),
            );
        }

        // Tim UJM Prodi TF - Update NUPTK to avoid conflicts
        $timUJMTF = [
            [
                'nama' => 'Dr. Dewi Anggraini, M.Si',
                'jabatan' => 'Ketua UJM',
                'nuptk' => '198505052010012003', // Changed to avoid conflict
                'email' => 'dewi.anggraini.ujm@tf.fakultas.ac.id',
                'urutan' => 1,
            ],
            [
                'nama' => 'Fahri Rahman, M.M',
                'jabatan' => 'Sekretaris UJM',
                'nuptk' => '198808082015031002', // Changed to avoid conflict
                'email' => 'fahri.rahman.ujm@tf.fakultas.ac.id',
                'urutan' => 2,
            ],
        ];

        foreach ($timUJMTF as $anggota) {
            TimUJM::updateOrCreate(
                ['nuptk' => $anggota['nuptk']],
                array_merge($anggota, [
                    'program_studi_id' => $prodiTF->id,
                    'is_active' => true,
                ]),
            );
        }

        // Tim UJM Prodi TM - Update NUPTK to avoid conflicts
        $timUJMTM = [
            [
                'nama' => 'Dr. Eko Prasetyo, M.Kom',
                'jabatan' => 'Ketua UJM',
                'nuptk' => '198210102008011003', // Changed to avoid conflict
                'email' => 'eko.prasetyo.ujm@tm.fakultas.ac.id',
                'urutan' => 1,
            ],
            [
                'nama' => 'Sari Indah, M.T',
                'jabatan' => 'Sekretaris UJM',
                'nuptk' => '199001012015032002', // Changed to avoid conflict
                'email' => 'sari.indah.ujm@tm.fakultas.ac.id',
                'urutan' => 2,
            ],
        ];

        foreach ($timUJMTM as $anggota) {
            TimUJM::updateOrCreate(
                ['nuptk' => $anggota['nuptk']],
                array_merge($anggota, [
                    'program_studi_id' => $prodiTM->id,
                    'is_active' => true,
                ]),
            );
        }

        // Add Tim UJM for other prodi if needed
        if ($prodiTE) {
            TimUJM::updateOrCreate(
                ['nuptk' => '198303032009011001'],
                [
                    'nama' => 'Ir. Ahmad Rizki, M.T',
                    'jabatan' => 'Ketua UJM',
                    'email' => 'ahmad.rizki@te.fakultas.ac.id',
                    'program_studi_id' => $prodiTE->id,
                    'urutan' => 1,
                    'is_active' => true,
                ],
            );
        }

        if ($prodiTS) {
            TimUJM::updateOrCreate(
                ['nuptk' => '198404042010011001'],
                [
                    'nama' => 'Dr. Hendra Kusuma, M.T',
                    'jabatan' => 'Ketua UJM',
                    'email' => 'hendra.kusuma@ts.fakultas.ac.id',
                    'program_studi_id' => $prodiTS->id,
                    'urutan' => 1,
                    'is_active' => true,
                ],
            );
        }
    }
}
