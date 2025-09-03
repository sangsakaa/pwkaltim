<x-app-layout>
  <x-slot name="header">
    <h2 class="font-bold text-xl">Daftar Surat Tugas</h2>
  </x-slot>

  <div class="p-6 bg-white shadow rounded">
    <a href="{{ route('surat-tugas.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">+ Tambah</a>

    <table class="w-full mt-4 border">
      <thead>
        <tr class="bg-gray-200">
          <th class="p-2 border">No</th>
          <th class="p-2 border">Nomor</th>
          <th class="p-2 border">Nama</th>
          <th class="p-2 border">Tanggal</th>
          <th class="p-2 border">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($surat as $s)
        <tr>
          <td class="p-2 border">{{ $loop->iteration }}</td>
          <td class="p-2 border">{{ $s->nomor }}</td>
          <td class="p-2 border">{{ $s->nama }}</td>
          <td class="p-2 border">{{ $s->tanggal_masehi }}</td>
          <td class="p-2 border flex gap-2">
            <a href="{{ route('surat-tugas.show', $s->id) }}" class="text-blue-500">Detail</a>
            <a href="{{ route('surat-tugas.edit', $s->id) }}" class="text-yellow-500">Edit</a>
            <a href="{{ route('surat-tugas.pdf', $s->id) }}" class="text-green-500" target="_blank">PDF</a>
            <form action="{{ route('surat-tugas.destroy',$s->id) }}" method="POST" onsubmit="return confirm('Hapus?')">
              @csrf @method('DELETE')
              <button class="text-red-500">Hapus</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    {{ $surat->links() }}
  </div>
</x-app-layout>