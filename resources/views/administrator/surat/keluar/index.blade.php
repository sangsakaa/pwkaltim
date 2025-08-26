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
  <div class="mt-4 bg-white p-4 rounded-md shadow-md">
    <!-- Tabel Daftar Surat -->
   
    <div class="overflow-x-auto mb-6"> {{-- Gunakan overflow-x-auto untuk tabel horizontal scroll --}}
      <div class="min-w-full mx-auto bg-white p-6 rounded shadow"> {{-- Gunakan min-w-full untuk memastikan tabel memenuhi lebar container --}}
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-xl font-bold">Daftar Surat</h2>
          <a href="{{ route('surat.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
            + Tambah Surat
          </a>
        </div>

        @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
          {{ session('success') }}
        </div>
        @endif

        <table class="w-full border-collapse border border-gray-300">
          <thead>
            <tr class="bg-gray-100 text-left">
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
                <a href="{{ route('surat.show', $item->id) }}" class="bg-green-500 text-white px-3 py-1 rounded">Lihat</a>
                <a href="{{ route('surat.edit', $item->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</a>
                <form action="{{ route('surat.destroy', $item->id) }}" method="POST" class="inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" onclick="return confirm('Yakin ingin menghapus surat ini?')" class="bg-red-500 text-white px-3 py-1 rounded">
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

        <div class="mt-4">
          {{ $surat->links() }}
        </div>
      </div>
    </div>
  </div>
</x-app-layout>