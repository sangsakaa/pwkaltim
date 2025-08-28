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

    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
      <div class="flex items-center gap-3">
        <img src="{{ asset('image/logo.png') }}" alt="Logo" class="w-10 h-10 sm:w-12 sm:h-12 object-contain">
        <div>
          <h2 class="text-lg sm:text-xl font-semibold text-gray-800 leading-tight">
            Dashboard - <span class="text-green-700">PW {{ $wilayah }}</span>
          </h2>
          <p class="text-xs text-green-600 hidden sm:block">Selamat datang di dashboard PW {{ $wilayah }}</p>
        </div>
      </div>

      <div class="flex gap-2 items-center">
        <!-- Tombol aksi header (jika diperlukan) -->
        <!-- <a href="{{ route('surat-masuk.create') }}"
          class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded shadow text-sm">
          + Tambah Surat Masuk
        </a> -->
      </div>
    </div>
  </x-slot>
  <div class="space-y-4 p-4 sm:p-6">
    <!-- Header Card (ringkasan) -->
    <div class="bg-gradient-to-r from-green-800 to-green-700 text-white rounded-md shadow-md p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div class="flex items-center gap-3">
        <img src="{{ asset('image/logo.png') }}" alt="Logo" class="w-12 h-12 sm:w-14 sm:h-14 object-contain">
        <div>
          <h3 class="uppercase text-base sm:text-lg font-semibold">PW {{ $wilayah }}</h3>
          <p class="text-sm text-green-100 hidden sm:block">Selamat datang di dashboard PW {{ $wilayah }}</p>
        </div>
      </div>
      <div class="text-sm text-green-100">
        <!-- Contoh ringkasan kecil (bisa diganti dengan statistik) -->
        <div class="flex gap-4">
          <div class="flex flex-col">
            <span class="font-semibold">Surat</span>
            <span class="text-xs">Terbaru & Terkelola</span>
          </div>
          <div class="flex flex-col">
            <span class="font-semibold">Anggota</span>
            <span class="text-xs">--</span>
          </div>
        </div>
      </div>
    </div>
    <div class="bg-white p-4 sm:p-6 rounded-md shadow-md">
      <div class="p-6">
        <form action="{{ route('surat-masuk.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 sm:grid-cols-2 gap-2">
          @csrf

          <div class="flex flex-col">
            <label class="block">Nomor Surat</label>
            <input type="text" name="nomor_surat" value="{{ old('nomor_surat') }}"
              class="w-full border rounded p-2" required>
            @error('nomor_surat') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
          </div>

          <div class="flex flex-col">
            <label class="block">Asal Surat</label>
            <input type="text" name="asal_surat" value="{{ old('asal_surat') }}"
              class="w-full border rounded p-2" required>
          </div>

          <div class="flex flex-col">
            <label class="block">Tanggal Surat</label>
            <input type="date" name="tanggal_surat" value="{{ old('tanggal_surat') }}"
              class="w-full border rounded p-2" required>
          </div>

          <div class="flex flex-col">
            <label class="block">Tanggal Terima</label>
            <input type="date" name="tanggal_terima" value="{{ old('tanggal_terima') }}"
              class="w-full border rounded p-2">
          </div>

          <div class="flex flex-col">
            <label class="block">Perihal</label>
            <input type="text" name="perihal" value="{{ old('perihal') }}"
              class="w-full border rounded p-2" required>
          </div>

          <div class="flex flex-col">
            <label class="block">Keterangan</label>
            <textarea name="keterangan" class="w-full border rounded p-2" rows="3">{{ old('keterangan') }}</textarea>
          </div>

          <div class="flex flex-col">
            <label class="block">File Surat (pdf/jpg/png)</label>
            <input type="file" name="file_surat" class="w-full border rounded p-2">
          </div>

          <!-- Tombol submit mengambil full-width pada satu kolom di bawah -->
          <div class="sm:col-span-2 flex gap-2 items-center">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
            <a href="{{ route('surat-masuk.index') }}" class="text-gray-600">Batal</a>
          </div>
        </form>
      </div>
    </div>
</x-app-layout>