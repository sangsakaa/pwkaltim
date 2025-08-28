<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl">Program Kerja</h2>
  </x-slot>

  <div class="mb-4 flex items-center gap-2">
    <form method="GET" action="{{ route('program-kerja.index') }}" class="flex gap-2">
      <input type="text" name="q" value="{{ $q }}" placeholder="Cari nomor/uraian/sasaran/penanggung jawab"
        class="border rounded px-3 py-2 w-72">
      <button class="bg-gray-800 text-white px-4 py-2 rounded">Cari</button>
    </form>
    <a href="{{ route('program-kerja.create') }}" class="ml-auto bg-blue-600 text-white px-4 py-2 rounded">Tambah</a>
  </div>

  @include('components.flash') {{-- opsional jika Anda ekstrak flash --}}

  <div class="bg-white shadow rounded overflow-x-auto">
    <table class="min-w-full">
      <thead class="bg-gray-100">
        <tr>
          <th class="text-left p-3">Nomor</th>
          <th class="text-left p-3">Uraian Kegiatan</th>
          <th class="text-left p-3">Waktu</th>
          <th class="text-left p-3">Sasaran</th>
          <th class="text-left p-3">Target</th>
          <th class="text-left p-3">Biaya</th>
          <th class="text-left p-3">Penanggung Jawab</th>
          <th class="text-left p-3 w-40">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($data as $row)
        <tr class="border-b">
          <td class="p-3">{{ $row->nomor }}</td>
          <td class="p-3">{{ Str::limit($row->uraian_kegiatan, 80) }}</td>
          <td class="p-3 capitalize">{{ $row->waktu_pelaksanaan }}</td>
          <td class="p-3">{{ $row->sasaran }}</td>
          <td class="p-3">{{ $row->target }}</td>
          <td class="p-3">{{ $row->biaya_rupiah }}</td>
          <td class="p-3">{{ $row->penanggung_jawab }}</td>
          <td class="p-3">
            <div class="flex gap-2">
              <a class="px-3 py-1 rounded bg-gray-200" href="{{ route('program-kerja.show', $row) }}">Detail</a>
              <a class="px-3 py-1 rounded bg-yellow-500 text-white" href="{{ route('program-kerja.edit', $row) }}">Edit</a>
              <form method="POST" action="{{ route('program-kerja.destroy', $row) }}"
                onsubmit="return confirm('Hapus data ini?')">
                @csrf @method('DELETE')
                <button class="px-3 py-1 rounded bg-red-600 text-white">Hapus</button>
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

  <div class="mt-4">
    {{ $data->links() }}
  </div>
</x-app-layout>