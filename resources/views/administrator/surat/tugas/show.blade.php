<x-app-layout>
  <x-slot name="header">
    <div class="flex flex-col gap-1">
      <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
        Detail Surat Tugas
      </h2>

      <p class="text-sm text-gray-500 dark:text-gray-400">
        Informasi lengkap surat tugas
      </p>
    </div>
  </x-slot>

  <div class="py-8 px-4">
    <div class="max-w-6xl mx-auto">

      <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden">

        {{-- Header Card --}}
        <div class="border-b border-gray-200 dark:border-gray-700 p-8">
          <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>
              <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                Surat Tugas
              </h3>

              <p class="text-gray-500 dark:text-gray-400 mt-1">
                Detail informasi surat tugas
              </p>
            </div>

            <div>
              <span
                class="inline-flex items-center px-5 py-2 rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300 text-sm font-semibold">
                {{ $surat_tuga->nomor ?? '-' }}
              </span>
            </div>

          </div>
        </div>

        {{-- Content --}}
        <div class="p-8">

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Nomor Surat --}}
            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-2xl p-5">
              <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                Nomor Surat
              </p>

              <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                {{ $surat_tuga->nomor ?? '-' }}
              </h4>
            </div>

            {{-- Perihal --}}
            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-2xl p-5">
              <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                Perihal
              </p>

              <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                {{ $surat_tuga->keperluan ?? '-' }}
              </h4>
            </div>

            {{-- Tanggal --}}
            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-2xl p-5">
              <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                Tanggal
              </p>

              <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                {{ $surat_tuga->tanggal
                                    ? \Carbon\Carbon::parse($surat_tuga->tanggal)->translatedFormat('d F Y')
                                    : '-' }}
              </h4>
            </div>

            {{-- Pemberi Tugas --}}
            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-2xl p-5">
              <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                Pemberi Tugas
              </p>

              <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                {{ $surat_tuga->pemberi_tugas ?? '-' }}
              </h4>
            </div>

            {{-- Penerima Tugas --}}
            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-2xl p-5">
              <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                Penerima Tugas
              </p>

              <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                {{ $surat_tuga->penerima_tugas ?? '-' }}
              </h4>
            </div>

            {{-- Keterangan --}}
            <div class="md:col-span-2 bg-gray-50 dark:bg-gray-700/50 rounded-2xl p-5">
              <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                Keterangan
              </p>

              <p class="text-gray-800 dark:text-gray-200 leading-relaxed">
                {{ $surat_tuga->keterangan ?? '-' }}
              </p>
            </div>

          </div>

          {{-- Action Button --}}
          <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-10 pt-6 border-t border-gray-200 dark:border-gray-700">

            {{-- Back --}}
            <a href="{{ route('surat-tugas.index') }}"
              class="w-full sm:w-auto px-6 py-3 rounded-xl bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-white font-medium transition text-center">
              ← Kembali
            </a>

            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">

              {{-- Edit --}}
              <a href="{{ route('surat-tugas.edit', $surat_tuga->id) }}"
                class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-md transition text-center">
                Edit Surat
              </a>

              {{-- Delete --}}
              <form action="{{ route('surat-tugas.destroy', $surat_tuga->id) }}"
                method="POST"
                onsubmit="return confirm('Yakin ingin menghapus surat tugas ini?')">

                @csrf
                @method('DELETE')

                <button type="submit"
                  class="w-full px-6 py-3 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold shadow-md transition">
                  Hapus
                </button>
              </form>

            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</x-app-layout>