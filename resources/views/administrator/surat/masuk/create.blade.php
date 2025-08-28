<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800">
      Tambah Surat Masuk
    </h2>
  </x-slot>

  <div class="p-6">
    <form action="{{ route('surat-masuk.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
      @csrf

      <div>
        <label class="block">Nomor Surat</label>
        <input type="text" name="nomor_surat" value="{{ old('nomor_surat') }}"
          class="w-full border rounded p-2" required>
        @error('nomor_surat') <span class="text-red-600">{{ $message }}</span> @enderror
      </div>

      <div>
        <label class="block">Asal Surat</label>
        <input type="text" name="asal_surat" value="{{ old('asal_surat') }}"
          class="w-full border rounded p-2" required>
      </div>

      <div>
        <label class="block">Tanggal Surat</label>
        <input type="date" name="tanggal_surat" value="{{ old('tanggal_surat') }}"
          class="w-full border rounded p-2" required>
      </div>

      <div>
        <label class="block">Tanggal Terima</label>
        <input type="date" name="tanggal_terima" value="{{ old('tanggal_terima') }}"
          class="w-full border rounded p-2">
      </div>

      <div>
        <label class="block">Perihal</label>
        <input type="text" name="perihal" value="{{ old('perihal') }}"
          class="w-full border rounded p-2" required>
      </div>

      <div>
        <label class="block">Keterangan</label>
        <textarea name="keterangan" class="w-full border rounded p-2">{{ old('keterangan') }}</textarea>
      </div>

      <div>
        <label class="block">File Surat (pdf/jpg/png)</label>
        <input type="file" name="file_surat" class="w-full border rounded p-2">
      </div>

      <div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
        <a href="{{ route('surat-masuk.index') }}" class="ml-2 text-gray-600">Batal</a>
      </div>
    </form>
  </div>
</x-app-layout>