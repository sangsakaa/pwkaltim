@php
$user = auth()->user();

$isKabupaten = $user->hasRole('admin-kabupaten');
$isKecamatan = $user->hasRole('admin-kecamatan');
$isDesa = $user->hasRole('admin-desa');

/*
|--------------------------------------------------------------------------
| WILAYAH USER
|--------------------------------------------------------------------------
*/
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

/*
|--------------------------------------------------------------------------
| SELECTED FILTER
|--------------------------------------------------------------------------
*/
$selectedKabupaten = old('kabupaten', request('kabupaten') ?? $user->kabupaten);
$selectedKecamatan = old('kecamatan', request('kecamatan') ?? $user->kecamatan);
$selectedDesa = old('desa', request('desa') ?? $user->desa);
@endphp

<x-app-layout>

  {{-- HEADER --}}
  <x-slot name="header">
    <div class="flex flex-col gap-1">
      <h2 class="text-2xl font-bold text-gray-800">
        Download Laporan
      </h2>

      <p class="text-sm text-gray-500">
        Wilayah:
        <span class="font-semibold text-green-700">
          {{ $wilayah }}
        </span>
      </p>
    </div>
  </x-slot>

  <div class="space-y-6">

    {{-- HERO --}}
    <div class="rounded-3xl bg-gradient-to-r from-green-800 to-green-600 shadow-lg overflow-hidden">

      <div class="flex flex-col sm:flex-row items-center gap-5 p-6 text-white">

        <div class="shrink-0">
          <img
            src="{{ asset('image/logo.png') }}"
            alt="Logo"
            class="w-16 h-16 rounded-2xl p-2 shadow-md">
        </div>

        <div class="text-center sm:text-left">
          <h3 class="text-xl md:text-2xl font-bold uppercase">
            {{ $wilayah }}
          </h3>

          <p class="text-green-100 text-sm mt-1">
            Download laporan pengamal berdasarkan wilayah
          </p>
        </div>

      </div>
    </div>

    {{-- FILTER CARD --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

      <div class="border-b px-6 py-5">
        <h3 class="text-lg font-bold text-gray-800">
          Filter Wilayah Laporan
        </h3>

        <p class="text-sm text-gray-500 mt-1">
          Pilih wilayah untuk mengunduh laporan PDF
        </p>
      </div>

      <div class="p-6">

        <form
          action="{{ route('laporan.download') }}"
          method="GET"
          target="_blank">

          <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

            {{-- KABUPATEN --}}
            <div>
              <label
                for="kabupaten"
                class="block mb-2 text-sm font-semibold text-gray-700">
                Kabupaten
              </label>

              <select
                name="kabupaten"
                id="kabupaten"
                class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-green-600 focus:border-green-600"
                {{ ($isKabupaten || $isKecamatan || $isDesa) ? 'disabled' : '' }}>

                <option value="">
                  Semua Kabupaten
                </option>

                @foreach ($kabupaten as $item)
                <option
                  value="{{ $item->code }}"
                  @selected($selectedKabupaten==$item->code)>
                  {{ $item->name }}
                </option>
                @endforeach
              </select>

              @if ($isKabupaten || $isKecamatan || $isDesa)
              <input
                type="hidden"
                name="kabupaten"
                value="{{ $selectedKabupaten }}">
              @endif
            </div>

            {{-- KECAMATAN --}}
            <div>
              <label
                for="kecamatan"
                class="block mb-2 text-sm font-semibold text-gray-700">
                Kecamatan
              </label>

              <select
                name="kecamatan"
                id="kecamatan"
                class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-green-600 focus:border-green-600"
                {{ ($isKecamatan || $isDesa) ? 'disabled' : '' }}>

                <option value="">
                  Semua Kecamatan
                </option>

                @foreach ($kecamatan as $item)
                <option
                  value="{{ $item->code }}"
                  data-kabupaten="{{ substr($item->code, 0, 5) }}"
                  @selected($selectedKecamatan==$item->code)>
                  {{ $item->name }}
                </option>
                @endforeach
              </select>

              @if ($isKecamatan || $isDesa)
              <input
                type="hidden"
                name="kecamatan"
                value="{{ $selectedKecamatan }}">
              @endif
            </div>

            {{-- DESA --}}
            <div>
              <label
                for="desa"
                class="block mb-2 text-sm font-semibold text-gray-700">
                Desa
              </label>

              <select
                name="desa"
                id="desa"
                class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-green-600 focus:border-green-600"
                {{ $isDesa ? 'disabled' : '' }}>

                <option value="">
                  Semua Desa
                </option>

                @foreach ($desa as $item)
                <option
                  value="{{ $item->code }}"
                  data-kecamatan="{{ substr($item->code, 0, 8) }}"
                  @selected($selectedDesa==$item->code)>
                  {{ $item->name }}
                </option>
                @endforeach
              </select>

              @if ($isDesa)
              <input
                type="hidden"
                name="desa"
                value="{{ $selectedDesa }}">
              @endif
            </div>

          </div>

          {{-- ACTION BUTTON --}}
          <div class="flex flex-wrap gap-3 mt-8">

            <button
              type="submit"
              class="inline-flex items-center justify-center px-5 py-3 rounded-xl bg-red-600 text-white text-sm font-semibold shadow hover:bg-red-700 transition">
              Download PDF
            </button>

            <a
              href="{{ route('laporan-file.index') }}"
              class="inline-flex items-center justify-center px-5 py-3 rounded-xl bg-gray-600 text-white text-sm font-semibold shadow hover:bg-gray-700 transition">
              Reset Filter
            </a>

          </div>

        </form>
      </div>
    </div>

    {{-- EXPORT KATEGORI --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

      <div class="mb-5">
        <h3 class="text-lg font-bold text-gray-800">
          Export Berdasarkan Kategori
        </h3>

        <p class="text-sm text-gray-500">
          Download laporan kategori pengamal
        </p>
      </div>

      <div class="flex flex-wrap gap-3">

        <a
          href="{{ route('laporan.export-kategori', 'kanak-kanak') }}"
          target="_blank"
          class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-medium hover:opacity-90 transition">
          Export Kanak-kanak
        </a>

        <a
          href="{{ route('laporan.export-kategori', 'remaja') }}"
          target="_blank"
          class="px-4 py-2 rounded-xl bg-green-600 text-white text-sm font-medium hover:opacity-90 transition">
          Export Remaja
        </a>

        <a
          href="{{ route('laporan.export-kategori', 'bapak-bapak') }}"
          target="_blank"
          class="px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm font-medium hover:opacity-90 transition">
          Export Bapak-bapak
        </a>

        <a
          href="{{ route('laporan.export-kategori', 'ibu-ibu') }}"
          target="_blank"
          class="px-4 py-2 rounded-xl bg-pink-600 text-white text-sm font-medium hover:opacity-90 transition">
          Export Ibu-ibu
        </a>

      </div>
    </div>

  </div>

  {{-- FILTER SCRIPT --}}
  <script>
    document.addEventListener('DOMContentLoaded', function() {

      const kabupaten = document.getElementById('kabupaten');
      const kecamatan = document.getElementById('kecamatan');
      const desa = document.getElementById('desa');

      function filterKecamatan(reset = false) {

        const selectedKabupaten = kabupaten?.value || '';

        [...kecamatan.options].forEach(option => {

          if (!option.value) return;

          const parentCode = option.dataset.kabupaten;

          option.hidden =
            selectedKabupaten &&
            parentCode !== selectedKabupaten;
        });

        if (reset) {
          kecamatan.value = '';
          desa.value = '';
        }

        filterDesa(reset);
      }

      function filterDesa(reset = false) {

        const selectedKecamatan = kecamatan?.value || '';

        [...desa.options].forEach(option => {

          if (!option.value) return;

          const parentCode = option.dataset.kecamatan;

          option.hidden =
            selectedKecamatan &&
            parentCode !== selectedKecamatan;
        });

        if (reset) {
          desa.value = '';
        }
      }

      kabupaten?.addEventListener('change', () => {
        filterKecamatan(true);
      });

      kecamatan?.addEventListener('change', () => {
        filterDesa(true);
      });

      filterKecamatan(false);
    });
  </script>

</x-app-layout>