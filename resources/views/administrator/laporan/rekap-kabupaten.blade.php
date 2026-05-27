@php
use Illuminate\Support\Str;

$user = auth()->user();

$wilayah = 'Tidak diketahui';

if ($user->regency?->name) {

$wilayah = Str::startsWith($user->regency->name, 'Kab.')
? 'Kabupaten ' . ltrim(substr($user->regency->name, 4))
: $user->regency->name;

} elseif ($user->district?->name) {

$wilayah = 'Kecamatan ' . $user->district->name;

} elseif ($user->village?->name) {

$wilayah = $user->village->name;

} elseif ($user->province?->name) {

$wilayah = $user->province->name;
}
@endphp

<x-app-layout>

  {{-- HEADER --}}
  <x-slot name="header">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
      <h2 class="text-xl font-bold text-gray-800">
        Rekap Kabupaten -
        <span class="text-green-700">
          {{ $wilayah }}
        </span>
      </h2>
    </div>
  </x-slot>

  <div class="space-y-4">

    {{-- HERO CARD --}}
    <div class="bg-gradient-to-r from-green-800 to-green-600 text-white rounded-xl shadow-lg p-4 flex items-center gap-4">

      <img
        src="{{ asset('image/logo.png') }}"
        class="w-12 h-12 rounded-full p-1">

      <div>
        <h3 class="text-lg font-bold uppercase">
          {{ $wilayah }}
        </h3>

        <p class="text-sm text-green-100">
          Rekap Data Pengamal Berdasarkan Kabupaten
        </p>
      </div>
    </div>

    {{-- TOOLBAR --}}
    <div class="bg-white rounded-xl shadow p-4 border border-gray-100">

      <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">

        <div class="flex flex-wrap gap-2">

          <a
            href="{{ route('laporan-file.index') }}"
            class="bg-gray-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-700 transition">

            Kembali
          </a>

          <a
            href="#"
            class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-700 transition">

            Export PDF
          </a>

        </div>

        <div>
          <span class="text-sm text-gray-500">
            Total Kabupaten:
            <span class="font-semibold text-green-700">
              {{ $rekap->count() }}
            </span>
          </span>
        </div>

      </div>

    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow overflow-hidden border border-gray-100">

      <div class="p-4 border-b">

        <h3 class="text-lg font-bold text-gray-700">
          Rekap Kategori Pengamal Kabupaten
        </h3>

        <p class="text-sm text-gray-500">
          Data berdasarkan kategori usia dan jenis kelamin
        </p>

      </div>

      <div class="overflow-x-auto">

        <table class="min-w-full text-sm">

          <thead class="bg-green-900 text-white">

            <tr>

              <th class="px-4 py-3 text-center">
                No
              </th>

              <th class="px-4 py-3 text-left">
                Kabupaten
              </th>

              <th class="px-4 py-3 text-center">
                Kanak-kanak
              </th>

              <th class="px-4 py-3 text-center">
                Remaja
              </th>

              <th class="px-4 py-3 text-center">
                Bapak-bapak
              </th>

              <th class="px-4 py-3 text-center">
                Ibu-ibu
              </th>

              <th class="px-4 py-3 text-center">
                Tidak diketahui
              </th>

              <th class="px-4 py-3 text-center">
                Total
              </th>

            </tr>

          </thead>

          <tbody class="divide-y divide-gray-200">

            @forelse ($rekap as $item)

            <tr class="hover:bg-green-50 transition">

              <td class="px-4 py-3 text-center">
                {{ $loop->iteration }}
              </td>

              <td class="px-4 py-3 font-medium text-gray-800">
                {{ $item['kabupaten'] }}
              </td>

              <td class="px-4 py-3 text-center">
                {{ number_format($item['kanak_kanak']) }}
              </td>

              <td class="px-4 py-3 text-center">
                {{ number_format($item['remaja']) }}
              </td>

              <td class="px-4 py-3 text-center">
                {{ number_format($item['bapak_bapak']) }}
              </td>

              <td class="px-4 py-3 text-center">
                {{ number_format($item['ibu_ibu']) }}
              </td>

              <td class="px-4 py-3 text-center text-gray-500">
                {{ number_format($item['tidak_diketahui']) }}
              </td>

              <td class="px-4 py-3 text-center font-bold text-green-700">
                {{ number_format($item['total']) }}
              </td>

            </tr>

            @empty

            <tr>
              <td
                colspan="8"
                class="text-center py-8 text-gray-500">

                Tidak ada data

              </td>
            </tr>

            @endforelse

          </tbody>

          {{-- FOOTER TOTAL --}}
          <tfoot class="bg-gray-100 font-bold border-t">

            <tr>

              <td
                colspan="2"
                class="px-4 py-4 text-center">

                TOTAL
              </td>

              <td class="px-4 py-4 text-center">
                {{ number_format($rekap->sum('kanak_kanak')) }}
              </td>

              <td class="px-4 py-4 text-center">
                {{ number_format($rekap->sum('remaja')) }}
              </td>

              <td class="px-4 py-4 text-center">
                {{ number_format($rekap->sum('bapak_bapak')) }}
              </td>

              <td class="px-4 py-4 text-center">
                {{ number_format($rekap->sum('ibu_ibu')) }}
              </td>

              <td class="px-4 py-4 text-center">
                {{ number_format($rekap->sum('tidak_diketahui')) }}
              </td>

              <td class="px-4 py-4 text-center text-green-700">
                {{ number_format($rekap->sum('total')) }}
              </td>

            </tr>

          </tfoot>

        </table>

      </div>

    </div>

  </div>

</x-app-layout>