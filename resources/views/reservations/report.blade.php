<x-app-layout>
  <x-slot name="header">
    <div class="flex flex-col gap-1">
      <h2 class="text-2xl font-bold text-slate-800">
        Laporan Data Reservasi
      </h2>
      <p class="text-sm text-slate-500">
        Rekap peserta berdasarkan ketua rombongan dan wilayah.
      </p>
    </div>
  </x-slot>

  <div class="py-8">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

      @php
      $totalBapak = $reservations->sum('total_father');
      $totalIbu = $reservations->sum('total_mother');
      $totalRemaja = $reservations->sum('total_teenager');
      $totalAnak = $reservations->sum('total_child');
      $totalPeserta = $reservations->sum('total_participant');
      @endphp

      {{-- Ringkasan --}}
      <div class="grid grid-cols-2 gap-4 md:grid-cols-4 mb-6">
        <div class="rounded-xl bg-white p-5 shadow">
          <p class="text-sm text-slate-500">Jumlah Rombongan</p>
          <p class="mt-2 text-2xl font-bold text-slate-800">
            {{ $reservations->count() }}
          </p>
        </div>

        <div class="rounded-xl bg-white p-5 shadow">
          <p class="text-sm text-slate-500">Total Bapak</p>
          <p class="mt-2 text-2xl font-bold text-blue-600">
            {{ number_format($totalBapak) }}
          </p>
        </div>

        <div class="rounded-xl bg-white p-5 shadow">
          <p class="text-sm text-slate-500">Total Ibu</p>
          <p class="mt-2 text-2xl font-bold text-pink-600">
            {{ number_format($totalIbu) }}
          </p>
        </div>

        <div class="rounded-xl bg-white p-5 shadow">
          <p class="text-sm text-slate-500">Total Remaja</p>
          <p class="mt-2 text-2xl font-bold text-emerald-600">
            {{ number_format($totalRemaja) }}
          </p>
        </div>
      </div>

      {{-- Tombol --}}
      <div class="mb-4 flex flex-wrap gap-3 print:hidden">
        <button
          onclick="window.print()"
          class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
          Cetak Laporan
        </button>

        <a href="{{ route('reservasi.report') }}"
          class="rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
          Muat Ulang
        </a>
      </div>

      {{-- Tabel --}}
      <div class="overflow-x-auto rounded-xl bg-white shadow">
        <table class="w-full border-collapse text-sm">
          <thead class="bg-slate-800 text-white">
            <tr>
              <th class="border px-3 py-3 text-center">No.</th>
              <th class="border px-3 py-3 text-left">
                Ketua Rombongan
              </th>
              <th class="border px-3 py-3 text-center">Bapak</th>
              <th class="border px-3 py-3 text-center">Ibu</th>
              <th class="border px-3 py-3 text-center">Remaja</th>
              <th class="border px-3 py-3 text-center">Anak</th>
              <th class="border px-3 py-3 text-left">Provinsi</th>
              <th class="border px-3 py-3 text-left">
                Kabupaten/Kota
              </th>
              <th class="border px-3 py-3 text-center">
                Total Peserta
              </th>
            </tr>
          </thead>

          <tbody>
            @forelse ($reservations as $reservation)
            <tr class="hover:bg-slate-50">
              <td class="border px-3 py-3 text-center">
                {{ $loop->iteration }}
              </td>

              <td class="border px-3 py-3 font-medium">
                {{ $reservation->ketua_rombongan ?: '-' }}
              </td>

              <td class="border px-3 py-3 text-center">
                {{ $reservation->total_father ?? 0 }}
              </td>

              <td class="border px-3 py-3 text-center">
                {{ $reservation->total_mother ?? 0 }}
              </td>

              <td class="border px-3 py-3 text-center">
                {{ $reservation->total_teenager ?? 0 }}
              </td>

              <td class="border px-3 py-3 text-center">
                {{ $reservation->total_child ?? 0 }}
              </td>

              <td class="border px-3 py-3">
                {{ $reservation->regency?->province?->name ?? '-' }}
              </td>

              <td class="border px-3 py-3">
                {{ $reservation->regency?->name ?? '-' }}
              </td>

              <td class="border px-3 py-3 text-center font-bold">
                {{ $reservation->total_participant ?? 0 }}
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="9"
                class="border px-4 py-10 text-center text-slate-500">
                Belum ada data reservasi.
              </td>
            </tr>
            @endforelse
          </tbody>

          <tfoot class="bg-slate-100 font-bold">
            <tr>
              <td colspan="2" class="border px-3 py-3 text-right">
                TOTAL
              </td>
              <td class="border px-3 py-3 text-center">
                {{ number_format($totalBapak) }}
              </td>
              <td class="border px-3 py-3 text-center">
                {{ number_format($totalIbu) }}
              </td>
              <td class="border px-3 py-3 text-center">
                {{ number_format($totalRemaja) }}
              </td>
              <td class="border px-3 py-3 text-center">
                {{ number_format($totalAnak) }}
              </td>
              <td colspan="2" class="border px-3 py-3 text-right">
                {{ $reservations->count() }} rombongan
              </td>
              <td class="border px-3 py-3 text-center">
                {{ number_format($totalPeserta) }}
              </td>
            </tr>
          </tfoot>
        </table>
      </div>

    </div>
  </div>

  <style>
    @media print {
      body {
        background: white !important;
      }

      nav,
      header button,
      .print\:hidden {
        display: none !important;
      }

      .shadow {
        box-shadow: none !important;
      }

      table {
        width: 100%;
        font-size: 10px !important;
      }

      th,
      td {
        padding: 5px !important;
      }

      @page {
        size: landscape;
        margin: 10mm;
      }
    }
  </style>
</x-app-layout>