<div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6">

  <div class="mb-6">
    <h3 class="text-lg font-semibold text-gray-800">
      Informasi Periode Tahunan
    </h3>

    <p class="mt-1 text-sm text-gray-500">
      Lengkapi data periode kepengurusan atau periode program kerja yang akan digunakan.
    </p>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- Nama Periode --}}
    <div class="md:col-span-2">
      <label
        for="nama_periode"
        class="block text-sm font-medium text-gray-700 mb-1">

        Nama Periode
        <span class="text-red-500">*</span>
      </label>

      <input
        type="text"
        id="nama_periode"
        name="nama_periode"
        value="{{ old('nama_periode', $periodeTahunan->nama_periode ?? '') }}"
        placeholder="Contoh: Program Kerja 2025-2030"
        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">

      <p class="mt-1 text-xs text-gray-500">
        Masukkan nama periode kepengurusan atau masa program kerja.
      </p>

      @error('nama_periode')
      <p class="mt-1 text-sm text-red-600">
        {{ $message }}
      </p>
      @enderror
    </div>

    {{-- Tahun Mulai --}}
    <div>
      <label
        for="tahun_mulai"
        class="block text-sm font-medium text-gray-700 mb-1">

        Tahun Mulai
        <span class="text-red-500">*</span>
      </label>

      <input
        type="number"
        id="tahun_mulai"
        name="tahun_mulai"
        min="2000"
        max="2100"
        value="{{ old('tahun_mulai', $periodeTahunan->tahun_mulai ?? '') }}"
        placeholder="2025"
        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">

      <p class="mt-1 text-xs text-gray-500">
        Tahun dimulainya periode.
      </p>

      @error('tahun_mulai')
      <p class="mt-1 text-sm text-red-600">
        {{ $message }}
      </p>
      @enderror
    </div>

    {{-- Tahun Selesai --}}
    <div>
      <label
        for="tahun_selesai"
        class="block text-sm font-medium text-gray-700 mb-1">

        Tahun Selesai
        <span class="text-red-500">*</span>
      </label>

      <input
        type="number"
        id="tahun_selesai"
        name="tahun_selesai"
        min="2000"
        max="2100"
        value="{{ old('tahun_selesai', $periodeTahunan->tahun_selesai ?? '') }}"
        placeholder="2030"
        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">

      <p class="mt-1 text-xs text-gray-500">
        Tahun berakhirnya periode.
      </p>

      @error('tahun_selesai')
      <p class="mt-1 text-sm text-red-600">
        {{ $message }}
      </p>
      @enderror
    </div>

    {{-- Tanggal Mulai --}}
    <div>
      <label
        for="tanggal_mulai"
        class="block text-sm font-medium text-gray-700 mb-1">

        Tanggal Mulai
        <span class="text-red-500">*</span>
      </label>

      <input
        type="date"
        id="tanggal_mulai"
        name="tanggal_mulai"
        value="{{ old('tanggal_mulai', isset($periodeTahunan) ? optional($periodeTahunan->tanggal_mulai)->format('Y-m-d') : '') }}"
        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">

      <p class="mt-1 text-xs text-gray-500">
        Tanggal resmi dimulainya periode.
      </p>

      @error('tanggal_mulai')
      <p class="mt-1 text-sm text-red-600">
        {{ $message }}
      </p>
      @enderror
    </div>

    {{-- Keterangan --}}
    <div class="md:col-span-2">
      <label
        for="keterangan"
        class="block text-sm font-medium text-gray-700 mb-1">

        Keterangan
      </label>

      <textarea
        id="keterangan"
        name="keterangan"
        rows="4"
        placeholder="Tambahkan catatan, informasi kepengurusan, keputusan musyawarah, atau keterangan lainnya..."
        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('keterangan', $periodeTahunan->keterangan ?? '') }}</textarea>

      <p class="mt-1 text-xs text-gray-500">
        Opsional. Digunakan untuk informasi tambahan mengenai periode ini.
      </p>

      @error('keterangan')
      <p class="mt-1 text-sm text-red-600">
        {{ $message }}
      </p>
      @enderror
    </div>

  </div>

  {{-- Informasi --}}
  <div class="mt-6 rounded-lg border border-blue-200 bg-blue-50 p-4">
    <div class="flex gap-3">

      <svg
        class="h-5 w-5 text-blue-600 mt-0.5 flex-shrink-0"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24">

        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />

      </svg>

      <div>

        <h4 class="text-sm font-semibold text-blue-800">
          Petunjuk Pengisian
        </h4>

        <ul class="mt-2 text-sm text-blue-700 list-disc list-inside space-y-1">
          <li>Nama periode harus unik dan mudah dikenali.</li>
          <li>Tahun selesai tidak boleh lebih kecil dari tahun mulai.</li>
          <li>Hanya satu periode yang boleh berstatus aktif dalam satu waktu.</li>
          <li>Program kerja baru akan mengikuti periode yang sedang aktif.</li>
          <li>Pastikan periode yang dibuat sesuai masa kepengurusan organisasi.</li>
        </ul>

      </div>

    </div>
  </div>

  {{-- Tombol --}}
  <div class="mt-8 flex flex-col-reverse sm:flex-row justify-between gap-3">

    <a
      href="{{ route('periode-tahunan.index') }}"
      class="inline-flex items-center justify-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-200 transition">

      ← Kembali
    </a>

    <button
      type="submit"
      class="inline-flex items-center justify-center px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow-sm font-medium transition">

      {{ isset($periodeTahunan) ? '💾 Update Periode' : '💾 Simpan Periode' }}
    </button>

  </div>

</div>