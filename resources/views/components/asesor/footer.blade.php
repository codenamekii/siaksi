{{-- resources/views/components/asesor/footer.blade.php --}}
<footer class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white mt-auto">
  {{-- Wave Pattern --}}
  <div class="relative">
      <svg class="absolute top-0 w-full h-6 -mt-5 sm:-mt-10 sm:h-10 text-gray-900" preserveAspectRatio="none" viewBox="0 0 1440 54">
          <path fill="currentColor" d="M0 22L120 16.7C240 11 480 1.00001 720 0.700012C960 1.00001 1200 11 1320 16.7L1440 22V54H1320C1200 54 960 54 720 54C480 54 240 54 120 54H0V22Z"></path>
      </svg>
  </div>

  <div class="relative px-4 pt-12 pb-6 mx-auto sm:px-6 lg:px-8 max-w-7xl">
      {{-- Main Footer Content --}}
      <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-4">
          {{-- About Section --}}
          <div class="space-y-4">
              <div class="flex items-center space-x-3">
                  <div class="relative">
                      <div class="absolute -inset-1 bg-gradient-to-r from-blue-400 to-indigo-400 rounded-lg blur opacity-75"></div>
                      <div class="relative bg-gray-800 rounded-lg p-2">
                          <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                          </svg>
                      </div>
                  </div>
                  <h3 class="text-xl font-bold">SIAKSI</h3>
              </div>
              <p class="text-gray-400 text-sm leading-relaxed">
                  Sistem Informasi Akreditasi untuk mendukung proses penjaminan mutu internal dan eksternal di lingkungan Fakultas.
              </p>
              {{-- Social Links --}}
              <div class="flex space-x-3">
                  <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">
                      <span class="sr-only">Facebook</span>
                      <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                      </svg>
                  </a>
                  <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">
                      <span class="sr-only">Instagram</span>
                      <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"/>
                      </svg>
                  </a>
                  <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">
                      <span class="sr-only">Twitter</span>
                      <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                      </svg>
                  </a>
              </div>
          </div>

          {{-- Quick Links --}}
          <div>
              <h3 class="text-lg font-semibold mb-4 text-white">Akses Cepat</h3>
              <ul class="space-y-2">
                  <li>
                      <a href="{{ route('asesor.dashboard') }}" class="text-gray-400 hover:text-white transition-colors duration-200 flex items-center group">
                          <svg class="w-4 h-4 mr-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                          </svg>
                          Dashboard
                      </a>
                  </li>
                  <li>
                      <a href="{{ route('asesor.dokumen-institusi') }}" class="text-gray-400 hover:text-white transition-colors duration-200 flex items-center group">
                          <svg class="w-4 h-4 mr-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                          </svg>
                          Dokumen Institusi
                      </a>
                  </li>
                  <li>
                      <a href="{{ route('asesor.dokumen-fakultas') }}" class="text-gray-400 hover:text-white transition-colors duration-200 flex items-center group">
                          <svg class="w-4 h-4 mr-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                          </svg>
                          Dokumen Fakultas
                      </a>
                  </li>
                  <li>
                      <a href="{{ route('asesor.dokumen-prodi') }}" class="text-gray-400 hover:text-white transition-colors duration-200 flex items-center group">
                          <svg class="w-4 h-4 mr-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                          </svg>
                          Dokumen Program Studi
                      </a>
                  </li>
              </ul>
          </div>

          {{-- Contact Info --}}
          <div>
              <h3 class="text-lg font-semibold mb-4 text-white">Kontak</h3>
              <ul class="space-y-3">
                  <li class="flex items-start">
                      <svg class="w-5 h-5 text-blue-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                      </svg>
                      <span class="text-gray-400 text-sm">
                          Fakultas Teknologi Informasi<br>
                          Jl. Pendidikan No. 123<br>
                          Kota Universitas, 12345
                      </span>
                  </li>
                  <li class="flex items-center">
                      <svg class="w-5 h-5 text-blue-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                      </svg>
                      <span class="text-gray-400 text-sm">(021) 1234-5678</span>
                  </li>
                  <li class="flex items-center">
                      <svg class="w-5 h-5 text-blue-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                      </svg>
                      <span class="text-gray-400 text-sm">info@siaksi.ac.id</span>
                  </li>
              </ul>
          </div>

          {{-- Additional Info --}}
          <div>
              <h3 class="text-lg font-semibold mb-4 text-white">Informasi Tambahan</h3>
              <ul class="space-y-2">
                  <li>
                      <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200 flex items-center group">
                          <svg class="w-4 h-4 mr-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                          </svg>
                          Panduan Pengguna
                      </a>
                  </li>
                  <li>
                      <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200 flex items-center group">
                          <svg class="w-4 h-4 mr-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                          </svg>
                          FAQ
                      </a>
                  </li>
                  <li>
                      <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200 flex items-center group">
                          <svg class="w-4 h-4 mr-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                          </svg>
                          Kebijakan Privasi
                      </a>
                  </li>
                  <li>
                      <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200 flex items-center group">
                          <svg class="w-4 h-4 mr-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                          </svg>
                          Syarat & Ketentuan
                      </a>
                  </li>
              </ul>
          </div>
      </div>

      {{-- Divider --}}
      <div class="mt-8 pt-8 border-t border-gray-700">
          <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
              {{-- Copyright --}}
              <div class="text-center md:text-left">
                  <p class="text-gray-400 text-sm">
                      © {{ date('Y') }} SIAKSI - Sistem Informasi Akreditasi. All rights reserved.
                  </p>
                  <p class="text-gray-500 text-xs mt-1">
                      Developed with <span class="text-red-500">❤</span> by Tim Pengembang
                  </p>
              </div>

              {{-- Version & Last Update --}}
              <div class="text-center md:text-right">
                  <div class="flex items-center space-x-4 text-xs text-gray-500">
                      <span class="flex items-center">
                          <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                          </svg>
                          Version 1.0.0
                      </span>
                      <span class="flex items-center">
                          <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                          </svg>
                          Updated: {{ now()->format('d M Y') }}
                      </span>
                  </div>
              </div>
          </div>
      </div>

      {{-- Scroll to Top Button --}}
      <button onclick="scrollToTop()" 
              id="scrollTopBtn"
              class="fixed bottom-8 right-8 bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-3 rounded-full shadow-lg hover:shadow-xl transform hover:scale-110 transition-all duration-300 opacity-0 invisible">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
          </svg>
      </button>
  </div>
</footer>

<script>
// Scroll to top functionality
window.onscroll = function() {
  const scrollBtn = document.getElementById("scrollTopBtn");
  if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
      scrollBtn.classList.remove("opacity-0", "invisible");
      scrollBtn.classList.add("opacity-100", "visible");
  } else {
      scrollBtn.classList.remove("opacity-100", "visible");
      scrollBtn.classList.add("opacity-0", "invisible");
  }
};

function scrollToTop() {
  window.scrollTo({
      top: 0,
      behavior: 'smooth'
  });
}
</script>