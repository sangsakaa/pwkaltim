<x-app-layout>
  <x-slot name="header">
    <h2 class="font-bold text-xl">Tambah Departemen</h2>
  </x-slot>

  <div class="bg-white shadow rounded p-6 max-w-lg mx-auto">
    <form action="{{ route('departemen.store') }}" method="POST">
      @csrf

      <!-- Nama Departemen -->
      <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700">Nama Departemen</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}"
          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">

        @error('name')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- Tombol Simpan -->
      <div class="flex justify-end">
        <a href="{{ route('departemen.index') }}"
          class="px-4 py-2 bg-gray-300 text-gray-700 rounded mr-2">Batal</a>
        <button type="submit"
          class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
      </div>
    </form>
  </div>
</x-app-layout>