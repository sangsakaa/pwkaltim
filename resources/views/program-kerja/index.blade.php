<x-app-layout>

  @php
  $user = auth()->user();

  $wilayah = 'Tidak diketahui';

  if ($user->regency?->name) {
  $wilayah = Str::startsWith($user->regency->name, 'Kab.')
  ? 'Kabupaten ' . ltrim(substr($user->regency->name, 4))
  : $user->regency->name;
  } elseif ($user->district?->name) {
  $wilayah = 'Kec. ' . $user->district->name;
  } elseif ($user->village?->name) {
  $wilayah = $user->village->name;
  } elseif ($user->province?->name) {
  $wilayah = $user->province->name;
  }

  $tahun = request('tahun', now()->year);
  $waktu = request('waktu', 'semua');
  @endphp

  @section('title', 'PW ' . $wilayah)

  {{-- HEADER --}}
  <x-slot name="header">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

      <div class="flex items-center gap-3">
        <img src="{{ asset('image/logo.png') }}" class="w-10 h-10 sm:w-12 sm:h-12" />

        <div>
          <h2 class="text-lg font-semibold text-gray-800">
            Dashboard <span class="text-green-700">PW {{ $wilayah }}</span>
          </h2>
          <p class="text-xs text-gray-500">
            Sistem administrasi program kerja
          </p>
        </div>
      </div>

      <a href="{{ route('program-kerja.create') }}"
        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg shadow">
        + Tambah Program
      </a>

    </div>
  </x-slot>

  {{-- CONTENT --}}
  <div class="p-4 sm:p-6 space-y-6">

    {{-- STATS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

      <div class="bg-gradient-to-r from-green-700 to-green-800 text-white rounded-xl p-5 shadow">
        <div class="flex items-center gap-3">
          <img src="{{ asset('image/logo.png') }}" class="w-10 h-10">
          <div>
            <h3 class="font-semibold">PW {{ $wilayah }}</h3>
            <p class="text-xs text-green-100">Dashboard program kerja</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-xl p-5 shadow flex justify-between">
        <div>
          <p class="text-xs text-gray-500">Status</p>
          <p class="font-semibold text-gray-800">Aktif</p>
        </div>
        <div class="text-right">
          <p class="text-xs text-gray-500">Data</p>
          <p class="font-semibold text-green-700">Terkelola</p>
        </div>
      </div>

    </div>

    {{-- FILTER + SEARCH + EXPORT --}}
    <div class="bg-white rounded-xl shadow p-4 space-y-4 sticky top-2 z-10">

      <form method="GET"
        action="{{ route('program-kerja.index') }}"
        class="grid grid-cols-1 md:grid-cols-4 gap-3 items-center">

        {{-- SEARCH --}}
        <input type="text"
          name="q"
          value="{{ request('q') }}"
          placeholder="Cari program kerja..."
          class="border rounded-lg px-3 py-2 col-span-1 md:col-span-2 focus:ring-2 focus:ring-blue-500">

        {{-- TAHUN --}}
        <select name="tahun" class="border rounded-lg px-3 py-2">
          @for ($i = now()->year; $i >= now()->year - 5; $i--)
          <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>
            {{ $i }}
          </option>
          @endfor
        </select>

        {{-- WAKTU --}}
        <select name="waktu" class="border rounded-lg px-3 py-2">
          <option value="semua" {{ $waktu == 'semua' ? 'selected' : '' }}>Semua</option>
          @foreach (['bulanan','triwulan','semester','tahunan'] as $w)
          <option value="{{ $w }}" {{ $waktu == $w ? 'selected' : '' }}>
            {{ ucfirst($w) }}
          </option>
          @endforeach
        </select>

        <button class="bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2 md:col-span-4">
          Terapkan Filter
        </button>

      </form>

      {{-- EXPORT --}}
      <div class="flex flex-wrap gap-2 pt-2">

        @foreach (['bulanan','triwulan','semester','tahunan'] as $type)
        <a href="{{ route('program-kerja.export.pdf', [
                        'waktu' => $type,
                        'tahun' => $tahun
                    ]) }}"
          target="_blank"
          class="px-3 py-1 text-xs bg-red-600 hover:bg-red-700 text-white rounded-lg">
          {{ ucfirst($type) }}
        </a>
        @endforeach

        <a href="{{ route('program-kerja.export.pdf', [
                    'waktu' => 'semua',
                    'tahun' => $tahun
                ]) }}"
          target="_blank"
          class="px-3 py-1 text-xs bg-red-700 hover:bg-red-800 text-white rounded-lg">
          Semua
        </a>

      </div>

    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">

      <div class="overflow-x-auto">

        <table class="min-w-full text-sm">

          <thead class="bg-gray-100">
            <tr>
              @foreach (['No','Uraian','Waktu','Target','Sasaran','Biaya','PJ','Aksi'] as $col)
              <th class="text-left px-4 py-3 text-xs font-semibold text-gray-600">
                {{ $col }}
              </th>
              @endforeach
            </tr>
          </thead>

          <tbody class="divide-y">

            @forelse ($data as $row)
            <tr class="hover:bg-gray-50">

              <td class="px-4 py-3">{{ $row->nomor }}</td>

              <td class="px-4 py-3 max-w-xs">
                <div class="line-clamp-2 text-gray-700">
                  {{ $row->uraian_kegiatan }}
                </div>
              </td>

              <td class="px-4 py-3 capitalize text-gray-600">
                {{ $row->waktu_pelaksanaan }}
              </td>

              <td class="px-4 py-3">{{ $row->target }}</td>
              <td class="px-4 py-3">{{ $row->sasaran }}</td>
              <td class="px-4 py-3">{{ $row->biaya_rupiah }}</td>
              <td class="px-4 py-3">{{ $row->penanggung_jawab }}</td>

              <td class="px-4 py-3 flex gap-2">

                <a href="{{ route('program-kerja.show', $row) }}"
                  class="px-2 py-1 bg-gray-200 rounded text-xs">
                  Detail
                </a>

                <a href="{{ route('program-kerja.edit', $row) }}"
                  class="px-2 py-1 bg-blue-600 text-white rounded text-xs">
                  Edit
                </a>

                <form method="POST"
                  action="{{ route('program-kerja.destroy', $row) }}"
                  onsubmit="return confirm('Hapus data?')">
                  @csrf
                  @method('DELETE')

                  <button class="px-2 py-1 bg-red-600 text-white rounded text-xs">
                    Hapus
                  </button>
                </form>

              </td>

            </tr>
            @empty
            <tr>
              <td colspan="8" class="text-center py-6 text-gray-500">
                Tidak ada data program kerja
              </td>
            </tr>
            @endforelse

          </tbody>

        </table>

      </div>

    </div>

    {{-- PAGINATION --}}
    <div>
      {{ $data->links() }}
    </div>

  </div>

</x-app-layout>