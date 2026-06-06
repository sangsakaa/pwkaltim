```blade
<x-app-layout>

  @section('title', 'Realisasi Program Kerja')

  <div class="max-w-7xl mx-auto p-4 md:p-6 space-y-6">

    {{-- HEADER --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
          <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
            Realisasi Program Kerja
          </h1>

          <p class="text-gray-500 mt-1">
            Perbandingan antara rencana dan realisasi pelaksanaan program kerja.
          </p>
        </div>

        <div>
          <span class="inline-flex items-center px-4 py-2 rounded-xl bg-blue-50 text-blue-700 font-semibold">
            Program #{{ $program_kerja->nomor }}
          </span>
        </div>

      </div>

    </div>

    @php
    $progress = old('progress', $program_kerja->progress ?? 0);

    if ($progress <= 30) {
      $status='Belum' ;
      $statusColor='bg-red-100 text-red-700' ;
      } elseif ($progress <=70) {
      $status='Proses' ;
      $statusColor='bg-yellow-100 text-yellow-700' ;
      } else {
      $status='Selesai' ;
      $statusColor='bg-green-100 text-green-700' ;
      }
      @endphp

      {{-- SUMMARY --}}
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

      <div class="bg-white rounded-2xl shadow-sm border p-5">
        <p class="text-sm text-gray-500">Progress</p>
        <p class="text-3xl font-bold text-blue-600">
          {{ $progress }}%
        </p>
      </div>

      <div class="bg-white rounded-2xl shadow-sm border p-5">
        <p class="text-sm text-gray-500">Status</p>
        <span class="inline-flex mt-2 px-3 py-1 rounded-full text-sm font-semibold {{ $statusColor }}">
          {{ $status }}
        </span>
      </div>

      <div class="bg-white rounded-2xl shadow-sm border p-5">
        <p class="text-sm text-gray-500">Target</p>
        <p class="font-semibold text-gray-800 mt-1">
          {{ $program_kerja->target }}
        </p>
      </div>

      <div class="bg-white rounded-2xl shadow-sm border p-5">
        <p class="text-sm text-gray-500">Anggaran</p>
        <p class="font-bold text-green-600 mt-1">
          Rp {{ number_format($program_kerja->biaya ?? 0,0,',','.') }}
        </p>
      </div>

  </div>

  {{-- PROGRESS BAR --}}
  <div class="bg-white rounded-2xl shadow-sm border p-6">

    <div class="flex justify-between mb-2">
      <span class="text-sm font-medium text-gray-700">
        Tingkat Penyelesaian
      </span>

      <span class="text-sm font-bold text-gray-800">
        {{ $progress }}%
      </span>
    </div>

    <div class="w-full bg-gray-200 rounded-full h-4">

      <div
        class="h-4 rounded-full transition-all duration-500
                    @if($progress >= 100)
                        bg-green-600
                    @elseif($progress >= 70)
                        bg-blue-600
                    @elseif($progress >= 30)
                        bg-yellow-500
                    @else
                        bg-red-500
                    @endif"
        style="width: {{ $progress }}%">
      </div>

    </div>

  </div>

  {{-- CONTENT --}}
  <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

    {{-- RENCANA --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

      <div class="flex items-center justify-between mb-6">

        <h2 class="text-lg font-bold text-gray-800">
          📌 Rencana Program Kerja
        </h2>

      </div>

      <div class="space-y-5">

        <div>
          <label class="text-xs uppercase text-gray-400">
            Uraian Kegiatan
          </label>

          <p class="mt-1 text-gray-800">
            {{ $program_kerja->uraian_kegiatan }}
          </p>
        </div>

        <div>
          <label class="text-xs uppercase text-gray-400">
            Waktu Pelaksanaan
          </label>

          <p class="mt-1 font-medium">
            {{ ucfirst($program_kerja->waktu_pelaksanaan) }}
          </p>
        </div>

        <div>
          <label class="text-xs uppercase text-gray-400">
            Sasaran
          </label>

          <p class="mt-1">
            {{ $program_kerja->sasaran }}
          </p>
        </div>

        <div>
          <label class="text-xs uppercase text-gray-400">
            Target
          </label>

          <p class="mt-1">
            {{ $program_kerja->target }}
          </p>
        </div>

        <div>
          <label class="text-xs uppercase text-gray-400">
            Penanggung Jawab
          </label>

          <p class="mt-1">
            {{ $program_kerja->penanggung_jawab }}
          </p>
        </div>

      </div>

    </div>

    {{-- FORM REALISASI --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

      <h2 class="text-lg font-bold text-gray-800 mb-6">
        📊 Input Realisasi
      </h2>

      <form method="POST"
        action="{{ route('program-kerja.realisasi.update', $program_kerja->id) }}">
        @csrf
        @method('PUT')

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Realisasi Kegiatan
          </label>

          <textarea
            name="realisasi_kegiatan"
            rows="4"
            class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{ old('realisasi_kegiatan', $program_kerja->realisasi_kegiatan) }}</textarea>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Realisasi Target
          </label>

          <input
            type="text"
            name="realisasi_target"
            value="{{ old('realisasi_target', $program_kerja->realisasi_target) }}"
            class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Progress (%)
          </label>

          <input
            type="number"
            min="0"
            max="100"
            name="progress"
            value="{{ old('progress', $progress) }}"
            class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Anggaran Realisasi
          </label>

          <input
            type="number"
            min="0"
            name="anggaran_realisasi"
            value="{{ old('anggaran_realisasi', $program_kerja->anggaran_realisasi ?? 0) }}"
            class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Tanggal Selesai
          </label>

          <input
            type="date"
            name="tanggal_selesai"
            value="{{ old('tanggal_selesai', optional($program_kerja->tanggal_selesai)->format('Y-m-d')) }}"
            class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="bg-gray-50 border rounded-xl p-4">

          <p class="text-xs uppercase text-gray-500">
            Status Otomatis
          </p>

          <span class="inline-flex mt-2 px-3 py-1 rounded-full text-sm font-semibold {{ $statusColor }}">
            {{ $status }}
          </span>

        </div>

        <div class="flex justify-between items-center pt-5 border-t">

          <a
            href="{{ route('program-kerja.realisasi.index') }}"
            class="text-sm text-gray-500 hover:text-gray-700">
            ← Kembali
          </a>

          <button
            type="submit"
            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium shadow-sm">

            Simpan Realisasi

          </button>

        </div>

      </form>

    </div>

  </div>

  </div>

</x-app-layout>
```