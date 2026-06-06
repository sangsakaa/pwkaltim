<x-app-layout>

  @section('title', 'Realisasi Program Kerja')

  <x-slot name="header">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
      <div>
        <h2 class="text-2xl font-bold text-gray-800">
          Realisasi Program Kerja
        </h2>

        <p class="text-sm text-gray-500 mt-1">
          Monitoring progres pelaksanaan program kerja periode aktif
        </p>
      </div>

      @isset($periodeAktif)
      <div class="bg-green-50 border border-green-200 px-4 py-2 rounded-lg">
        <div class="text-xs text-green-600 font-medium">
          PERIODE AKTIF
        </div>

        <div class="text-sm font-semibold text-green-700">
          {{ $periodeAktif->nama_periode }}
        </div>
      </div>
      @endisset
    </div>
  </x-slot>

  <div class="p-4 sm:p-6 space-y-6">

    {{-- STATISTIK --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-5">

      <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-gray-500">
              Total Program
            </p>

            <h3 class="text-3xl font-bold text-gray-800 mt-1">
              {{ $data->total() }}
            </h3>
          </div>

          <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
            📋
          </div>
        </div>
      </div>

      <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-gray-500">
              Selesai
            </p>

            <h3 class="text-3xl font-bold text-green-600 mt-1">
              {{ $data->getCollection()->where('status_realisasi', 'selesai')->count() }}
            </h3>
          </div>

          <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
            ✅
          </div>
        </div>
      </div>

      <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-gray-500">
              Dalam Proses
            </p>

            <h3 class="text-3xl font-bold text-yellow-500 mt-1">
              {{ $data->getCollection()->where('status_realisasi', 'proses')->count() }}
            </h3>
          </div>

          <div class="w-12 h-12 rounded-xl bg-yellow-100 flex items-center justify-center">
            ⏳
          </div>
        </div>
      </div>

      <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-gray-500">
              Belum Dilaksanakan
            </p>

            <h3 class="text-3xl font-bold text-gray-600 mt-1">
              {{ $data->getCollection()->where('status_realisasi', 'belum')->count() }}
            </h3>
          </div>

          <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center">
            🕒
          </div>
        </div>
      </div>

    </div>

    {{-- TABEL --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

      <div class="px-6 py-4 border-b bg-gray-50">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">

          <div>
            <h3 class="font-semibold text-gray-800">
              Data Realisasi Program Kerja
            </h3>

            <p class="text-sm text-gray-500">
              Daftar program kerja dan progres pelaksanaannya
            </p>
          </div>

        </div>
      </div>

      <div class="overflow-x-auto">

        <table class="min-w-full text-sm">

          <thead class="bg-gray-100">
            <tr>
              <th class="px-4 py-3 text-left font-semibold text-gray-600">
                No
              </th>

              <th class="px-4 py-3 text-left font-semibold text-gray-600">
                Nomor
              </th>

              <th class="px-4 py-3 text-left font-semibold text-gray-600">
                Uraian Kegiatan
              </th>

              <th class="px-4 py-3 text-left font-semibold text-gray-600">
                Penanggung Jawab
              </th>

              <th class="px-4 py-3 text-left font-semibold text-gray-600">
                Waktu
              </th>

              <th class="px-4 py-3 text-left font-semibold text-gray-600">
                Progress
              </th>

              <th class="px-4 py-3 text-left font-semibold text-gray-600">
                Status
              </th>

              <th class="px-4 py-3 text-center font-semibold text-gray-600">
                Aksi
              </th>
            </tr>
          </thead>

          <tbody class="divide-y divide-gray-100">

            @forelse($data as $i => $item)

            @php
            $progress = $item->progress ?? 0;
            $status = strtolower($item->status_realisasi);
            @endphp

            <tr class="hover:bg-gray-50 transition">

              <td class="px-4 py-4">
                {{ $data->firstItem() + $i }}
              </td>

              <td class="px-4 py-4 font-semibold text-gray-800">
                {{ $item->nomor }}
              </td>

              <td class="px-4 py-4">
                <div class="max-w-md">
                  <p class="font-medium text-gray-800">
                    {{ $item->uraian_kegiatan }}
                  </p>

                  <p class="text-xs text-gray-500 mt-1">
                    Target : {{ $item->target }}
                  </p>
                </div>
              </td>

              <td class="px-4 py-4">
                {{ $item->penanggung_jawab }}
              </td>

              <td class="px-4 py-4">
                <span class="inline-flex px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-medium">
                  {{ ucfirst($item->waktu_pelaksanaan) }}
                </span>
              </td>

              <td class="px-4 py-4 min-w-[220px]">

                <div class="space-y-1">

                  <div class="flex justify-between text-xs">
                    <span class="text-gray-500">
                      Progress
                    </span>

                    <span class="font-semibold text-gray-700">
                      {{ $progress }}%
                    </span>
                  </div>

                  <div class="w-full bg-gray-200 rounded-full h-2.5">

                    <div
                      class="h-2.5 rounded-full transition-all duration-500
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

              </td>

              <td class="px-4 py-4">

                @if($status == 'selesai')

                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                  ✓ Selesai
                </span>

                @elseif($status == 'proses')

                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                  ⏳ Proses
                </span>

                @else

                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                  ○ Belum
                </span>

                @endif

              </td>

              <td class="px-4 py-4 text-center">

                <a
                  href="{{ route('program-kerja.realisasi.edit', $item->id) }}"
                  class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-medium rounded-lg shadow-sm transition">

                  Update Realisasi

                </a>

              </td>

            </tr>

            @empty

            <tr>
              <td colspan="8" class="py-12">

                <div class="flex flex-col items-center justify-center">

                  <div class="text-6xl mb-3">
                    📋
                  </div>

                  <h3 class="font-semibold text-gray-700">
                    Belum Ada Data
                  </h3>

                  <p class="text-sm text-gray-500 mt-1">
                    Belum ada data realisasi program kerja pada periode aktif.
                  </p>

                </div>

              </td>
            </tr>

            @endforelse

          </tbody>

        </table>

      </div>
    </div>

    {{-- PAGINATION --}}
    @if(method_exists($data, 'links'))

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
      {{ $data->links() }}
    </div>

    @endif

  </div>

</x-app-layout>