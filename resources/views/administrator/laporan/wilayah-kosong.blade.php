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
    <h2 class="text-xl font-bold text-gray-800">
      Wilayah Belum Ada Pengamal -
      <span class="text-red-700">
        {{ $wilayah }}
      </span>
    </h2>
  </x-slot>

  <div class="space-y-5">

    {{-- HERO --}}
    <div class="bg-gradient-to-r from-green-700 to-green-500 text-white rounded-xl shadow-lg p-5 flex gap-4 items-center">

      <img
        src="{{ asset('image/logo.png') }}"
        class="w-12 h-12  p-1">

      <div>
        <h3 class="font-bold text-lg uppercase">
          {{ $wilayah }}
        </h3>

        <p class="text-sm text-red-100">
          Monitoring wilayah yang belum memiliki data pengamal
        </p>
      </div>

    </div>

    {{-- NOTE --}}
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5">

      <h3 class="font-bold text-yellow-800">
        Informasi Data
      </h3>

      <div class="text-sm text-yellow-700 mt-2 leading-7">

        <p>
          Halaman ini menampilkan wilayah yang
          <span class="font-semibold">
            belum memiliki data pengamal
          </span>
          berdasarkan hak akses akun login.
        </p>

        <ul class="list-disc ml-5 mt-2 space-y-1">

          <li>
            <strong>Admin Provinsi / Super Admin</strong>
            melihat semua kabupaten, kecamatan dan desa kosong.
          </li>

          <li>
            <strong>Admin Kabupaten</strong>
            hanya melihat kecamatan dan desa kosong
            pada wilayah kabupatennya.
          </li>

          <li>
            Data dikelompokkan berdasarkan
            <strong>Kabupaten → Kecamatan → Desa</strong>.
          </li>

        </ul>

      </div>

    </div>
    {{-- DATA --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

      {{-- HEADER --}}
      <div class="px-5 py-4 border-b bg-gray-50">
        <div class="flex items-center justify-between flex-wrap gap-3">

          <div>
            <h3 class="font-bold text-lg text-gray-800">
              Daftar Wilayah Kosong
            </h3>

            <p class="text-sm text-gray-500">
              Kecamatan dan desa yang belum memiliki pengamal
            </p>
          </div>

          <span class="text-xs px-3 py-1 rounded-full bg-red-100 text-red-700 font-medium">
            {{ count($wilayahKosong) }} Kabupaten
          </span>
        </div>
      </div>

      @if(empty($wilayahKosong) || count($wilayahKosong) === 0)

      <div class="p-10 text-center">

        <div class="text-5xl mb-3">
          ✅
        </div>

        <h3 class="font-semibold text-gray-700">
          Semua wilayah sudah memiliki pengamal
        </h3>

        <p class="text-sm text-gray-500 mt-1">
          Tidak ditemukan wilayah kosong
        </p>

      </div>

      @else

      {{-- Wrapper scroll internal --}}
      <div class="max-h-[70vh] overflow-y-auto divide-y">

        @foreach($wilayahKosong as $kabupaten => $data)

        <details class="group">

          {{-- HEADER KABUPATEN --}}
          <summary
            class="sticky top-0 z-10 list-none cursor-pointer select-none bg-white hover:bg-gray-50 transition px-5 py-4 flex items-center justify-between border-b">

            <div>

              <h3 class="font-semibold text-red-700">
                {{ $kabupaten }}
              </h3>

              <p class="text-xs text-gray-500 mt-1">
                {{ count($data['kecamatan']) }}
                kecamatan belum memiliki pengamal
              </p>

            </div>

            <div class="flex items-center gap-3">

              <span class="text-xs bg-red-100 text-red-700 px-3 py-1 rounded-full font-medium">
                {{ count($data['kecamatan']) }}
              </span>

              <svg
                class="w-5 h-5 text-gray-500 transition-transform duration-300 group-open:rotate-180"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24">

                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M19 9l-7 7-7-7" />
              </svg>

            </div>
          </summary>

          {{-- BODY --}}
          <div class="p-5 bg-gray-50">

            @if(count($data['kecamatan']) === 0)

            <div class="text-sm italic text-gray-500">
              Tidak ada kecamatan kosong
            </div>

            @else

            <div class="grid gap-3">

              @foreach($data['kecamatan'] as $kecamatan)

              <div class="bg-white border rounded-xl p-4">

                {{-- Kecamatan --}}
                <div class="flex items-center justify-between mb-3">

                  <h4 class="font-medium text-gray-800">
                    📍 Kecamatan
                    {{ $kecamatan['nama'] }}
                  </h4>

                  <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded-full">
                    {{ count($kecamatan['desa']) }}
                    desa
                  </span>

                </div>

                {{-- Desa --}}
                @if(count($kecamatan['desa']) === 0)

                <span class="text-xs text-green-600 italic">
                  Semua desa sudah memiliki pengamal
                </span>

                @else

                <div class="flex flex-wrap gap-2">

                  @foreach($kecamatan['desa'] as $desa)

                  <span class="px-2 py-1 rounded-lg text-xs bg-red-50 border border-red-100 text-red-700">
                    {{ $desa }}
                  </span>

                  @endforeach

                </div>

                @endif

              </div>

              @endforeach

            </div>

            @endif

          </div>

        </details>

        @endforeach

      </div>

      @endif

    </div>
  </div>

</x-app-layout>