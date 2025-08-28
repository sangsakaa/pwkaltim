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

  <div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

      <!-- Welcome Section -->
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

      <!-- Data Tables Section -->
      <div class="mt-6 bg-white p-6 rounded-md shadow-md">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-xl font-bold">Detail Daftar Surat</h2>
        </div>

        {{-- Detail Surat --}}
        <div class="overflow-x-auto">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <table class="min-w-full table-auto border-collapse">
                <tbody class="divide-y">
                  <tr class="bg-gray-50">
                    <th class="text-left px-4 py-3 w-48 font-medium">Nomor Surat</th>
                    <td class="px-4 py-3">{{ $surat->nomor_surat }}</td>
                  </tr>
                  <tr>
                    <th class="text-left px-4 py-3 font-medium">Lampiran</th>
                    <td class="px-4 py-3">{{ $surat->lampiran }}</td>
                  </tr>
                  <tr class="bg-gray-50">
                    <th class="text-left px-4 py-3 font-medium">Perihal</th>
                    <td class="px-4 py-3">{{ $surat->perihal }}</td>
                  </tr>
                  <tr>
                    <th class="text-left px-4 py-3 font-medium">Kepada</th>
                    <td class="px-4 py-3">{{ $surat->kepada }}</td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div>
              <table class="min-w-full table-auto border-collapse">
                <tbody class="divide-y">
                  <tr class="bg-gray-50">
                    <th class="text-left px-4 py-3 font-medium">Tempat</th>
                    <td class="px-4 py-3">{{ $surat->tempat }}</td>
                  </tr>
                  <tr>
                    <th class="text-left px-4 py-3 font-medium">Tanggal Hijriah</th>
                    <td class="px-4 py-3">{{ $surat->tanggal_hijriah }}</td>
                  </tr>
                  <tr class="bg-gray-50">
                    <th class="text-left px-4 py-3 font-medium">Tanggal Masehi</th>
                    <td class="px-4 py-3">{{ $surat->tanggal_masehi }}</td>
                  </tr>
                  <tr>
                    <th class="text-left px-4 py-3 align-top font-medium">Isi Surat</th>
                    <td class="px-4 py-3 whitespace-pre-line">{!! e($surat->isi_surat) !!}</td>
                  </tr>
                  <tr class="bg-gray-50">
                    <th class="text-left px-4 py-3 font-medium">Penandatangan</th>
                    <td class="px-4 py-3">{{ $surat->penandatangan }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

        </div>

        {{-- Upload File --}}
        <div class="mt-6 p-4 border rounded bg-gray-50">
          <h3 class="text-lg font-semibold mb-3">Upload File Surat</h3>
          <form action="{{ route('surat.upload', $surat->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file_surat" accept=".pdf,.jpg,.jpeg,.png"
              class="block w-full border rounded p-2 mb-3">
            <button type="submit"
              class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
              Upload
            </button>
          </form>
        </div>

        {{-- Daftar File --}}
        @if($surat->files && $surat->files->count())
        <div class="mt-6 p-4 border rounded bg-gray-50">
          <h3 class="text-lg font-semibold mb-3">Daftar File Surat</h3>

          <ul class="divide-y">
            @foreach($surat->files as $file)
            <li class="py-2 flex justify-between items-center">
              <div>
                📎 <strong>{{ $file->nama_file }}</strong>
                <span class="text-sm text-gray-500">({{ strtoupper($file->tipe_file) }})</span>
              </div>
              <div class="flex gap-2">
                {{-- View File --}}
                <a href="{{ asset('storage/' . $file->path_file) }}" target="_blank"
                  class="px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700">
                  View
                </a>
                {{-- Download File --}}
                <a href="{{ route('surat.file.download', $file->id) }}"
                  class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                  Download
                </a>
                {{-- Delete File --}}
                <form action="{{ route('surat.file.delete', $file->id) }}" method="POST"
                  onsubmit="return confirm('Yakin hapus file ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit"
                    class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700">
                    Delete
                  </button>
                </form>
              </div>
            </li>
            @endforeach
          </ul>
        </div>
        @endif

        <div class="mt-6 flex justify-start">
          <a href="{{ route('surat.index') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
            Kembali
          </a>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>