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
    <div class="bg-green-800  text-white rounded-md shadow-md flex items-center">
      <div class="bg-green-800 p-2 rounded-md flex items-center justify-center">
        <img src="{{ asset('image/logo.png') }}" alt="Logo" width="50">
      </div>
      <div class="ml-4">
        <h3 class="uppercase text-lg font-semibold ">PW {{ $wilayah }}</h3>
      </div>
    </div>
  </div>

  <!-- Data Tables Section -->


  <!-- Bagian Tambah Surat -->
  <div class="mt-4 bg-white p-4 rounded-md shadow-md">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
      <h2 class="text-xl font-bold mb-4">Tambah Surat</h2>
      <form action="{{ route('surat.store') }}" method="POST">
        @csrf
        <div class=" grid grid-cols-2 gap-2">
          <div class="mb-3">
            <label class="block">Nomor Surat</label>
            <input type="text" name="nomor_surat" class="w-full border rounded p-2">
          </div>
          <div class="mb-3">
            <label class="block">Lampiran</label>
            <input type="text" name="lampiran" class="w-full border rounded p-2">
          </div>
          <div class="mb-3">
            <label class="block">Perihal</label>
            <input type="text" name="perihal" class="w-full border rounded p-2">
          </div>
          <div class="mb-3">
            <label class="block">Kepada</label>
            <input type="text" name="kepada" class="w-full border rounded p-2">
          </div>
          <div class="mb-3">
            <label class="block">Tempat</label>
            <input type="text" name="tempat" class="w-full border rounded p-2">
          </div>
          <div
          <div class=" grid grid-cols-2 gap-2">
            <div class="mb-3">
              <label class="block">Tanggal Hijriah</label>
              <input type="date" name="tanggal_hijriah" class="w-full border rounded p-2">
            </div>
            <div class="mb-3">
              <label class="block">Tanggal Masehi</label>
              <input type="date" name="tanggal_masehi" class="w-full border rounded p-2">
            </div>

          </div>
          <div class="mb-3">
            <label class="block">Isi Surat</label>
            <textarea name="isi_surat" rows="5" class="w-full border rounded p-2"></textarea>
          </div>
          <div class="mb-3">
            <label class="block">Penandatangan</label>
            <input type="text" name="penandatangan" class="w-full border rounded p-2">
          </div>
          <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
      </form>
    </div>
  </div>
</x-app-layout>