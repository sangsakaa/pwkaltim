<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800">
      Edit Surat Masuk
    </h2>
  </x-slot>

  <div class="p-6">
    <form action="{{ route('surat-masuk.update', $surat->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
      @csrf
      @method('PUT')

      <div>
        <label class="block">Nomor Surat</label>
        <input type="text" name="nomor_surat" value="{{ old('nomor_surat', $surat->nomor_surat) }}"
          class="w-full border rounded p-2" required>
      </div>

      <div>
        <label class="block">Asal Surat</label>
        <input type="text" name="asal_surat" value="{{ old('asal_surat', $surat->asal_surat) }}"
          class="w-full border rounded p-2" required>
      </div>

      <div>
        <label class="block">Tanggal Surat</label>
        <input type="date" name="tanggal_surat" value="{{ old('tanggal_surat', $surat->tanggal_surat) }}"
          class="w-full border rounded p-2" required>
      </div>

      <div>
        <label class="block">Tanggal Terima</label>
        <input type="date" name="tanggal_terima" value="{{ old('tanggal_terima', $surat->tanggal_terima) }}"
          class="w-full border rounded p-2">
      </div>

      <div>
        <label class="block">Perihal</label>
        <input type="text" name="perihal" value="{{ old('perihal', $surat->perihal) }}"
          class="w-full border rounded p-2" required>
      </div>

      <div>
        <label class="block">Keterangan</label>
        <textarea name="keterangan" class="w-full border rounded p-2">{{ old('keterangan', $surat->keterangan) }}</textarea>
      </div>

      <div>
        <label class="block">File Surat</label>
        @if($surat->file_surat)
        <p class="text-sm text-gray-600">File lama: <a href="{{ Storage::url($surat->file_surat) }}" target="_blank" class="text-blue-600 underline">Lihat</a></p>
        @endif
        <input type="file" name="file_surat" class="w-full border rounded p-2">
      </div>

      <div>
        <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded">Update</button>
        <a href="{{ route('surat-masuk.index') }}" class="ml-2 text-gray-600">Batal</a>
      </div>
    </form>
  </div>
</x-app-layout>