<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl">Detail Program Kerja</h2>
  </x-slot>

  <div class="bg-white shadow rounded p-4 space-y-2">
    <div><span class="font-semibold">Nomor:</span> {{ $program_kerja->nomor }}</div>
    <div><span class="font-semibold">Uraian:</span> {{ $program_kerja->uraian_kegiatan }}</div>
    <div><span class="font-semibold">Waktu:</span> {{ ucfirst($program_kerja->waktu_pelaksanaan) }}</div>
    <div><span class="font-semibold">Sasaran:</span> {{ $program_kerja->sasaran }}</div>
    <div><span class="font-semibold">Target:</span> {{ $program_kerja->target }}</div>
    <div><span class="font-semibold">Biaya:</span> {{ $program_kerja->biaya_rupiah }}</div>
    <div><span class="font-semibold">Penanggung Jawab:</span> {{ $program_kerja->penanggung_jawab }}</div>
  </div>

  <div class="mt-4 flex gap-2">
    <a class="px-4 py-2 rounded bg-yellow-500 text-white" href="{{ route('program-kerja.edit', $program_kerja) }}">Edit</a>
    <a class="px-4 py-2 rounded border" href="{{ route('program-kerja.index') }}">Kembali</a>
  </div>
</x-app-layout>