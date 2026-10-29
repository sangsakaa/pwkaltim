<x-app-layout>
  <x-slot name="header">
    <div>
      <h2 class="text-2xl font-bold text-slate-800">
        Laporan Pendaftaran Rombongan
      </h2>
      <p class="text-sm text-slate-500">
        Rekap ketua rombongan dan jumlah peserta berdasarkan wilayah.
      </p>
    </div>
  </x-slot>

  <div class="py-8">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

      {{-- Ringkasan --}}
      <div class="mb-6 grid grid-cols-2 gap-4 md:grid-cols-5 print:hidden">
        <div class="rounded-xl bg-white p-4 shadow">
          <p class="text-sm text-slate-500">Rombongan</p>
          <p class="text-2xl font-bold">
            {{ $reservations->count() }}
          </p>
        </div>

        <div class="rounded-xl bg-white p-4 shadow">
          <p class="text-sm text-slate-500">Bapak</p>
          <p class="text-2xl font-bold text-blue-600">
            {{ number_format($totalBapak) }}
          </p>
        </div>

        <div class="rounded-xl bg-white p-4 shadow">
          <p class="text-sm text-slate-500">Ibu</p>
          <p class="text-2xl font-bold text-pink-600">
            {{ number_format($totalIbu) }}
          </p>
        </div>

        <div class="rounded-xl bg-white p-4 shadow">
          <p class="text-sm text-slate-500">Remaja</p>
          <p class="text-2xl font-bold text-emerald-600">
            {{ number_format($totalRemaja) }}
          </p>
        </div>

        <div class="rounded-xl bg-white p-4 shadow">
          <p class="text-sm text-slate-500">Total Peserta</p>
          <p class="text-2xl font-bold text-indigo-600">
            {{ number_format($totalPeserta) }}
          </p>
        </div>
      </div>

      {{-- Tombol --}}
      <div class="mb-4 flex gap-3 print:hidden">

        <a href="{{ route('reservasi.report.pdf') }}"
          class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2
          text-sm font-semibold text-white hover:bg-red-700">
          Unduh Laporan PDF
        </a>

      </div>

      {{-- Tabel laporan --}}
      <div class="overflow-x-auto rounded-xl bg-white shadow print:overflow-visible print:shadow-none">
        <table class="w-full border-collapse text-sm">
          <thead class="bg-slate-800 text-white print:bg-white print:text-black">
            <tr>
              <th class="border px-3 py-3">No.</th>
              <th class="border px-3 py-3 text-left">
                Ketua Rombongan
              </th>
              <th class="border px-3 py-3">Bapak</th>
              <th class="border px-3 py-3">Ibu</th>
              <th class="border px-3 py-3">Remaja</th>
              <th class="border px-3 py-3">Anak</th>
              <th class="border px-3 py-3 text-left">Provinsi</th>
              <th class="border px-3 py-3 text-left">
                Kabupaten/Kota
              </th>
              <th class="border px-3 py-3">Total Peserta</th>
            </tr>
          </thead>

          <tbody>
            @forelse ($reservations as $reservation)
            <tr class="hover:bg-slate-50">
              <td class="border px-3 py-2 text-center">
                {{ $loop->iteration }}
              </td>

              <td class="border px-3 py-2">
                {{ $reservation->ketua_rombongan ?: '-' }}
              </td>

              <td class="border px-3 py-2 text-center">
                {{ $reservation->total_father ?? 0 }}
              </td>

              <td class="border px-3 py-2 text-center">
                {{ $reservation->total_mother ?? 0 }}
              </td>

              <td class="border px-3 py-2 text-center">
                {{ $reservation->total_teenager ?? 0 }}
              </td>

              <td class="border px-3 py-2 text-center">
                {{ $reservation->total_child ?? 0 }}
              </td>

              <td class="border px-3 py-2">
                {{ $reservation->regency?->province?->name ?? '-' }}
              </td>

              <td class="border px-3 py-2">
                {{ $reservation->regency?->name ?? '-' }}
              </td>

              <td class="border px-3 py-2 text-center font-bold">
                {{ $reservation->total_participant
                                        ?? (
                                            ($reservation->total_father ?? 0) +
                                            ($reservation->total_mother ?? 0) +
                                            ($reservation->total_teenager ?? 0) +
                                            ($reservation->total_child ?? 0)
                                        )
                                    }}
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="9"
                class="border px-4 py-8 text-center text-slate-500">
                Belum ada data reservasi.
              </td>
            </tr>
            @endforelse
          </tbody>

          <tfoot class="bg-slate-100 font-bold print:bg-white">
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
      @page {
        size: landscape;
        margin: 10mm;
      }

      body {
        background: white !important;
      }

      nav,
      .print\:hidden {
        display: none !important;
      }

      .max-w-7xl {
        max-width: none !important;
      }

      table {
        width: 100%;
        font-size: 10px !important;
      }

      th,
      td {
        padding: 5px !important;
      }

      tr {
        break-inside: avoid;
      }
    }
  </style>
</x-app-layout>