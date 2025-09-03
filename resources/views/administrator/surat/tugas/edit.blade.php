<x-app-layout>
  <x-slot name="header">
    <h2 class="font-bold text-xl">Edit Surat Tugas</h2>
  </x-slot>

  <div class="max-w-3xl mx-auto p-6 bg-white rounded shadow">
    <form action="{{ route('surat-tugas.update', $surat_tuga->id) }}" method="POST">
      @csrf
      @method('PUT')

      <!-- Nomor Surat -->
      <div class="mb-4">
        <label class="block font-semibold">Nomor Surat</label>
        <input type="text" name="nomor" value="{{ old('nomor', $surat_tuga->nomor) }}"
          class="w-full border rounded p-2" required>
        @error('nomor') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>

      <!-- Nama -->
      <div class="mb-4">
        <label class="block font-semibold">Nama</label>
        <input type="text" name="nama" value="{{ old('nama', $surat_tuga->nama) }}"
          class="w-full border rounded p-2" required>
        @error('nama') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>

      <!-- Hari -->
      <div class="mb-4">
        <label class="block font-semibold">Hari</label>
        <input type="text" name="hari" value="{{ old('hari', $surat_tuga->hari) }}"
          class="w-full border rounded p-2" required>
        @error('hari') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>

      <!-- Tanggal Hijriyah -->
      <div class="mb-4">
        <label class="block font-semibold">Tanggal Hijriyah</label>
        <input type="text" name="tanggal_hijriyah" value="{{ old('tanggal_hijriyah', $surat_tuga->tanggal_hijriyah) }}"
          class="w-full border rounded p-2">
        @error('tanggal_hijriyah') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>

      <!-- Tanggal Masehi -->
      <div class="mb-4">
        <label class="block font-semibold">Tanggal Masehi</label>
        <input type="date" name="tanggal_masehi" value="{{ old('tanggal_masehi', $surat_tuga->tanggal_masehi) }}"
          class="w-full border rounded p-2" required>
        @error('tanggal_masehi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>

      <!-- Pukul -->
      <div class="mb-4">
        <label class="block font-semibold">Pukul</label>
        <input type="text" name="pukul" value="{{ old('pukul', $surat_tuga->pukul) }}"
          class="w-full border rounded p-2" required>
        @error('pukul') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>

      <!-- Tempat -->
      <div class="mb-4">
        <label class="block font-semibold">Tempat</label>
        <input type="text" name="tempat" value="{{ old('tempat', $surat_tuga->tempat) }}"
          class="w-full border rounded p-2" required>
        @error('tempat') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>

      <!-- Alamat -->
      <div class="mb-4">
        <label class="block font-semibold">Alamat</label>
        <textarea name="alamat" class="w-full border rounded p-2" required>{{ old('alamat', $surat_tuga->alamat) }}</textarea>
        @error('alamat') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>

      <!-- Keperluan -->
      <div class="mb-4">
        <label class="block font-semibold">Keperluan</label>
        <input type="text" name="keperluan" value="{{ old('keperluan', $surat_tuga->keperluan) }}"
          class="w-full border rounded p-2" required>
        @error('keperluan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>

      <!-- Keterangan -->
      <div class="mb-4">
        <label class="block font-semibold">Keterangan</label>
        <textarea name="keterangan" class="w-full border rounded p-2">{{ old('keterangan', $surat_tuga->keterangan) }}</textarea>
        @error('keterangan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>

      <!-- Kota -->
      <div class="mb-4">
        <label class="block font-semibold">Kota</label>
        <input type="text" name="kota" value="{{ old('kota', $surat_tuga->kota) }}"
          class="w-full border rounded p-2" required>
        @error('kota') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>

      <!-- Tanggal Surat Hijriyah -->
      <div class="mb-4">
        <label class="block font-semibold">Tanggal Surat Hijriyah</label>
        <input type="text" name="tanggal_surat_hijriyah" value="{{ old('tanggal_surat_hijriyah', $surat_tuga->tanggal_surat_hijriyah) }}"
          class="w-full border rounded p-2">
        @error('tanggal_surat_hijriyah') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>

      <!-- Tanggal Surat Masehi -->
      <div class="mb-4">
        <label class="block font-semibold">Tanggal Surat Masehi</label>
        <input type="date" name="tanggal_surat_masehi" value="{{ old('tanggal_surat_masehi', $surat_tuga->tanggal_surat_masehi) }}"
          class="w-full border rounded p-2" required>
        @error('tanggal_surat_masehi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>

      <!-- Penandatangan -->
      <div class="mb-4">
        <label class="block font-semibold">Penandatangan</label>
        <input type="text" name="penandatangan" value="{{ old('penandatangan', $surat_tuga->penandatangan) }}"
          class="w-full border rounded p-2" required>
        @error('penandatangan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>

      <!-- Tombol -->
      <div class="flex justify-end gap-3">
        <a href="{{ route('surat-tugas.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Batal</a>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
      </div>
    </form>
  </div>
</x-app-layout>