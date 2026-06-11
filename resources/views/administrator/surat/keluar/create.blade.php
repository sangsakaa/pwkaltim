<x-app-layout>
  @php

  $user = auth()->user();
  $wilayah = 'Tidak diketahui';

  if ($user->regency?->name) {
  $wilayah = Str::startsWith($user->regency->name, 'Kab.')
  ? 'Kabupaten ' . ltrim(substr($user->regency->name, 4))
  : $user->regency->name;
  } elseif ($user->district?->name) {
  $wilayah = 'Kec. ' . $user->district->name;
  } elseif ($user->village?->name) {
  $wilayah = $user->village->name;
  } elseif ($user->province?->name) {
  $wilayah = $user->province->name;
  }
  @endphp

  @section('title', 'Tambah Surat')

  <x-slot name="header">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">

      <div>
        <h2 class="text-2xl font-bold text-gray-800">
          Tambah Surat Keluar
        </h2>

        <p class="text-sm text-gray-500">
          PW {{ $wilayah }}
        </p>
      </div>

      <a href="{{ route('surat.index') }}"
        class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-xl text-gray-700 transition">

        ← Kembali

      </a>

    </div>
  </x-slot>

  <div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

      {{-- Hero Card --}}
      <div
        class="bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 rounded-3xl shadow-xl overflow-hidden">

        <div class="p-8 text-white">

          <div class="flex items-center gap-5">

            <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-sm">
              <img src="{{ asset('image/logo.png') }}"
                alt="Logo"
                class="w-14 h-14 object-contain">
            </div>

            <div>

              <h3 class="text-2xl font-bold">
                PW {{ $wilayah }}
              </h3>

              <p class="text-green-100">
                Form Input Surat Keluar
              </p>

            </div>

          </div>

        </div>

      </div>

      {{-- Form Card --}}
      <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden">

        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50">

          <h3 class="text-lg font-semibold text-gray-800">
            Informasi Surat
          </h3>

          <p class="text-sm text-gray-500 mt-1">
            Lengkapi data surat yang akan disimpan.
          </p>

        </div>

        <form action="{{ route('surat.store') }}" method="POST">

          @csrf

          <div class="p-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

              {{-- Nomor Surat --}}
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Nomor Surat
                </label>

                <input type="text"
                  name="nomor_surat"
                  value="{{ old('nomor_surat') }}"
                  class="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500">

                @error('nomor_surat')
                <p class="text-red-500 text-sm mt-1">
                  {{ $message }}
                </p>
                @enderror
              </div>

              {{-- Lampiran --}}
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Lampiran
                </label>

                <input type="text"
                  name="lampiran"
                  value="{{ old('lampiran') }}"
                  class="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500">
              </div>

              {{-- Perihal --}}
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Perihal
                </label>

                <input type="text"
                  name="perihal"
                  value="{{ old('perihal') }}"
                  class="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500">

                @error('perihal')
                <p class="text-red-500 text-sm mt-1">
                  {{ $message }}
                </p>
                @enderror
              </div>

              {{-- Kepada --}}
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Kepada
                </label>

                <input type="text"
                  name="kepada"
                  value="{{ old('kepada') }}"
                  class="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500">
              </div>

              {{-- Tempat --}}
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Tempat
                </label>

                <input type="text"
                  name="tempat"
                  value="{{ old('tempat') }}"
                  class="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500">
              </div>

              {{-- Tanggal Hijriah --}}
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Tanggal Hijriah
                </label>

                <input type="text"
                  name="tanggal_hijriah"
                  value="{{ old('tanggal_hijriah') }}"
                  class="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500">
              </div>

              {{-- Tanggal Masehi --}}
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Tanggal Masehi
                </label>

                <input type="date"
                  name="tanggal_masehi"
                  value="{{ old('tanggal_masehi') }}"
                  class="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500">
              </div>

              {{-- Penandatangan --}}
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Penandatangan
                </label>

                <input type="text"
                  name="penandatangan"
                  value="{{ old('penandatangan') }}"
                  class="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500">
              </div>

            </div>

            {{-- Isi Surat --}}
            <div class="mt-6">

              <label class="block text-sm font-medium text-gray-700 mb-2">
                Isi Surat
              </label>

              <textarea
                name="isi_surat"
                rows="8"
                class="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500">{{ old('isi_surat') }}</textarea>

              @error('isi_surat')
              <p class="text-red-500 text-sm mt-1">
                {{ $message }}
              </p>
              @enderror

            </div>

          </div>

          {{-- Footer --}}
          <div class="px-6 py-5 border-t bg-gray-50">

            <div class="flex flex-col sm:flex-row gap-3 justify-end">

              <a href="{{ route('surat.index') }}"
                class="px-5 py-3 rounded-xl bg-gray-200 hover:bg-gray-300 text-gray-700 text-center transition">
                Batal
              </a>

              <button type="submit"
                class="px-6 py-3 rounded-xl bg-green-600 hover:bg-green-700 text-white shadow transition">

                Simpan Surat

              </button>

            </div>

          </div>

        </form>

      </div>

    </div>
  </div>
</x-app-layout>