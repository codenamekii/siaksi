<!-- Program Studi Section -->
<section id="program-studi" class="py-20 bg-gray-50">
  <div class="max-w-7xl mx-auto px-4 mt-3 mb-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16">
      <h2 class="text-4xl font-bold text-gray-900 mb-4">Program Studi</h2>
      <p class="text-xl text-gray-600 max-w-2xl mx-auto">
        Visi, misi program studi dan dokumen terkait yang mendukung proses asesmen.
      </p>
    </div>

    @php
      $programStudis = \App\Models\ProgramStudi::with(['fakultas', 'akreditasiAktif'])
          ->where('is_active', true)
          ->orderBy('fakultas_id')
          ->orderBy('nama')
          ->get()
          ->groupBy('fakultas.nama');
    @endphp

    <div class="space-y-12">
      @foreach ($programStudis as $fakultasNama => $prodis)
        <div>
          <h3 class="text-4xl font-bold text-gray-900 mb-6 flex items-center">
            <div class="w-12 h-1 bg-gradient-to-r from-blue-600 to-purple-600 mr-4"></div>
            {{ $fakultasNama }}
          </h3>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($prodis as $prodi)
              <div
                class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group">
                <div class="p-6">
                  <div class="flex items-start justify-between mb-4">
                    <div>
                      <h4 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">
                        {{ $prodi->nama }}
                      </h4>
                      <p class="text-sm text-gray-500">{{ $prodi->jenjang }}</p>
                    </div>
                    @if ($prodi->akreditasiAktif)
                      <span
                        class="px-3 py-1 bg-gradient-to-r from-green-400 to-green-600 text-white text-xs font-semibold rounded-full">
                        {{ $prodi->akreditasiAktif->status_akreditasi }}
                      </span>
                    @endif
                  </div>

                  <div class="space-y-3">
                    <div>
                      <h5 class="text-sm font-semibold text-gray-700 mb-1 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor"
                          viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                          </path>
                        </svg>
                        Visi
                      </h5>
                      <p class="text-sm text-gray-600 line-clamp-2">
                        {{ $prodi->visi ?? 'Menjadi program studi unggulan yang menghasilkan lulusan berkualitas dan berdaya saing global.' }}
                      </p>
                    </div>

                    <div>
                      <h5 class="text-sm font-semibold text-gray-700 mb-1 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor"
                          viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Misi
                      </h5>
                      <p class="text-sm text-gray-600 line-clamp-2">
                        {{ $prodi->misi ?? 'Menyelenggarakan pendidikan berkualitas dengan kurikulum yang relevan dengan kebutuhan industri.' }}
                      </p>
                    </div>
                  </div>

                  <div class="mt-4 pt-4 border-t border-gray-200">
                    <a href="{{ route('asesor.dokumen-prodi') }}#prodi-{{ $prodi->id }}"
                      class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center group">
                      Lihat Dokumen Program Studi
                      <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                      </svg>
                    </a>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
