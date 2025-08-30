<x-app-layout>
  <x-slot name="header">
    <h2 class="font-bold text-xl">Edit Departemen</h2>
  </x-slot>

  <div class="bg-white shadow rounded p-6 max-w-lg mx-auto">
    <form action="{{ route('departemen.update', $departemen) }}" method="POST">
      @csrf
      @method('PUT')



      <!-- Nama Departemen -->
      <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700">Nama Departemen</label>
        <input type="text" name="name" id="name"
          value="{{ old('name', $departemen->name) }}"
          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">

        @error('name')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- Info (tidak bisa diubah manual) -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Singkatan (auto)</label>
        <input type="text" value="{{ $departemen->short_code }}" disabled
          class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md">
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Node Code (auto)</label>
        <input type="text" value="{{ $departemen->node_code }}" disabled
          class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md">
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Prov Code (auto)</label>
        <input type="text" value="{{ $departemen->prov_code }}" disabled
          class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md">
      </div>

      <!-- Tombol Update -->
      <div class="flex justify-end">
        <a href="{{ route('departemen.index') }}"
          class="px-4 py-2 bg-gray-300 text-gray-700 rounded mr-2">Batal</a>
        <button type="submit"
          class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Update</button>
      </div>
    </form>
  </div>
</x-app-layout>