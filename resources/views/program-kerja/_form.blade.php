@php
$opsi = $opsiWaktu ?? ['bulanan', 'triwulan', 'semester', 'tahunan'];
@endphp

<div class="grid md:grid-cols-2 gap-4">
  <div>
    <label class="block mb-1">Nomor <span class="text-red-600">*</span></label>
    <input type="text" name="nomor" value="{{ old('nomor', $program_kerja->nomor ?? '') }}"
      class="border rounded w-full px-3 py-2">
  </div>

  <div>
    <label class="block mb-1">Waktu Pelaksanaan <span class="text-red-600">*</span></label>
    <select name="waktu_pelaksanaan" class="border rounded w-full px-3 py-2">
      <option value="">-- Pilih --</option>
      @foreach ($opsi as $opt)
      <option value="{{ $opt }}" @selected(old('waktu_pelaksanaan', $program_kerja->waktu_pelaksanaan ?? '') === $opt)>
        {{ ucfirst($opt) }}
      </option>
      @endforeach
    </select>
  </div>

  <div class="md:col-span-2">
    <label class="block mb-1">Uraian Kegiatan <span class="text-red-600">*</span></label>
    <textarea name="uraian_kegiatan" rows="4" class="border rounded w-full px-3 py-2">{{ old('uraian_kegiatan', $program_kerja->uraian_kegiatan ?? '') }}</textarea>
  </div>

  <div>
    <label class="block mb-1">Sasaran <span class="text-red-600">*</span></label>
    <input type="text" name="sasaran" value="{{ old('sasaran', $program_kerja->sasaran ?? '') }}"
      class="border rounded w-full px-3 py-2">
  </div>

  <div>
    <label class="block mb-1">Tujuan <span class="text-red-600">*</span></label>
    <input type="text" name="target" value="{{ old('target', $program_kerja->target ?? '') }}"
      class="border rounded w-full px-3 py-2">
  </div>

  <div>
    <label class="block mb-1">Biaya (Rp) <span class="text-red-600">*</span></label>
    <input type="number" name="biaya" min="0" step="1"
      value="{{ old('biaya', $program_kerja->biaya ?? 0) }}"
      class="border rounded w-full px-3 py-2">
  </div>

  <div>
    <label class="block mb-1">Penanggung Jawab <span class="text-red-600">*</span></label>
    <input type="text" name="penanggung_jawab" value="{{ old('penanggung_jawab', $program_kerja->penanggung_jawab ?? '') }}"
      class="border rounded w-full px-3 py-2">
  </div>
</div>

<div class="mt-4 flex gap-2">
  <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
  <a href="{{ route('program-kerja.index') }}" class="px-4 py-2 rounded border">Batal</a>
</div>