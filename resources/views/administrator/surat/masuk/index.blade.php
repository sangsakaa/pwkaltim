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
        <a href="{{ route('surat-masuk.create') }}"
          class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded shadow text-sm">
          + Tambah Surat Masuk
        </a>
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

    <!-- Konten utama -->
    <div class="bg-white p-4 sm:p-6 rounded-md shadow-md">
      @if(session('success'))
      <div class="mb-4 rounded bg-green-50 border border-green-200 p-3 text-green-700 text-sm">
        {{ session('success') }}
      </div>
      @endif

      <div class="flex flex-col gap-4">
        <!-- Action bar (mobile friendly) -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
          <div class="flex items-center gap-2">
            <a href="{{ route('surat-masuk.create') }}"
              class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded shadow text-sm">
              + Tambah Surat Masuk
            </a>
            <!-- Tambahkan filter/search jika perlu di sini -->
          </div>

          <div class="flex items-center gap-2">
            <!-- Placeholder untuk search atau filter -->
            <form method="GET" action="{{ route('surat-masuk.index') }}" class="flex items-center gap-2">
              <input type="text" name="q" value="{{ request('q') }}"
                class="border rounded px-3 py-2 text-sm w-40 sm:w-64 focus:outline-none focus:ring-2 focus:ring-blue-200"
                placeholder="Cari nomor, asal, perihal...">
              <button type="submit" class="bg-gray-100 text-gray-700 px-3 py-2 rounded text-sm hover:bg-gray-200">Cari</button>
            </form>
          </div>
        </div>

        <!-- Table responsif: gunakan overflow-x-auto, table compact untuk mobile -->
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y border">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nomor Surat</th>
                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Asal Surat</th>
                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase hidden sm:table-cell">Tanggal Surat</th>
                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Perihal</th>
                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y">
              @forelse($surat as $s)
              <tr class="hover:bg-gray-50">
                <td class="px-3 py-2 text-sm text-gray-700">{{ $loop->iteration }}</td>
                <td class="px-3 py-2 text-sm text-gray-700 whitespace-nowrap">{{ $s->nomor_surat }}</td>
                <td class="px-3 py-2 text-sm text-gray-700 whitespace-nowrap">{{ $s->asal_surat }}</td>
                <td class="px-3 py-2 text-sm text-gray-700 hidden sm:table-cell whitespace-nowrap">{{ $s->tanggal_surat }}</td>
                <td class="px-3 py-2 text-sm text-gray-700 max-w-xs truncate">{{ $s->perihal }}</td>
                <td class="px-3 py-2 text-sm text-gray-700">
                  <div class="flex items-center gap-2">
                    <a href="{{ route('surat-masuk.show', $s->id) }}" class="text-blue-600 hover:underline">Detail</a>
                    <a href="{{ route('surat-masuk.edit', $s->id) }}" class="text-yellow-600 hover:underline">Edit</a>
                    <form action="{{ route('surat-masuk.destroy', $s->id) }}" method="POST" class="inline"
                      onsubmit="return confirm('Yakin hapus data ini?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                    </form>
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="6" class="px-3 py-6 text-center text-gray-500">Belum ada data</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <!-- Pagination dan info -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mt-4">
          <div class="text-sm text-gray-500">
            Menampilkan {{ $surat->firstItem() ?: 0 }} - {{ $surat->lastItem() ?: 0 }} dari {{ $surat->total() }} data
          </div>
          <div>
            {{ $surat->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>