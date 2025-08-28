<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800">
      Detail Surat Masuk
    </h2>
  </x-slot>

  <div class="p-6 space-y-4">
    <div><strong>Nomor Surat:</strong> {{ $surat->nomor_surat }}</div>
    <div><strong>Asal Surat:</strong> {{ $surat->asal_surat }}</div>
    <div><strong>Tanggal Surat:</strong> {{ $surat->tanggal_surat }}</div>
    <div><strong>Tanggal Terima:</strong> {{ $surat->tanggal_terima }}</div>
    <div><strong>Perihal:</strong> {{ $surat->perihal }}</div>
    <div><strong>Keterangan:</strong> {{ $surat->keterangan }}</div>
    <div>
      <strong>File Surat:</strong>
      @if($surat->file_surat)
      <a href="{{ Storage::url($surat->file_surat) }}" target="_blank" class="text-blue-600 underline">Lihat File</a>
      @else
      <span class="text-gray-500">Tidak ada file</span>
      @endif
    </div>

    <div class="mt-4">
      <a href="{{ route('surat-masuk.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded">Kembali</a>
    </div>
  </div>
</x-app-layout>