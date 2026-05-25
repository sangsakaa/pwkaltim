<x-app-layout>

  <div class="space-y-6 p-4">

    {{-- BREADCRUMB --}}
    <div class="text-sm text-gray-500">
      <x-breadcrumb-wilayah :province="$province ?? null" />
    </div>

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-green-600 to-emerald-500 text-white rounded-xl p-6 shadow">

      <div class="flex items-center justify-between gap-4">

        <div>
          <h1 class="text-xl md:text-2xl font-bold">
            {{ $province->name ?? 'Provinsi Tidak Ditemukan' }}
          </h1>

          <p class="text-sm text-green-100 mt-1">
            Daftar Kabupaten / Kota di {{ $province->name ?? '-' }}
          </p>
        </div>

        {{-- BACK BUTTON --}}
        <a href="{{ route('wilayah.index') }}"
          class="px-4 py-2 text-sm bg-white text-green-700 rounded-lg shadow hover:bg-gray-100 transition whitespace-nowrap">
          ← Kembali
        </a>

      </div>

    </div>

    {{-- TABLE CARD --}}
    <div class="bg-white rounded-xl shadow border overflow-hidden">

      {{-- TABLE HEADER --}}
      <div class="flex items-center justify-between px-5 py-4 border-b bg-gray-50">

        <h2 class="font-semibold text-gray-700">
          Daftar Kabupaten / Kota
        </h2>

        <span class="text-xs text-gray-500">
          Total: {{ $regencies->count() }}
        </span>

      </div>

      {{-- TABLE --}}
      <div class="overflow-x-auto">

        <table class="min-w-full text-sm text-left">

          <thead class="bg-gray-100 text-gray-700">
            <tr>
              <th class="px-4 py-3 w-12">No</th>
              <th class="px-4 py-3">Nama Kabupaten / Kota</th>
              <th class="px-4 py-3">Kode</th>
              <th class="px-4 py-3 text-right">Aksi</th>
            </tr>
          </thead>

          <tbody class="divide-y">

            @forelse ($regencies as $index => $regency)
            <tr class="hover:bg-gray-50 transition">

              <td class="px-4 py-3 text-gray-500">
                {{ $index + 1 }}
              </td>

              <td class="px-4 py-3 font-medium text-gray-800">
                {{ $regency->name ?? '-' }}
              </td>

              <td class="px-4 py-3 text-gray-500">
                {{ $regency->code ?? '-' }}
              </td>

              <td class="px-4 py-3 text-right">
                <a href="{{ route('wilayah.regency', [
    'province' => $province->code,
    'regency'  => $regency->code
]) }}">
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