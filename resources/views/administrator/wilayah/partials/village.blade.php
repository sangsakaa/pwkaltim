<x-app-layout>

  <div class="space-y-6 p-4">

    {{-- BREADCRUMB --}}
    <div class="text-sm text-gray-500">
      <x-breadcrumb-wilayah
        :province="$province ?? null"
        :regency="$regency"
        :district="$district" />
    </div>

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-blue-600 to-indigo-500 text-white rounded-xl p-6 shadow">

      <div class="flex items-start justify-between gap-4">

        <div>

          <h1 class="text-xl md:text-2xl font-bold">
            Desa di {{ $district->name }}
            <span class="text-blue-100 font-normal">
              ({{ $district->code }})
            </span>
          </h1>

          <p class="text-sm text-blue-100 mt-1">
            Kecamatan: {{ $district->name }} | Kabupaten: {{ $regency->name }}
          </p>

        </div>

        {{-- BACK BUTTON --}}
        <a href="{{ route('wilayah.regency', $regency->code) }}"
          class="px-4 py-2 text-sm bg-white text-blue-700 rounded-lg shadow hover:bg-gray-100 transition whitespace-nowrap">
          ← Kembali
        </a>

      </div>

    </div>

    {{-- TABLE CARD --}}
    <div class="bg-white rounded-xl shadow border overflow-hidden">

      {{-- TABLE HEADER --}}
      <div class="flex items-center justify-between px-5 py-4 border-b bg-gray-50">

        <h2 class="font-semibold text-gray-700">
          Daftar Desa
        </h2>

        <span class="text-xs text-gray-500">
          Total: {{ count($villages) }}
        </span>

      </div>

      {{-- TABLE --}}
      <div class="overflow-x-auto">

        <table class="min-w-full text-sm text-left">

          <thead class="bg-gray-100 text-gray-700">
            <tr>
              <th class="px-4 py-3 w-12">No</th>
              <th class="px-4 py-3">Nama Desa</th>
              <th class="px-4 py-3">Kode</th>
            </tr>
          </thead>

          <tbody class="divide-y">

            @forelse ($villages as $index => $village)
            <tr class="hover:bg-gray-50 transition">

              <td class="px-4 py-3 text-gray-500">
                {{ $index + 1 }}
              </td>

              <td class="px-4 py-3 font-medium text-gray-800">
                {{ $village->name }}
              </td>

              <td class="px-4 py-3 text-gray-500">
                {{ $village->code }}
              </td>

            </tr>
            @empty
            <tr>
              <td colspan="3" class="text-center py-10 text-gray-500">
                Tidak ada data desa
              </td>
            </tr>
            @endforelse

          </tbody>

        </table>

      </div>

    </div>

  </div>

</x-app-layout>