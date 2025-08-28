<x-app-layout>
  <x-slot name="header">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
      <h2 class="font-semibold text-xl text-gray-800">Program Kerja</h2>

      <div class="flex items-center gap-2 w-full sm:w-auto">
        <a href="{{ route('program-kerja.create') }}"
          class="ml-auto inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow-sm">
          Tambah
        </a>
      </div>
    </div>
  </x-slot>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 space-y-4">
    {{-- Flash message --}}
    @include('components.flash')

    {{-- Kontrol: pencarian + export --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
      {{-- Pencarian --}}
      <form method="GET" action="{{ route('program-kerja.index') }}" class="flex w-full md:w-1/2">
        <label for="q" class="sr-only">Cari</label>
        <input id="q" name="q" type="text" value="{{ $q ?? '' }}"
          placeholder="Cari nomor / uraian / sasaran / penanggung jawab"
          class="w-full px-3 py-2 rounded-l-md border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none"
          aria-label="Cari program kerja">
        <button type="submit"
          class="px-4 py-2 bg-gray-800 hover:bg-gray-900 text-white rounded-r-md">Cari</button>
      </form>

      {{-- Export --}}
      <div class="flex flex-wrap gap-2">
        <a href="{{ route('program-kerja.export.pdf', 'bulanan') }}" target="_blank" rel="noopener noreferrer"
          class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded text-sm">Bulanan</a>

        <a href="{{ route('program-kerja.export.pdf', 'triwulan') }}" target="_blank" rel="noopener noreferrer"
          class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded text-sm">Triwulan</a>

        <a href="{{ route('program-kerja.export.pdf', 'semester') }}" target="_blank" rel="noopener noreferrer"
          class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded text-sm">Semester</a>

        <a href="{{ route('program-kerja.export.pdf', 'tahunan') }}" target="_blank" rel="noopener noreferrer"
          class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded text-sm">Tahunan</a>
      </div>

    </div>

    {{-- Table container: allow horizontal scroll on small screens --}}
    <div class="bg-white shadow rounded overflow-x-auto">
      <table class="min-w-full divide-y">
        <thead class="bg-gray-100">
          <tr>
            <th class="text-left p-3 text-xs font-medium text-gray-600">Nomor</th>
            <th class="text-left p-3 text-xs font-medium text-gray-600">Uraian</th>
            <th class="text-left p-3 text-xs font-medium text-gray-600">Waktu</th>
            <th class="text-left p-3 text-xs font-medium text-gray-600">Tujuan</th>
            <th class="text-left p-3 text-xs font-medium text-gray-600">Sasaran</th>
            <th class="text-left p-3 text-xs font-medium text-gray-600">Biaya</th>
            <th class="text-left p-3 text-xs font-medium text-gray-600">Penanggung Jawab</th>
            <th class="text-left p-3 text-xs font-medium text-gray-600 w-36">Aksi</th>
          </tr>
        </thead>

        <tbody class="bg-white divide-y">
          @forelse ($data as $row)
          <tr class="hover:bg-gray-50">
            <td class="p-3 align-top text-sm text-gray-700 whitespace-nowrap">{{ $row->nomor }}</td>

            <td class="p-3 align-top text-sm text-gray-700 max-w-xs">
              <div class="line-clamp-3">{{ $row->uraian_kegiatan }}</div>
              {{-- Jika butuh ringkasan: Str::limit sudah dipakai awalnya --}}
            </td>

            <td class="p-3 align-top text-sm text-gray-700 capitalize">{{ $row->waktu_pelaksanaan }}</td>
            <td class="p-3 align-top text-sm text-gray-700">{{ $row->target }}</td>
            <td class="p-3 align-top text-sm text-gray-700">{{ $row->sasaran }}</td>
            <td class="p-3 align-top text-sm text-gray-700">{{ $row->biaya_rupiah }}</td>
            <td class="p-3 align-top text-sm text-gray-700">{{ $row->penanggung_jawab }}</td>

            <td class="p-3 align-top text-sm text-gray-700">
              <div class="flex items-center gap-2">
                <a href="{{ route('program-kerja.show', $row) }}" class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300 text-sm">Detail</a>

                {{-- Hapus: gunakan form dengan konfirmasi --}}
                <form method="POST" action="{{ route('program-kerja.destroy', $row) }}" onsubmit="return confirm('Hapus data ini?')" class="inline">
                  @csrf @method('DELETE')
                  <button type="submit" class="px-3 py-1 rounded bg-red-600 hover:bg-red-700 text-white text-sm">Hapus</button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="8" class="p-4 text-center text-gray-500">Belum ada data.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
      {{ $data->links() }}
    </div>
  </div>
</x-app-layout>