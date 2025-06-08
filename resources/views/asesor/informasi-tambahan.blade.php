<?php
// 2. resources/views/asesor/informasi-tambahan.blade.php
?>
@extends('layouts.asesor')

@section('title', 'Informasi Tambahan')

@section('content')
  <div class="py-12">
    <div class="max-w-7xl py-4 mx-auto sm:px-6 lg:px-8">
      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Informasi Tambahan</h1>
        <p class="mt-2 text-sm text-gray-600">Data dosen, tenaga kependidikan, mahasiswa, dan sarana prasarana</p>
      </div>

      <!-- Tabs -->
      <div class="mb-6">
        <nav class="flex space-x-4" aria-label="Tabs">
          <button onclick="showTab('dosen')" id="tab-dosen"
            class="tab-button px-3 py-2 font-medium text-sm rounded-md text-white bg-indigo-600">
            Dosen
          </button>
          <button onclick="showTab('tendik')" id="tab-tendik"
            class="tab-button px-3 py-2 font-medium text-sm rounded-md text-gray-500 hover:text-gray-700">
            Tenaga Kependidikan
          </button>
          <button onclick="showTab('mahasiswa')" id="tab-mahasiswa"
            class="tab-button px-3 py-2 font-medium text-sm rounded-md text-gray-500 hover:text-gray-700">
            Mahasiswa & Lulusan
          </button>
          <button onclick="showTab('sarpras')" id="tab-sarpras"
            class="tab-button px-3 py-2 font-medium text-sm rounded-md text-gray-500 hover:text-gray-700">
            Sarana & Prasarana
          </button>
        </nav>
      </div>

      <!-- Tab Contents -->
      <!-- Dosen Tab -->
      <div id="content-dosen" class="tab-content">
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
          <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Daftar Dosen</h2>
          </div>
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NUPTK</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIDN</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Program Studi
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jabatan
                    Akademik</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pendidikan
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                @forelse($dosen as $d)
                  <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $d->nuptk }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $d->nidn ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $d->nama }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $d->programStudi->nama }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $d->jabatan_akademik ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $d->pendidikan_terakhir ?? '-' }}
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                      Belum ada data dosen
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Tenaga Kependidikan Tab -->
      <div id="content-tendik" class="tab-content hidden">
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
          <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Daftar Tenaga Kependidikan</h2>
          </div>
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIP</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Program Studi
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jabatan</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Kerja
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pendidikan
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                @forelse($tendik as $t)
                  <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $t->nuptk }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $t->nama }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $t->programStudi->nama }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $t->jabatan }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $t->unit_kerja ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $t->pendidikan_terakhir ?? '-' }}
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                      Belum ada data tenaga kependidikan
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Mahasiswa & Lulusan Tab -->
      <div id="content-mahasiswa" class="tab-content hidden">
        <div class="bg-white shadow-sm rounded-lg p-6">
          <h2 class="text-lg font-medium text-gray-900 mb-4">Data Mahasiswa dan Lulusan</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($prodi as $p)
              <div class="border rounded-lg p-4">
                <h3 class="font-medium text-gray-900 mb-2">{{ $p->nama }}</h3>
                <div class="space-y-2 text-sm">
                  <div class="flex justify-between">
                    <span class="text-gray-600">Mahasiswa Aktif:</span>
                    <span class="font-medium">-</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-gray-600">Lulusan (3 tahun terakhir):</span>
                    <span class="font-medium">-</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-gray-600">Mahasiswa Baru:</span>
                    <span class="font-medium">-</span>
                  </div>
                </div>
                <p class="text-xs text-gray-500 mt-3">*Data akan diisi oleh program studi</p>
              </div>
            @endforeach
          </div>
        </div>
      </div>

      <!-- Sarana & Prasarana Tab -->
      <div id="content-sarpras" class="tab-content hidden">
        <div class="bg-white shadow-sm rounded-lg p-6">
          <h2 class="text-lg font-medium text-gray-900 mb-4">Sarana dan Prasarana</h2>
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div>
              <h3 class="font-medium text-gray-900 mb-3">Ruang Kuliah</h3>
              <div class="space-y-2">
                <div class="bg-gray-50 rounded p-3">
                  <p class="text-sm text-gray-600">Data ruang kuliah akan ditampilkan di sini</p>
                </div>
              </div>
            </div>
            <div>
              <h3 class="font-medium text-gray-900 mb-3">Laboratorium</h3>
              <div class="space-y-2">
                <div class="bg-gray-50 rounded p-3">
                  <p class="text-sm text-gray-600">Data laboratorium akan ditampilkan di sini</p>
                </div>
              </div>
            </div>
            <div>
              <h3 class="font-medium text-gray-900 mb-3">Perpustakaan</h3>
              <div class="space-y-2">
                <div class="bg-gray-50 rounded p-3">
                  <p class="text-sm text-gray-600">Data perpustakaan akan ditampilkan di sini</p>
                </div>
              </div>
            </div>
            <div>
              <h3 class="font-medium text-gray-900 mb-3">Fasilitas Lainnya</h3>
              <div class="space-y-2">
                <div class="bg-gray-50 rounded p-3">
                  <p class="text-sm text-gray-600">Data fasilitas lainnya akan ditampilkan di sini</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @push('scripts')
    <script>
      function showTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(content => {
          content.classList.add('hidden');
        });

        // Remove active class from all buttons
        document.querySelectorAll('.tab-button').forEach(button => {
          button.classList.remove('bg-indigo-600', 'text-white');
          button.classList.add('text-gray-500', 'hover:text-gray-700');
        });

        // Show selected tab content
        document.getElementById('content-' + tabName).classList.remove('hidden');

        // Add active class to selected button
        const activeButton = document.getElementById('tab-' + tabName);
        activeButton.classList.remove('text-gray-500', 'hover:text-gray-700');
        activeButton.classList.add('bg-indigo-600', 'text-white');
      }
    </script>
  @endpush
@endsection
