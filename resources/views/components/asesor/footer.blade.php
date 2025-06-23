{{-- Lokasi file: resources/views/components/asesor/footer.blade.php --}}

<footer class="bg-gray-900">
  <!-- Main Footer -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
      <!-- About Section -->
      <div class="space-y-4">
        <div class="flex items-center space-x-3">
          <div class="relative">
            <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg blur opacity-75"></div>
            <div class="relative bg-gray-900 rounded-lg p-2">
              <img src="{{ asset('storage/logoteknik.png') }}" alt="Logo" class="h-12 w-auto">
            </div>
          </div>
          <div>
            <h3 class="text-xl font-bold text-white">SIAKSI</h3>
            <p class="text-xs text-gray-400">Sistem Informasi Akreditasi</p>
          </div>
        </div>
        <p class="text-gray-400 text-sm leading-relaxed text-justify">
          Platform terpadu untuk mengelola dan mengakses dokumen akreditasi institusi pendidikan tinggi.
          Mendukung transparansi dan peningkatan mutu pendidikan.
        </p>
        <!-- Social Media -->
        <div class="flex space-x-4">
          <a href="#"
            class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-blue-600 transition-colors">
            <svg class="w-5 h-5 fill-blue-200" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path
                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
            </svg>
          </a>
          <a href="#"
            class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-blue-400 transition-colors">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
              <path
                d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
            </svg>
          </a>
          <a href="#"
            class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-purple-600 transition-colors">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
              <path
                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1112.324 0 6.162 6.162 0 01-12.324 0zM12 16a4 4 0 110-8 4 4 0 010 8zm4.965-10.405a1.44 1.44 0 112.881.001 1.44 1.44 0 01-2.881-.001z" />
            </svg>
          </a>
          <a href="/"
            class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-blue-600 transition-colors">
            <svg class="w-6 h-6 text-blue-200" viewBox="0 0 32 32" fill="currentColor"
              xmlns="http://www.w3.org/2000/svg">
              <path
                d="M16 0C7.178 0 0 7.178 0 16s7.178 16 16 16 16-7.178 16-16S24.822 0 16 0zm14.313 15H26.02a12.952 12.952 0 00-2.792-9.051A14.012 14.012 0 0130.313 15zM16 30C9.383 30 4 24.617 4 18c0-3.23 1.195-6.178 3.146-8.458A13.027 13.027 0 0016 18v12zM16 2c2.396 0 4.648.693 6.531 1.875A14.976 14.976 0 0021.822 15h-5.822V2zM2.324 17H6.2a14.98 14.98 0 003.688 10.719A13.939 13.939 0 012.324 17zm13.676 13V18h5.52a13.008 13.008 0 01-5.52 12z" />
            </svg>
          </a>
        </div>
      </div>

      <!-- Quick Links -->
      <div>
        <h4 class="text-lg font-semibold text-white mb-4">Akses Cepat</h4>
        <ul class="space-y-2">
          <li>
            <a href="{{ route('asesor.dashboard') }}"
              class="text-gray-400 hover:text-white transition-colors flex items-center group">
              <svg class="w-4 h-4 mr-2 text-gray-600 group-hover:text-blue-400 transition-colors" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
              Beranda
            </a>
          </li>
          <li>
            <a href="{{ route('asesor.dokumen-institusi') }}"
              class="text-gray-400 hover:text-white transition-colors flex items-center group">
              <svg class="w-4 h-4 mr-2 text-gray-600 group-hover:text-blue-400 transition-colors" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
              Dokumen Institusi
            </a>
          </li>
          <li>
            <a href="{{ route('asesor.dokumen-fakultas') }}"
              class="text-gray-400 hover:text-white transition-colors flex items-center group">
              <svg class="w-4 h-4 mr-2 text-gray-600 group-hover:text-blue-400 transition-colors" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
              Dokumen Fakultas
            </a>
          </li>
          <li>
            <a href="{{ route('asesor.dokumen-prodi') }}"
              class="text-gray-400 hover:text-white transition-colors flex items-center group">
              <svg class="w-4 h-4 mr-2 text-gray-600 group-hover:text-blue-400 transition-colors" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
              Dokumen Program Studi
            </a>
          </li>
          <li>
            <a href="{{ route('asesor.informasi-tambahan') }}"
              class="text-gray-400 hover:text-white transition-colors flex items-center group">
              <svg class="w-4 h-4 mr-2 text-gray-600 group-hover:text-blue-400 transition-colors" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
              Informasi Tambahan
            </a>
          </li>
        </ul>
      </div>

      <!-- Contact Info -->
      <div>
        <h4 class="text-lg text-white font-semibold mb-4">Kontak</h4>
        <ul class="space-y-3">
          <li class="flex items-start">
            <svg class="w-5 h-5 mr-3 text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
              viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <span class="text-gray-400 text-sm">
              Jl. Perintis Kemerdekaan No.KM.9, RW.No.29, Tamalanrea Indah<br>
              Kec. Tamalanrea, Kota Makassar, Sulawesi Selatan
            </span>
          </li>
          <li class="flex items-center">
            <svg class="w-5 h-5 mr-3 text-blue-400 flex-shrink-0" fill="none" stroke="currentColor"
              viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
              </path>
            </svg>
            <span class="text-gray-400 text-sm">+6282296444165</span>
          </li>
          <li class="flex items-center">
            <svg class="w-5 h-5 mr-3 text-blue-400 flex-shrink-0" fill="none" stroke="currentColor"
              viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
              </path>
            </svg>
            <span class="text-gray-400 text-sm">teknikuim09@gmail.com</span>
          </li>
        </ul>
      </div>

      <!-- Support -->
      <div>
        <h4 class="text-lg text-white font-semibold mb-4">Bantuan</h4>
        <ul class="space-y-2">
          <li>
            <a href="#" class="text-gray-400 hover:text-white transition-colors flex items-center group">
              <svg class="w-4 h-4 mr-2 text-gray-600 group-hover:text-purple-400 transition-colors" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
              Panduan Penggunaan
            </a>
          </li>
          <li>
            <a href="#" class="text-gray-400 hover:text-white transition-colors flex items-center group">
              <svg class="w-4 h-4 mr-2 text-gray-600 group-hover:text-purple-400 transition-colors" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
              FAQ
            </a>
          </li>
          <li>
            <a href="#" class="text-gray-400 hover:text-white transition-colors flex items-center group">
              <svg class="w-4 h-4 mr-2 text-gray-600 group-hover:text-purple-400 transition-colors" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
              Kebijakan Privasi
            </a>
          </li>
          <li>
            <a href="#" class="text-gray-400 hover:text-white transition-colors flex items-center group">
              <svg class="w-4 h-4 mr-2 text-gray-600 group-hover:text-purple-400 transition-colors" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
              Syarat & Ketentuan
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Bottom Bar -->
  <div class="border-t border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2">
      <div class="flex flex-col md:flex-row justify-between">
        <p class="text-gray-400 text-sm leading-tight">
          © {{ date('Y') }} SIAKSI. All rights reserved. Developed with
          <svg class="w-4 h-4 inline text-red-500 align-text-bottom" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
              d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
              clip-rule="evenodd" />
          </svg>
          by <a href="https://kiifiki.netlify.app/"
            class="text-gray-400 hover:text-white transition-colors">Taufiqurrahman</a>
        </p>
      </div>
    </div>
  </div>
</footer>
