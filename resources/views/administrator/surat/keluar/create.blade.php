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

    <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
      <h2 class="text-xl font-semibold text-gray-800 leading-tight">
        Dashboard - <span class="text-green-700">PW {{ $wilayah }}</span>
      </h2>
    </div>
  </x-slot>

  <!-- Welcome Section -->
  <div class="grid grid-cols-1 gap-2">
    <div class="bg-green-800 text-white rounded-md shadow-md flex items-center p-4">
      <div class="flex items-center justify-center">
        <img src="{{ asset('image/logo.png') }}" alt="Logo" width="50">
      </div>
      <div class="ml-4">
        <h3 class="uppercase text-lg font-semibold">PW {{ $wilayah }}</h3>
      </div>
    </div>
  </div>

  <!-- Form Tambah Surat -->
  <div class="mt-4 bg-white p-6 rounded-md shadow-md">
    <div class="">
      <h2 class="text-xl font-bold mb-4">Tambah Surat Keluar</h2>
      <form action="{{ route('surat.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block mb-1">Nomor Surat</label>
            <input type="text" name="nomor_surat" class="w-full border rounded p-2">
          </div>

          <div>
            <label class="block mb-1">Lampiran</label>
            <input type="text" name="lampiran" class="w-full border rounded p-2">
          </div>

          <div>
            <label class="block mb-1">Perihal</label>
            <input type="text" name="perihal" class="w-full border rounded p-2">
          </div>

          <div>
            <label class="block mb-1">Kepada</label>
            <input type="text" name="kepada" class="w-full border rounded p-2">
          </div>

          <div>
            <label class="block mb-1">Tempat</label>
            <input type="text" name="tempat" class="w-full border rounded p-2">
          </div>

          <div>
            <label class="block mb-1">Tanggal Hijriah</label>
            <input type="text" name="tanggal_hijriah" class="w-full border rounded p-2">
          </div>

          <div>
            <label class="block mb-1">Tanggal Masehi</label>
            <input type="date" name="tanggal_masehi" class="w-full border rounded p-2">
          </div>
          <div class="">
            <label class="block mb-1">Penandatangan</label>
            <input type="text" name="penandatangan" class="w-full border rounded p-2">
          </div>
        </div>
        <div class="mt-4">
          <label class="block mb-1">Isi Surat</label>
          <textarea name="isi_surat" rows="5" class="w-full border rounded p-2"></textarea>
        </div>



        <div class="mt-6">
          <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">
            Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
</x-app-layout>