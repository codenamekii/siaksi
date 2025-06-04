@if (session('gjm_original_user') || session('ujm_original_user'))
  <div class="fixed bottom-8 right-8 z-50">
    <div class="bg-white rounded-lg shadow-xl p-4 border-2 border-yellow-400">
      <p class="text-sm text-gray-600 mb-2">Anda sedang login sebagai role lain</p>
      <a href="{{ route('return.to.original') }}"
        class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white font-semibold rounded-lg hover:bg-yellow-600 transition">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path>
        </svg>
        Kembali ke Dashboard Asli
      </a>
    </div>
  </div>
@endif