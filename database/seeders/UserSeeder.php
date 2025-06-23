<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            // GJM Users (Super Admin)
            [
                'email' => 'gjm@fakultas.ac.id',
                'name' => 'Dr. Ahmad Fauzi, M.Pd',
                'role' => 'gjm',
                'nuptk' => '197001011995031001',
                'phone' => '081234567890',
            ],
            [
                'email' => 'admin.gjm@fakultas.ac.id',
                'name' => 'Dr. Siti Aminah, M.Sc',
                'role' => 'gjm',
                'nuptk' => '197505151999032001',
                'phone' => '081234567891',
            ],

            // UJM Users (Admin)
            [
                'email' => 'ujm.tf@fakultas.ac.id',
                'name' => 'Dr. Budi Santoso, M.T',
                'role' => 'ujm',
                'nuptk' => '198001012005011001',
                'phone' => '081234567892',
            ],
            [
                'email' => 'ujm.ti@fakultas.ac.id',
                'name' => 'Dr. Dewi Anggraini, M.Si',
                'role' => 'ujm',
                'nuptk' => '198505052010012001',
                'phone' => '081234567893',
            ],
            [
                'email' => 'ujm.tm@fakultas.ac.id',
                'name' => 'Dr. Eko Prasetyo, M.Kom',
                'role' => 'ujm',
                'nuptk' => '198210102008011001',
                'phone' => '081234567894',
            ],
            [
                'email' => 'ujm.te@fakultas.ac.id',
                'name' => 'Ir. Bambang Sutejo, M.T',
                'role' => 'ujm',
                'nuptk' => '197905202005011003',
                'phone' => '081234567895',
            ],
            [
                'email' => 'ujm.ts@fakultas.ac.id',
                'name' => 'Ir. Sri Handayani, M.T',
                'role' => 'ujm',
                'nuptk' => '198004152006041005',
                'phone' => '081234567896',
            ],

            // Asesor Users
            [
                'email' => 'asesor1@universitas.ac.id',
                'name' => 'Prof. Dr. Hadi Susanto, M.Sc',
                'role' => 'asesor',
                'nuptk' => '196505051990031001',
                'phone' => '081234567895',
            ],
            [
                'email' => 'asesor2@universitas.ac.id',
                'name' => 'Prof. Dr. Ratna Wulandari, M.M',
                'role' => 'asesor',
                'nuptk' => '197008081995032001',
                'phone' => '081234567896',
            ],
            [
                'email' => 'asesor3@universitas.ac.id',
                'name' => 'Dr. Ir. Agus Priyanto, M.T',
                'role' => 'asesor',
                'nuptk' => '197203031997031001',
                'phone' => '081234567897',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => Hash::make('password123'),
                    'role' => $user['role'],
                    'nuptk' => $user['nuptk'],
                    'phone' => $user['phone'],
                    'is_active' => true,
                ],
            );
        }
    }
}
