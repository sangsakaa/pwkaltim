<x-app-layout>
  <x-slot name="header">
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

    @section('title', 'PW ' . $wilayah)

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
      <div class="flex items-center gap-3">
        <img src="{{ asset('image/logo.png') }}" alt="Logo" class="w-12 h-12 object-contain">
        <div>
          <h2 class="text-xl font-bold text-gray-800">
            Dashboard - <span class="text-green-700">PW {{ $wilayah }}</span>
          </h2>
          <p class="text-sm text-gray-500">Selamat datang di dashboard PW {{ $wilayah }}</p>
        </div>
      </div>

    </div>
  </x-slot>
  <div class="space-y-6 p-4 sm:p-6">
    <!-- Header ringkasan -->
    <div class="bg-gradient-to-r from-green-700 to-green-600 text-white rounded-xl shadow-lg p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5">
      <div class="flex items-center gap-4">
        <img src="{{ asset('image/logo.png') }}" alt="Logo" class="w-14 h-14 object-contain">
        <div>
          <h3 class="uppercase text-lg font-semibold">PW {{ $wilayah }}</h3>
          <p class="text-sm text-green-100">Ringkasan aktivitas surat & anggota</p>
        </div>
      </div>
      <div class="flex gap-8 text-sm">
        <div class="flex flex-col text-center">
          <span class="font-bold text-lg">Surat</span>
          <span class="text-green-100">Terbaru & Terkelola</span>
        </div>
        <div class="flex flex-col text-center">
          <span class="font-bold text-lg">Anggota</span>
          <span class="text-green-100">--</span>
        </div>
      </div>
    </div>


    <div class="">
      <form action="{{ route('surat-masuk.update', $surat->id) }}" method="POST" enctype="multipart/form-data"
        class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 space-y-6  mx-auto">
        @csrf
        @method('PUT')

        <!-- Grid untuk field -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

          <!-- Nomor Surat -->
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor Surat</label>
            <input type="text" name="nomor_surat"
              value="{{ old('nomor_surat', $surat->nomor_surat) }}"
              class="mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring focus:ring-yellow-500 p-2"
              required>
          </div>

          <!-- Asal Surat -->
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Asal Surat</label>
            <input type="text" name="asal_surat"
              value="{{ old('asal_surat', $surat->asal_surat) }}"
              class="mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring focus:ring-yellow-500 p-2"
              required>
          </div>

          <!-- Tanggal Surat -->
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Surat</label>
            <input type="date" name="tanggal_surat"
              value="{{ old('tanggal_surat', $surat->tanggal_surat) }}"
              class="mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring focus:ring-yellow-500 p-2"
              required>
          </div>

          <!-- Tanggal Terima -->
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Terima</label>
            <input type="date" name="tanggal_terima"
              value="{{ old('tanggal_terima', $surat->tanggal_terima) }}"
              class="mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring focus:ring-yellow-500 p-2">
          </div>
        </div>

        <!-- Perihal -->
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Perihal</label>
          <input type="text" name="perihal"
            value="{{ old('perihal', $surat->perihal) }}"
            class="mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring focus:ring-yellow-500 p-2"
            required>
        </div>

        <!-- Keterangan -->
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Keterangan</label>
          <textarea name="keterangan" rows="3"
            class="mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring focus:ring-yellow-500 p-2">{{ old('keterangan', $surat->keterangan) }}</textarea>
        </div>

        <!-- File Surat -->
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">File Surat</label>
          @if($surat->file_surat)
          <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
            File lama:
            <a href="{{ Storage::url($surat->file_surat) }}" target="_blank"
              class="text-blue-600 dark:text-blue-400 underline">Lihat</a>
          </p>
          @endif
          <input type="file" name="file_surat"
            class="mt-2 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring focus:ring-yellow-500 p-2">
        </div>

        <!-- Tombol Aksi -->
        <div class="flex justify-end space-x-3 pt-4 border-t dark:border-gray-600">
          <a href="{{ route('surat-masuk.index') }}"
            class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
            Batal
          </a>
          <button type="submit"
            class="px-4 py-2 rounded-lg bg-yellow-600 text-white font-medium hover:bg-yellow-700 shadow">
            Update
          </button>
        </div>
      </form>
    </div>
</x-app-layout>