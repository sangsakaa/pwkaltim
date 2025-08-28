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

  <div class="space-y-4">
    <!-- Header Card -->
    <div class="bg-green-800 text-white rounded-md shadow-md flex items-center gap-4 p-4">
      <div class="flex-shrink-0">
        <img src="{{ asset('image/logo.png') }}" alt="Logo" class="w-12 h-12 md:w-14 md:h-14 object-contain">
      </div>

      <div>
        <h3 class="uppercase text-lg md:text-xl font-semibold">PW {{ $wilayah }}</h3>
        <p class="text-sm text-green-100 mt-1 hidden md:block">Selamat datang di dashboard PW {{ $wilayah }}</p>
      </div>
    </div>

    <!-- Detail Surat Card -->
    <div class="bg-white p-4 rounded-md shadow-md">
      <div class="flex flex-col lg:flex-row lg:items-start lg:gap-6">
        <!-- Left column: Details -->
        <div class="w-full lg:w-2/3">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div class="space-y-1">
              <div class="text-sm text-gray-500">Nomor Surat</div>
              <div class="font-medium text-gray-800 break-words">{{ $surat->nomor_surat ?? '-' }}</div>
            </div>

            <div class="space-y-1">
              <div class="text-sm text-gray-500">Asal Surat</div>
              <div class="font-medium text-gray-800">{{ $surat->asal_surat ?? '-' }}</div>
            </div>

            <div class="space-y-1">
              <div class="text-sm text-gray-500">Tanggal Surat</div>
              <div class="font-medium text-gray-800">{{ $surat->tanggal_surat ?? '-' }}</div>
            </div>

            <div class="space-y-1">
              <div class="text-sm text-gray-500">Tanggal Terima</div>
              <div class="font-medium text-gray-800">{{ $surat->tanggal_terima ?? '-' }}</div>
            </div>

            <div class="sm:col-span-2 space-y-1">
              <div class="text-sm text-gray-500">Perihal</div>
              <div class="font-medium text-gray-800">{{ $surat->perihal ?? '-' }}</div>
            </div>

            <div class="sm:col-span-2 space-y-1">
              <div class="text-sm text-gray-500">Keterangan</div>
              <div class="text-gray-800 whitespace-pre-line">{{ $surat->keterangan ?? '-' }}</div>
            </div>
          </div>

          <div class="mt-4 flex flex-col sm:flex-row sm:items-center sm:gap-3 gap-2">
            <a href="{{ route('surat-masuk.index') }}"
              class="inline-flex items-center justify-center px-4 py-2 rounded bg-gray-600 text-white hover:bg-gray-700 transition">
              Kembali
            </a>

            @if($surat->file_surat)
            <a href="{{ Storage::url($surat->file_surat) }}" target="_blank"
              class="inline-flex items-center justify-center px-4 py-2 rounded border border-gray-300 text-gray-700 hover:bg-gray-50 transition">
              Lihat File Surat
            </a>
            @else
            <span class="text-sm text-gray-500 mt-2 sm:mt-0">Tidak ada file</span>
            @endif
          </div>
        </div>

        <!-- Right column: Visual / metadata -->
        <div class="w-full lg:w-1/3 mt-4 lg:mt-0">
          <div class="border border-gray-100 rounded p-3 bg-gray-50">
            <div class="text-xs text-gray-500">Ringkasan</div>
            <div class="mt-2 text-sm text-gray-800">
              <div><strong>Nomor:</strong> <span class="font-medium">{{ $surat->nomor_surat ?? '-' }}</span></div>
              <div class="mt-1"><strong>Asal:</strong> <span class="font-medium">{{ $surat->asal_surat ?? '-' }}</span></div>
              <div class="mt-1"><strong>Tanggal Terima:</strong> <span class="font-medium">{{ $surat->tanggal_terima ?? '-' }}</span></div>
            </div>

            @if($surat->file_surat)
            <div class="mt-4">
              <div class="text-xs text-gray-500">Preview</div>
              <div class="mt-2">
                <!-- Jika file berupa PDF di storage, coba embed; fallback ke tombol lihat -->
                @if(Str::endsWith($surat->file_surat, ['.pdf']))
                <iframe src="{{ Storage::url($surat->file_surat) }}" class="w-full h-48 rounded border" frameborder="0"></iframe>
                @else
                <img src="{{ Storage::url($surat->file_surat) }}" alt="File Surat" class="w-full h-48 object-contain rounded">
                @endif
              </div>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>