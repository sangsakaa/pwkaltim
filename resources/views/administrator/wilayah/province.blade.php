<x-app-layout>

  <div class="p-6 space-y-6">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-green-600 to-emerald-500 text-white rounded-xl p-6 shadow-md">

      <h1 class="text-2xl font-bold">
        Daftar Kabupaten / Kota
      </h1>

      <p class="text-sm text-green-100 mt-1">
        Provinsi: {{ $province->name }}
      </p>

    </div>

    {{-- TABLE CARD --}}
    <div class="bg-white rounded-xl shadow border overflow-hidden">

      {{-- TABLE HEADER --}}
      <div class="flex items-center justify-between px-5 py-4 border-b bg-gray-50">

        <h2 class="font-semibold text-gray-700">
          Data Kabupaten / Kota
        </h2>

        <span class="text-xs text-gray-500">
          Total: {{ $kab->count() }}
        </span>

      </div>

      {{-- TABLE --}}
      <div class="overflow-x-auto">

        <table class="min-w-full text-sm">

          <thead class="bg-gray-100 text-gray-700">
            <tr>
              <th class="px-4 py-3 text-left w-12">
                No
              </th>

              <th class="px-4 py-3 text-left">
                Nama Kabupaten / Kota
              </th>

              <th class="px-4 py-3 text-left">
                Kode
              </th>

              <th class="px-4 py-3 text-right">
                Aksi
              </th>
            </tr>
          </thead>

          <tbody class="divide-y divide-gray-100">

            @forelse($kab as $index => $item)
            <tr class="hover:bg-green-50 transition">

              <td class="px-4 py-3 text-gray-500">
                {{ $index + 1 }}
              </td>

              <td class="px-4 py-3 font-medium text-gray-800">
                {{ $item->name }}
              </td>

              <td class="px-4 py-3 text-gray-500">
                {{ $item->code }}
              </td>

              <td class="px-4 py-3 text-right">
                <a href="{{ route('wilayah.show', $item->code) }}"
                  class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition shadow-sm">

                  Lihat Kecamatan →
                </a>
              </td>

            </tr>

            @empty

            <tr>
              <td colspan="4" class="text-center py-10 text-gray-500">
                Tidak ada data kabupaten / kota
              </td>
            </tr>

            @endforelse

          </tbody>

        </table>

      </div>

    </div>

  </div>

</x-app-layout>