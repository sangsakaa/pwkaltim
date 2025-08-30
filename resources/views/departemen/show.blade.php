<x-app-layout>
  <x-slot name="header">
    <h2 class="font-bold text-xl">Detail Departemen</h2>
  </x-slot>

  <div class="bg-white shadow rounded p-6 max-w-lg mx-auto">
    <table class="table-auto w-full border">
      <tr>
        <th class="border px-4 py-2 text-left w-1/3">ID</th>
        <td class="border px-4 py-2">{{ $departemen->id }}</td>
      </tr>
      <tr>
        <th class="border px-4 py-2 text-left">Nama Departemen</th>
        <td class="border px-4 py-2">{{ $departemen->name }}</td>
      </tr>
      <tr>
        <th class="border px-4 py-2 text-left">Singkatan</th>
        <td class="border px-4 py-2">{{ $departemen->short_code }}</td>
      </tr>
      <tr>
        <th class="border px-4 py-2 text-left">Node Code</th>
        <td class="border px-4 py-2">{{ $departemen->node_code }}</td>
      </tr>
      <tr>
        <th class="border px-4 py-2 text-left">Prov Code</th>
        <td class="border px-4 py-2">{{ $departemen->prov_code }}</td>
      </tr>
      <tr>
        <th class="border px-4 py-2 text-left">Dibuat</th>
        <td class="border px-4 py-2">{{ $departemen->created_at->format('d-m-Y H:i') }}</td>
      </tr>
      <tr>
        <th class="border px-4 py-2 text-left">Diperbarui</th>
        <td class="border px-4 py-2">{{ $departemen->updated_at->format('d-m-Y H:i') }}</td>
      </tr>
    </table>

    <div class="mt-4 flex justify-end">
      <a href="{{ route('departemen.index') }}"
        class="px-4 py-2 bg-gray-300 text-gray-700 rounded mr-2">Kembali</a>
      <a href="{{ route('departemen.edit', $departemen) }}"
        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Edit</a>
    </div>
  </div>
</x-app-layout>