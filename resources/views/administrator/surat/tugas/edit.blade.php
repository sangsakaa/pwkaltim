<x-app-layout>
  <x-slot name="header">
    <div class="flex flex-col gap-1">
      <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
        Edit Surat Tugas
      </h2>
      <p class="text-sm text-gray-500 dark:text-gray-400">
        Perbarui informasi surat tugas
      </p>
    </div>
  </x-slot>

  <div class="py-8 px-4">
    <div class="max-w-6xl mx-auto">

      <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden">

        {{-- Header Card --}}
        <div class="border-b border-gray-200 dark:border-gray-700 px-8 py-6">
          <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
            Form Edit Surat Tugas
          </h3>
          <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
            Lengkapi data di bawah untuk memperbarui surat tugas
          </p>
        </div>

        <form action="{{ route('surat-tugas.update', $surat_tuga->id) }}"
          method="POST"
          class="p-8">

          @csrf
          @method('PUT')

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Nomor Surat --}}
            <div>
              <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                Nomor Surat
              </label>

              <input type="text"
                name="nomor"
                value="{{ old('nomor', $surat_tuga->nomor) }}"
                required
                class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm">

              @error('nomor')
              <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
              @enderror
            </div>

            {{-- Nama --}}
            <div>
              <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">
                Nama
              </label>

              <input type="text"
                name="nama"
                value="{{ old('nama', $surat_tuga->nama) }}"
                required
                class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 shadow-sm">

              @error('nama')
              <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
              @enderror
            </div>

            {{-- Hari --}}
            <div>
              <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">
                Hari
              </label>

              <input type="text"
                name="hari"
                value="{{ old('hari', $surat_tuga->hari) }}"
                required
                class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 shadow-sm">

              @error('hari')
              <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
              @enderror
            </div>

            {{-- Tanggal Hijriyah --}}
            <div>
              <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">
                Tanggal Hijriyah
              </label>

              <input type="text"
                name="tanggal_hijriyah"
                value="{{ old('tanggal_hijriyah', $surat_tuga->tanggal_hijriyah) }}"
                class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 shadow-sm">

              @error('tanggal_hijriyah')
              <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
              @enderror
            </div>

            {{-- Tanggal Masehi --}}
            <div>
              <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">
                Tanggal Masehi
              </label>

              <input type="date"
                name="tanggal_masehi"
                value="{{ old('tanggal_masehi', $surat_tuga->tanggal_masehi) }}"
                required
                class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 shadow-sm">

              @error('tanggal_masehi')
              <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
              @enderror
            </div>

            {{-- Pukul --}}
            <div>
              <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">
                Pukul
              </label>

              <input type="text"
                name="pukul"
                value="{{ old('pukul', $surat_tuga->pukul) }}"
                required
                class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 shadow-sm">

              @error('pukul')
              <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
              @enderror
            </div>

            {{-- Tempat --}}
            <div>
              <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">
                Tempat
              </label>

              <input type="text"
                name="tempat"
                value="{{ old('tempat', $surat_tuga->tempat) }}"
                required
                class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 shadow-sm">

              @error('tempat')
              <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
              @enderror
            </div>

            {{-- Kota --}}
            <div>
              <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">
                Kota
              </label>

              <input type="text"
                name="kota"
                value="{{ old('kota', $surat_tuga->kota) }}"
                required
                class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 shadow-sm">

              @error('kota')
              <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
              @enderror
            </div>

            {{-- Keperluan --}}
            <div class="md:col-span-2">
              <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">
                Keperluan
              </label>

              <input type="text"
                name="keperluan"
                value="{{ old('keperluan', $surat_tuga->keperluan) }}"
                required
                class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 shadow-sm">

              @error('keperluan')
              <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
              @enderror
            </div>

            {{-- Alamat --}}
            <div class="md:col-span-2">
              <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">
                Alamat
              </label>

              <textarea name="alamat"
                rows="3"
                required
                class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 shadow-sm">{{ old('alamat', $surat_tuga->alamat) }}</textarea>

              @error('alamat')
              <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
              @enderror
            </div>

            {{-- Keterangan --}}
            <div class="md:col-span-2">
              <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">
                Keterangan
              </label>

              <textarea name="keterangan"
                rows="3"
                class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 shadow-sm">{{ old('keterangan', $surat_tuga->keterangan) }}</textarea>

              @error('keterangan')
              <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
              @enderror
            </div>

            {{-- Tanggal Surat Hijriyah --}}
            <div>
              <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">
                Tanggal Surat Hijriyah
              </label>

              <input type="text"
                name="tanggal_surat_hijriyah"
                value="{{ old('tanggal_surat_hijriyah', $surat_tuga->tanggal_surat_hijriyah) }}"
                class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 shadow-sm">
            </div>

            {{-- Tanggal Surat Masehi --}}
            <div>
              <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">
                Tanggal Surat Masehi
              </label>

              <input type="date"
                name="tanggal_surat_masehi"
                value="{{ old('tanggal_surat_masehi', $surat_tuga->tanggal_surat_masehi) }}"
                required
                class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 shadow-sm">
            </div>

            {{-- Penandatangan --}}
            <div class="md:col-span-2">
              <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">
                Penandatangan
              </label>

              <input type="text"
                name="penandatangan"
                value="{{ old('penandatangan', $surat_tuga->penandatangan) }}"
                required
                class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 shadow-sm">
            </div>
          </div>

          {{-- Button --}}
          <div class="flex flex-col sm:flex-row justify-end gap-3 mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">

            <a href="{{ route('surat-tugas.index') }}"
              class="px-5 py-3 rounded-xl bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium transition text-center dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
              Batal
            </a>

            <button type="submit"
              class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-md transition">
              Update Surat Tugas
            </button>

          </div>

        </form>
      </div>
    </div>
  </div>
</x-app-layout>