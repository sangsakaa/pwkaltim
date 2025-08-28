<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800">
      Daftar Surat Masuk
    </h2>
  </x-slot>

  <div class="p-6">
    <a href="{{ route('surat-masuk.create') }}"
      class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">
      + Tambah Surat Masuk
    </a>

    @if(session('success'))
    <div class="mt-4 bg-green-100 text-green-700 p-3 rounded">
      {{ session('success') }}
    </div>
    @endif

    <div class="mt-4 overflow-x-auto">
      <table class="min-w-full bg-white border">
        <thead>
          <tr class="bg-gray-100 text-left">
            <th class="px-4 py-2 border">No</th>
            <th class="px-4 py-2 border">Nomor Surat</th>
            <th class="px-4 py-2 border">Asal Surat</th>
            <th class="px-4 py-2 border">Tanggal Surat</th>
            <th class="px-4 py-2 border">Perihal</th>
            <th class="px-4 py-2 border">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($surat as $s)
          <tr class="hover:bg-gray-50">
            <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
            <td class="px-4 py-2 border">{{ $s->nomor_surat }}</td>
            <td class="px-4 py-2 border">{{ $s->asal_surat }}</td>
            <td class="px-4 py-2 border">{{ $s->tanggal_surat }}</td>
            <td class="px-4 py-2 border">{{ $s->perihal }}</td>
            <td class="px-4 py-2 border space-x-2">
              <a href="{{ route('surat-masuk.show', $s->id) }}" class="text-blue-600">Detail</a>
              <a href="{{ route('surat-masuk.edit', $s->id) }}" class="text-yellow-600">Edit</a>
              <form action="{{ route('surat-masuk.destroy', $s->id) }}" method="POST" class="inline"
                onsubmit="return confirm('Yakin hapus data ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600">Hapus</button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="px-4 py-2 text-center text-gray-500">Belum ada data</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-4">
      {{ $surat->links() }}
    </div>
  </div>
</x-app-layout>