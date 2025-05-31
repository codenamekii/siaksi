<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
  public function run(): void
  {
    // GJM Users (Super Admin)
    User::create([
      'name' => 'Dr. Ahmad Fauzi, M.Pd',
      'email' => 'gjm@fakultas.ac.id',
      'password' => Hash::make('password123'),
      'role' => 'gjm',
      'nuptk' => '197001011995031001',
      'phone' => '081234567890',
      'is_active' => true
    ]);

    User::create([
      'name' => 'Dr. Siti Aminah, M.Sc',
      'email' => 'admin.gjm@fakultas.ac.id',
      'password' => Hash::make('password123'),
      'role' => 'gjm',
      'nuptk' => '197505151999032001',
      'phone' => '081234567891',
      'is_active' => true
    ]);

    // UJM Users (Admin)
    User::create([
      'name' => 'Dr. Budi Santoso, M.T',
      'email' => 'ujm.tf@fakultas.ac.id',
      'password' => Hash::make('password123'),
      'role' => 'ujm',
      'nuptk' => '198001012005011001',
      'phone' => '081234567892',
      'is_active' => true
    ]);

    User::create([
      'name' => 'Dr. Dewi Anggraini, M.Si',
      'email' => 'ujm.ti@fakultas.ac.id',
      'password' => Hash::make('password123'),
      'role' => 'ujm',
      'nuptk' => '198505052010012001',
      'phone' => '081234567893',
      'is_active' => true
    ]);

    User::create([
      'name' => 'Dr. Eko Prasetyo, M.Kom',
      'email' => 'ujm.tm@fakultas.ac.id',
      'password' => Hash::make('password123'),
      'role' => 'ujm',
      'nuptk' => '198210102008011001',
      'phone' => '081234567894',
      'is_active' => true
    ]);

    User::create([
      'name' => 'Ir. Bambang Sutejo, M.T',
      'email' => 'ujm.te@fakultas.ac.id',
      'password' => Hash::make('password123'),
      'role' => 'ujm',
      'nuptk' => '197905202005011003',
      'phone' => '081234567895',
      'is_active' => true
    ]);

    User::create([
      'name' => 'Ir. Sri Handayani, M.T',
      'email' => 'ujm.ts@fakultas.ac.id',
      'password' => Hash::make('password123'),
      'role' => 'ujm',
      'nuptk' => '198004152006041005',
      'phone' => '081234567896',
      'is_active' => true
    ]);

    // Asesor Users
    User::create([
      'name' => 'Prof. Dr. Hadi Susanto, M.Sc',
      'email' => 'asesor1@universitas.ac.id',
      'password' => Hash::make('password123'),
      'role' => 'asesor',
      'nuptk' => '196505051990031001',
      'phone' => '081234567895',
      'is_active' => true
    ]);

    User::create([
      'name' => 'Prof. Dr. Ratna Wulandari, M.M',
      'email' => 'asesor2@universitas.ac.id',
      'password' => Hash::make('password123'),
      'role' => 'asesor',
      'nuptk' => '197008081995032001',
      'phone' => '081234567896',
      'is_active' => true
    ]);

    User::create([
      'name' => 'Dr. Ir. Agus Priyanto, M.T',
      'email' => 'asesor3@universitas.ac.id',
      'password' => Hash::make('password123'),
      'role' => 'asesor',
      'nuptk' => '197203031997031001',
      'phone' => '081234567897',
      'is_active' => true
    ]);
  }
}
