<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Detail Program Kerja
        </h2>
        <p class="text-sm text-gray-500 mt-1">#{{ $program_kerja->nomor ?? '-' }} — {{ $program_kerja->uraian_kegiatan ?? 'Tanpa uraian' }}</p>
      </div>

      <div class="flex items-center gap-2">
        <a href="{{ route('program-kerja.index') }}" class="inline-flex items-center px-3 py-1.5 border rounded text-sm text-gray-700 hover:bg-gray-50">
          Kembali
        </a>

        <a href="{{ route('program-kerja.edit', $program_kerja) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded text-sm">
          Edit
        </a>

        {{-- Contoh tombol hapus jika diperlukan
        <form action="{{ route('program-kerja.destroy', $program_kerja) }}" method="POST" onsubmit="return confirm('Hapus program kerja ini?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded text-sm">
          Hapus
        </button>
        </form>
        --}}
      </div>
    </div>
  </x-slot>

  <div class="">
    <div class="bg-white shadow sm:rounded-lg p-6">
      <div class="mb-4 border-b pb-3">
        <h3 class="text-lg font-medium text-gray-900">Informasi Program Kerja</h3>
        <p class="text-sm text-gray-500 mt-1">Detail lengkap program kerja dan penanggung jawab.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <div class="text-sm text-gray-500">Nomor</div>
          <div class="mt-1 text-gray-900 font-semibold">{{ $program_kerja->nomor ?? '-' }}</div>
        </div>

        <div>
          <div class="text-sm text-gray-500">Waktu</div>
          <div class="mt-1 text-gray-900 font-semibold">{{ !empty($program_kerja->waktu_pelaksanaan) ? ucfirst($program_kerja->waktu_pelaksanaan) : '-' }}</div>
        </div>

        <div class="md:col-span-2">
          <div class="text-sm text-gray-500">Uraian</div>
          <div class="mt-1 text-gray-900">{{ $program_kerja->uraian_kegiatan ?? '-' }}</div>
        </div>

        <div class="md:col-span-2">
          <div class="text-sm text-gray-500">Tujuan</div>
          <div class="mt-1 text-gray-900">{{ $program_kerja->tujuan ?? '-' }}</div>
        </div>

        <div>
          <div class="text-sm text-gray-500">Sasaran</div>
          <div class="mt-1 text-gray-900">{{ $program_kerja->sasaran ?? '-' }}</div>
        </div>

        <div>
          <div class="text-sm text-gray-500">Target</div>
          <div class="mt-1 text-gray-900">{{ $program_kerja->target ?? '-' }}</div>
        </div>

        <div>
          <div class="text-sm text-gray-500">Biaya</div>
          <div class="mt-1 text-gray-900">
            {{ $program_kerja->biaya_rupiah ?? (
                isset($program_kerja->biaya) ? 'Rp ' . number_format($program_kerja->biaya, 0, ',', '.') : '-'
            ) }}
          </div>
        </div>

        <div>
          <div class="text-sm text-gray-500">Penanggung Jawab</div>
          <div class="mt-1 text-gray-900">{{ $program_kerja->penanggung_jawab ?? '-' }}</div>
        </div>
      </div>

      {{-- Opsional: catatan atau lampiran --}}
      @if(!empty($program_kerja->catatan) || !empty($program_kerja->lampiran))
      <div class="mt-6 border-t pt-4">
        @if(!empty($program_kerja->catatan))
        <div class="mb-3">
          <div class="text-sm text-gray-500">Catatan</div>
          <div class="mt-1 text-gray-900 whitespace-pre-line">{{ $program_kerja->catatan }}</div>
        </div>
        @endif

        @if(!empty($program_kerja->lampiran))
        <div>
          <div class="text-sm text-gray-500">Lampiran</div>
          <div class="mt-1">
            <a href="{{ asset('storage/' . $program_kerja->lampiran) }}" target="_blank" class="text-indigo-600 hover:underline">Lihat Lampiran</a>
          </div>
        </div>
        @endif
      </div>
      @endif
    </div>
  </div>
</x-app-layout>