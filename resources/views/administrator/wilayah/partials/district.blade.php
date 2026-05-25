<x-app-layout>

  <div class="space-y-6 p-4">

    {{-- BREADCRUMB --}}
    <div class="text-sm text-gray-500">
      <x-breadcrumb-wilayah
        :province="$province ?? null"
        :regency="$regency ?? null" />
    </div>

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-blue-600 to-indigo-500 text-white rounded-xl p-6 shadow">

      <div class="flex items-start justify-between gap-4">

        <div>
          <h1 class="text-xl md:text-2xl font-bold">
            Kecamatan di {{ $regency->name ?? '-' }}
          </h1>

          <p class="text-sm text-blue-100 mt-1">
            Kabupaten/Kota:
            {{ $regency->name ?? '-' }}
            ({{ $regency->code ?? '-' }})
          </p>
        </div>

        {{-- BACK --}}
        <a href="{{ route('wilayah.province', [
                    'province' => $province->code
                ]) }}"
          class="px-4 py-2 text-sm bg-white text-blue-700 rounded-lg shadow hover:bg-gray-100 transition whitespace-nowrap">
          ← Kembali
        </a>

      </div>

    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow border overflow-hidden">

      <div class="flex items-center justify-between px-5 py-4 border-b bg-gray-50">
        <h2 class="font-semibold text-gray-700">
          Daftar Kecamatan
        </h2>

        <span class="text-xs text-gray-500">
          Total: {{ $districts->count() }}
        </span>
      </div>

      <div class="overflow-x-auto">

        <table class="min-w-full text-sm text-left">

          <thead class="bg-gray-100 text-gray-700">
            <tr>
              <th class="px-4 py-3 w-12">No</th>
              <th class="px-4 py-3">Nama Kecamatan</th>
              <th class="px-4 py-3">Kode</th>
              <th class="px-4 py-3 text-right">Aksi</th>
            </tr>
          </thead>

          <tbody class="divide-y">

            @forelse ($districts as $index => $district)
            <tr class="hover:bg-gray-50 transition">

              <td class="px-4 py-3 text-gray-500">
                {{ $index + 1 }}
              </td>

              <td class="px-4 py-3 font-medium text-gray-800">
                {{ $district->name ?? '-' }}
              </td>

              <td class="px-4 py-3 text-gray-500">
                {{ $district->code ?? '-' }}
              </td>

              <td class="px-4 py-3 text-right">

                <a href="{{ route('wilayah.district', [
                                        'province' => $province->code,
                                        'regency' => $regency->code,
                                        'district' => $district->code,
                                    ]) }}"
                  class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition shadow-sm">

                  Lihat Desa →
                </a>

              </td>

            </tr>
            @empty
            <tr>
              <td colspan="4"
                class="text-center py-10 text-gray-500">
                Tidak ada data kecamatan
              </td>
            </tr>
            @endforelse

          </tbody>

        </table>

      </div>
    </div>
  </div>

</x-app-layout>