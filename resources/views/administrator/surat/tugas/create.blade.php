<x-app-layout>
  <x-slot name="header">
    <h2 class="font-bold text-xl">Tambah Surat Tugas</h2>
  </x-slot>

  <div class="p-6 bg-white rounded-lg shadow-md ">
    <form action="{{ route('surat-tugas.store') }}" method="POST" class="space-y-5">
      @csrf

      <!-- Nomor Surat -->
      <div>
        <label class="block font-semibold mb-1">Nomor Surat</label>
        <input type="text" name="nomor" value="{{ old('nomor') }}"
          class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500" required
          placeholder="Contoh: 06/DPRW-B/Tgs./VII/1446H">
        <small class="text-gray-500">Format: 06/DPRW-B/Tgs./VII/1446H</small>
        @error('nomor') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>

      <!-- Nama -->
      <div>
        <label class="block font-semibold mb-1">Nama</label>
        <input type="text" name="nama" value="{{ old('nama') }}"
          class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500" required>
        @error('nama') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>

      <!-- Hari & Tanggal -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block font-semibold mb-1">Hari</label>
          <input type="text" name="hari" value="{{ old('hari') }}"
            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500" required>
          @error('hari') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
          <label class="block font-semibold mb-1">Tanggal Masehi</label>
          <input type="date" name="tanggal_masehi" value="{{ old('tanggal_masehi') }}"
            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500" required>
          @error('tanggal_masehi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
      </div>

      <!-- Tanggal Hijriyah -->
      <div>
        <label class="block font-semibold mb-1">Tanggal Hijriyah</label>
        <input type="text" name="tanggal_hijriyah" value="{{ old('tanggal_hijriyah') }}"
          class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500"
          placeholder="Contoh: 27 Rajab 1446 H">
        @error('tanggal_hijriyah') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>

      <!-- Pukul -->
      <div>
        <label class="block font-semibold mb-1">Pukul</label>
        <input type="text" name="pukul" value="{{ old('pukul') }}"
          class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500"
          placeholder="20.00 WITA s.d Selesai" required>
        @error('pukul') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>

      <!-- Tempat -->
      <div>
        <label class="block font-semibold mb-1">Tempat</label>
        <input type="text" name="tempat" value="{{ old('tempat') }}"
          class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500" required>
        @error('tempat') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>

      <!-- Alamat -->
      <div>
        <label class="block font-semibold mb-1">Alamat</label>
        <textarea name="alamat"
          class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500" rows="3" required>{{ old('alamat') }}</textarea>
        @error('alamat') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>

      <!-- Keperluan -->
      <div>
        <label class="block font-semibold mb-1">Keperluan</label>
        <input type="text" name="keperluan" value="{{ old('keperluan') }}"
          class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500" required>
        @error('keperluan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>

      <!-- Keterangan -->
      <div>
        <label class="block font-semibold mb-1">Keterangan</label>
        <textarea name="keterangan"
          class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500" rows="2">{{ old('keterangan') }}</textarea>
        @error('keterangan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>

      <!-- Kota & Tanggal Surat -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block font-semibold mb-1">Kota</label>
          <input type="text" name="kota" value="{{ old('kota') }}"
            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500" required>
          @error('kota') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
          <label class="block font-semibold mb-1">Tanggal Surat (Masehi)</label>
          <input type="date" name="tanggal_surat_masehi" value="{{ old('tanggal_surat_masehi') }}"
            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500" required>
          @error('tanggal_surat_masehi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
      </div>

      <!-- Tanggal Surat Hijriyah -->
      <div>
        <label class="block font-semibold mb-1">Tanggal Surat (Hijriyah)</label>
        <input type="text" name="tanggal_surat_hijriyah" value="{{ old('tanggal_surat_hijriyah') }}"
          class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500"
          placeholder="Contoh: 20 Muharram 1447 H">
        @error('tanggal_surat_hijriyah') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>

      <!-- Penandatangan -->
      <div>
        <label class="block font-semibold mb-1">Penandatangan</label>
        <input type="text" name="penandatangan" value="{{ old('penandatangan') }}"
          class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500"
          placeholder="Ketua DPRW" required>
        @error('penandatangan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
      </div>

      <!-- Tombol -->
      <div class="flex justify-end gap-3 pt-4">
        <a href="{{ route('surat-tugas.index') }}"
          class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition">Batal</a>
        <button type="submit"
          class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">Simpan</button>
      </div>
    </form>
  </div>
</x-app-layout>