<x-app-layout>
  <x-slot name="header">
    <h2 class="font-bold text-xl">Daftar Departemen</h2>
  </x-slot>

  <a href="{{ route('departemen.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah</a>

  <table class="table-auto w-full mt-4 border">
    <thead>
      <tr class="bg-gray-200">
        <th class="border px-2 py-1">#</th>
        <th class="border px-2 py-1">Nama</th>
        <th class="border px-2 py-1">Singkatan</th>
        <th class="border px-2 py-1">Node Code</th>
        <th class="border px-2 py-1">Prov Code</th>
        <th class="border px-2 py-1">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($departemens as $d)
      <tr>
        <td class="border px-2 py-1">{{ $loop->iteration }}</td>
        <td class="border px-2 py-1">{{ $d->name }}</td>
        <td class="border px-2 py-1">{{ $d->short_code }}</td>
        <td class="border px-2 py-1">{{ $d->node_code }}</td>
        <td class="border px-2 py-1">{{ $d->prov_code }}</td>
        <td class="border px-2 py-1">
          <a href="{{ route('departemen.show', $d) }}" class="text-blue-500">Detail</a> |
          <a href="{{ route('departemen.edit', $d) }}" class="text-green-500">Edit</a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  {{ $departemens->links() }}
</x-app-layout>