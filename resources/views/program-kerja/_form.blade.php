@php
$opsi = $opsiWaktu ?? ['bulanan', 'triwulan', 'semester', 'tahunan'];
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-5">

  {{-- NOMOR --}}
  <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">
      Nomor <span class="text-red-500">*</span>
    </label>

    <input
      type="text"
      name="nomor"
      value="{{ old('nomor', $program_kerja->nomor ?? '') }}"
      class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2">
  </div>

  {{-- WAKTU --}}
  <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">
      Waktu Pelaksanaan <span class="text-red-500">*</span>
    </label>

    <select
      name="waktu_pelaksanaan"
      class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2">

      <option value="">-- Pilih Waktu --</option>

      @foreach ($opsi as $opt)
      <option
        value="{{ $opt }}"
        @selected(old('waktu_pelaksanaan', $program_kerja->waktu_pelaksanaan ?? '') == $opt)>
        {{ ucfirst($opt) }}
      </option>
      @endforeach

    </select>
  </div>

  {{-- URAIAN --}}
  <div class="md:col-span-2">
    <label class="block text-sm font-medium text-gray-700 mb-1">
      Uraian Kegiatan <span class="text-red-500">*</span>
    </label>

    <textarea
      name="uraian_kegiatan"
      rows="4"
      class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2">{{ old('uraian_kegiatan', $program_kerja->uraian_kegiatan ?? '') }}</textarea>
  </div>

  {{-- SASARAN --}}
  <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">
      Sasaran <span class="text-red-500">*</span>
    </label>

    <input
      type="text"
      name="sasaran"
      value="{{ old('sasaran', $program_kerja->sasaran ?? '') }}"
      class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2">
  </div>

  {{-- TARGET --}}
  <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">
      Target <span class="text-red-500">*</span>
    </label>

    <input
      type="text"
      name="target"
      value="{{ old('target', $program_kerja->target ?? '') }}"
      class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2">
  </div>

  {{-- BIAYA --}}
  <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">
      Biaya (Rp) <span class="text-red-500">*</span>
    </label>

    <input
      type="number"
      name="biaya"
      min="0"
      value="{{ old('biaya', $program_kerja->biaya ?? 0) }}"
      class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2">
  </div>

  {{-- PENANGGUNG JAWAB --}}
  <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">
      Penanggung Jawab <span class="text-red-500">*</span>
    </label>

    <input
      type="text"
      name="penanggung_jawab"
      value="{{ old('penanggung_jawab', $program_kerja->penanggung_jawab ?? '') }}"
      class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2">
  </div>

</div>

<div class="mt-6 flex gap-3">

  <button
    type="submit"
    class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">

    {{ isset($program_kerja) ? 'Perbarui Data' : 'Simpan Data' }}

  </button>

  <a href="{{ route('program-kerja.index') }}"
    class="px-5 py-2.5 border rounded-lg text-gray-700 hover:bg-gray-50">
    Batal
  </a>

</div>