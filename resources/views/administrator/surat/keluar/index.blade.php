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
        <!-- <a href="{{ route('surat-masuk.create') }}"
          class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded shadow text-sm">
          + Tambah Surat Masuk
        </a> -->
      </div>
    </div>
  </x-slot>

  <div class="space-y-4 p-4 sm:p-6">
    <!-- Header ringkasan -->
    <div class="bg-gradient-to-r from-green-800 to-green-700 text-white rounded-md shadow-md p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div class="flex items-center gap-3">
        <img src="{{ asset('image/logo.png') }}" alt="Logo" class="w-12 h-12 sm:w-14 sm:h-14 object-contain">
        <div>
          <h3 class="uppercase text-base sm:text-lg font-semibold">PW {{ $wilayah }}</h3>
          <p class="text-sm text-green-100 hidden sm:block">Selamat datang di dashboard PW {{ $wilayah }}</p>
        </div>
      </div>

      <div class="text-sm text-green-100">
        <div class="flex gap-6">
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

    <!-- Content card -->
    <div class="bg-white p-4 rounded-md shadow-md">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Daftar Surat</h2>
        <a href="{{ route('surat.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
          + Tambah Surat
        </a>
      </div>

      @if (session('success'))
      <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
        {{ session('success') }}
      </div>
      @endif

      <div class="overflow-x-auto">
        <table class="min-w-full table-auto border-collapse border border-gray-300">
          <thead class="bg-gray-100 text-left">
            <tr>
              <th class="border border-gray-300 px-3 py-2">No</th>
              <th class="border border-gray-300 px-3 py-2">Nomor Surat</th>
              <th class="border border-gray-300 px-3 py-2">Perihal</th>
              <th class="border border-gray-300 px-3 py-2">Kepada</th>
              <th class="border border-gray-300 px-3 py-2">Tanggal</th>
              <th class="border border-gray-300 px-3 py-2 text-center">Aksi</th>
            </tr>
          </thead>

          <tbody>
            @forelse ($surat as $i => $item)
            <tr class="hover:bg-gray-50">
              <td class="border border-gray-300 px-3 py-2">{{ $surat->firstItem() + $i }}</td>
              <td class="border border-gray-300 px-3 py-2">{{ $item->nomor_surat }}</td>
              <td class="border border-gray-300 px-3 py-2">{{ $item->perihal }}</td>
              <td class="border border-gray-300 px-3 py-2">{{ $item->kepada }}</td>
              <td class="border border-gray-300 px-3 py-2">
                {{ $item->tanggal_masehi ? \Carbon\Carbon::parse($item->tanggal_masehi)->format('d-m-Y') : '-' }}
              </td>
              <td class="border border-gray-300 px-3 py-2 text-center space-x-2">
                <a href="{{ route('surat.show', $item->id) }}" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">Lihat</a>
                <a href="{{ route('surat.edit', $item->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">Edit</a>

                <form action="{{ route('surat.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus surat ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                    Hapus
                  </button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="text-center py-3">Belum ada data surat</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="mt-4">
        {{ $surat->links() }}
      </div>
    </div>
  </div>
</x-app-layout>