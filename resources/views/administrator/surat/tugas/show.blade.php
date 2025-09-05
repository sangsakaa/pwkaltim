<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      Detail Surat Tugas
    </h2>
  </x-slot>

  <div class="py-6">
    <div class="">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">

        <!-- Nomor Surat -->
        <div class="mb-4">
          <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Nomor Surat</h3>
          <p class="text-gray-700 dark:text-gray-300">{{ $surat_tuga->nomor }}</p>
        </div>

        <!-- Perihal -->
        <div class="mb-4">
          <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Perihal</h3>
          <p class="text-gray-700 dark:text-gray-300">{{ $surat_tuga->keperluan }}</p>
        </div>

        <!-- Tanggal -->
        <div class="mb-4">
          <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Tanggal</h3>
          <p class="text-gray-700 dark:text-gray-300">
            {{ \Carbon\Carbon::parse($surat_tuga->tanggal)->translatedFormat('d F Y') }}
          </p>
        </div>

        <!-- Pemberi Tugas -->
        <div class="mb-4">
          <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Pemberi Tugas</h3>
          <p class="text-gray-700 dark:text-gray-300">{{ $surat_tuga->pemberi_tugas }}</p>
        </div>

        <!-- Penerima Tugas -->
        <div class="mb-4">
          <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Penerima Tugas</h3>
          <p class="text-gray-700 dark:text-gray-300">{{ $surat_tuga->penerima_tugas }}</p>
        </div>

        <!-- Keterangan -->
        <div class="mb-4">
          <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Keterangan</h3>
          <p class="text-gray-700 dark:text-gray-300">{{ $surat_tuga->keterangan }}</p>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex justify-between mt-6">
          <a href="{{ route('surat-tugas.index') }}"
            class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded">
            Kembali
          </a>
          <div class="flex space-x-2">
            <a href="{{ route('surat-tugas.edit', $surat_tuga->id) }}"
              class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
              Edit
            </a>
            <form action="{{ route('surat-tugas.destroy', $surat_tuga->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus surat tugas ini?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">
                Hapus
              </button>
            </form>
          </div>
        </div>

      </div>
    </div>
  </div>
</x-app-layout>