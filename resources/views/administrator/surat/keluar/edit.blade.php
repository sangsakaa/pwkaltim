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

    @section('title', 'Edit Surat - PW ' . $wilayah)

    <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
      <h2 class="text-xl font-semibold text-gray-800 leading-tight">
        Dashboard - <span class="text-green-700">PW {{ $wilayah }}</span>
      </h2>
    </div>
  </x-slot>
  <div class="grid grid-cols-1 gap-2">
    <div class="bg-green-800 text-white rounded-md shadow-md flex items-center">
      <div class="bg-green-800 p-2 rounded-md flex items-center justify-center">
        <img src="{{ asset('image/logo.png') }}" alt="Logo" width="50">
      </div>
      <div class="ml-4">
        <h3 class="uppercase text-lg font-semibold">PW {{ $wilayah }}</h3>
      </div>
    </div>
  </div>

  <div class="py-6">
    <div class="">
      <!-- Form Edit Surat -->
      <div class="bg-white p-6 rounded-md shadow-md">
        <form method="POST" action="{{ route('surat.update', $surat->id) }}">
          @csrf
          @method('PUT')

          <div class=" grid grid-cols-2 gap-2">


            <div class="mb-4">
              <label for="nomor_surat" class="block font-medium text-gray-700">Nomor Surat</label>
              <input type="text" name="nomor_surat" id="nomor_surat"
                value="{{ old('nomor_surat', $surat->nomor_surat) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
              @error('nomor_surat')
              <p class="text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div class="mb-4">
              <label for="lampiran" class="block font-medium text-gray-700">Lampiran</label>
              <input type="text" name="lampiran" id="lampiran"
                value="{{ old('lampiran', $surat->lampiran) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
              @error('lampiran')
              <p class="text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div class="mb-4">
              <label for="perihal" class="block font-medium text-gray-700">Perihal</label>
              <input type="text" name="perihal" id="perihal"
                value="{{ old('perihal', $surat->perihal) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
              @error('perihal')
              <p class="text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div class="mb-4">
              <label for="kepada" class="block font-medium text-gray-700">Kepada</label>
              <input type="text" name="kepada" id="kepada"
                value="{{ old('kepada', $surat->kepada) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
              @error('kepada')
              <p class="text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div class="mb-4">
              <label for="tempat" class="block font-medium text-gray-700">Tempat</label>
              <input type="text" name="tempat" id="tempat"
                value="{{ old('tempat', $surat->tempat) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
              @error('tempat')
              <p class="text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div class="mb-4">
              <label for="tanggal_hijriah" class="block font-medium text-gray-700">Tanggal Hijriah</label>
              <input type="text" name="tanggal_hijriah" id="tanggal_hijriah"
                value="{{ old('tanggal_hijriah', $surat->tanggal_hijriah) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
              @error('tanggal_hijriah')
              <p class="text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div class="mb-4">
              <label for="tanggal_masehi" class="block font-medium text-gray-700">Tanggal Masehi</label>
              <input type="date" name="tanggal_masehi" id="tanggal_masehi"
                value="{{ old('tanggal_masehi', $surat->tanggal_masehi) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
              @error('tanggal_masehi')
              <p class="text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div class="mb-4">
              <label for="penandatangan" class="block font-medium text-gray-700">Penandatangan</label>
              <input type="text" name="penandatangan" id="penandatangan"
                value="{{ old('penandatangan', $surat->penandatangan) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
              @error('penandatangan')
              <p class="text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>
          </div>
          <div class="mb-4">
            <label for="isi_surat" class="block font-medium text-gray-700">Isi Surat</label>
            <textarea name="isi_surat" id="isi_surat" rows="5"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('isi_surat', $surat->isi_surat) }}</textarea>
            @error('isi_surat')
            <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>


          <div class="flex justify-start gap-3 mt-6">
            <button type="submit"
              class="inline-flex items-center px-4 py-2 bg-blue-500  text-white rounded-md hover:bg-green-700">
              Update
            </button>
            <a href="{{ route('surat.index') }}"
              class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-gray-300">
              Batal
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>