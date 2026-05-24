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
  @endphp

  @section('title', 'PW ' . $wilayah)

  {{-- HEADER --}}
  <x-slot name="header">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

      <div class="flex items-center gap-3">
        <img src="{{ asset('image/logo.png') }}"
          class="w-10 h-10 sm:w-12 sm:h-12 object-contain"
          alt="Logo">

        <div>
          <h2 class="text-lg sm:text-xl font-semibold text-gray-800">
            Dashboard <span class="text-green-700">PW {{ $wilayah }}</span>
          </h2>
          <p class="text-xs text-gray-500 hidden sm:block">
            Sistem administrasi program kerja
          </p>
        </div>
      </div>

      <a href="{{ route('program-kerja.create') }}"
        class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg shadow">
        + Tambah Program
      </a>

    </div>
  </x-slot>

  {{-- CONTENT --}}
  <div class="p-4 sm:p-6 space-y-6">

    {{-- STATS CARD --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

      <div class="bg-gradient-to-r from-green-700 to-green-800 text-white rounded-lg shadow p-5">
        <div class="flex items-center gap-3">
          <img src="{{ asset('image/logo.png') }}" class="w-12 h-12" alt="logo">

          <div>
            <h3 class="text-lg font-semibold uppercase">
              PW {{ $wilayah }}
            </h3>
            <p class="text-xs text-green-100">
              Dashboard program kerja aktif
            </p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-5 flex items-center justify-between">
        <div>
          <p class="text-sm text-gray-500">Status Sistem</p>
          <p class="text-lg font-semibold text-gray-800">Aktif</p>
        </div>

        <div class="text-right">
          <p class="text-sm text-gray-500">Data</p>
          <p class="text-lg font-semibold text-green-700">Terkelola</p>
        </div>
      </div>

    </div>

    {{-- MAIN CARD --}}
    <div class="bg-white rounded-lg shadow p-5 space-y-5">

      {{-- FLASH --}}
      @include('components.flash')

      {{-- FILTER BAR --}}
      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">

        {{-- SEARCH --}}
        <form method="GET"
          action="{{ route('program-kerja.index') }}"
          class="flex w-full md:w-1/2">

          <input
            name="q"
            value="{{ $q ?? '' }}"
            placeholder="Cari nomor, uraian, sasaran..."
            class="w-full px-3 py-2 border rounded-l-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">

          <button class="px-4 bg-gray-900 text-white rounded-r-lg hover:bg-black">
            Cari
          </button>

        </form>

        {{-- EXPORT --}}
        <div class="flex flex-wrap gap-2">

          @foreach (['bulanan','triwulan','semester','tahunan'] as $type)
          <a href="{{ route('program-kerja.export.pdf', $type) }}"
            target="_blank"
            class="px-3 py-2 text-xs font-medium bg-red-600 hover:bg-red-700 text-white rounded-lg">
            {{ ucfirst($type) }}
          </a>
          @endforeach

          <a href="{{ route('program-kerja.exportPdf', 'semua') }}"
            target="_blank"
            class="px-3 py-2 text-xs font-medium bg-red-700 hover:bg-red-800 text-white rounded-lg">
            Semua
          </a>

        </div>

      </div>

      {{-- TABLE --}}
      <div class="overflow-x-auto border rounded-lg">

        <table class="min-w-full text-sm">

          <thead class="bg-gray-100">
            <tr>
              @foreach (['Nomor','Uraian','Waktu','Tujuan','Sasaran','Biaya','PJ','Aksi'] as $col)
              <th class="text-left p-3 text-xs font-semibold text-gray-600">
                {{ $col }}
              </th>
              @endforeach
            </tr>
          </thead>

          <tbody class="divide-y">

            @forelse ($data as $row)
            <tr class="hover:bg-gray-50 transition">

              <td class="p-3 whitespace-nowrap">{{ $row->nomor }}</td>

              <td class="p-3 max-w-xs">
                <div class="line-clamp-2 text-gray-700">
                  {{ $row->uraian_kegiatan }}
                </div>
              </td>

              <td class="p-3 capitalize text-gray-600">{{ $row->waktu_pelaksanaan }}</td>
              <td class="p-3 text-gray-600">{{ $row->target }}</td>
              <td class="p-3 text-gray-600">{{ $row->sasaran }}</td>
              <td class="p-3 text-gray-600">{{ $row->biaya_rupiah }}</td>
              <td class="p-3 text-gray-600">{{ $row->penanggung_jawab }}</td>

              <td class="p-3">
                <div class="flex gap-2">

                  <a href="{{ route('program-kerja.show', $row) }}"
                    class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded text-xs">
                    Detail
                  </a>

                  <a href="{{ route('program-kerja.edit', $row) }}"
                    class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs">
                    Edit
                  </a>

                  <form method="POST"
                    action="{{ route('program-kerja.destroy', $row) }}"
                    onsubmit="return confirm('Hapus data ini?')">

                    @csrf
                    @method('DELETE')

                    <button class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs">
                      Hapus
                    </button>

                  </form>

                </div>
              </td>

            </tr>
            @empty
            <tr>
              <td colspan="8" class="p-6 text-center text-gray-500">
                Tidak ada data program kerja.
              </td>
            </tr>
            @endforelse

          </tbody>

        </table>

      </div>

      {{-- PAGINATION --}}
      <div class="pt-3">
        {{ $data->links() }}
      </div>

    </div>

  </div>

</x-app-layout>