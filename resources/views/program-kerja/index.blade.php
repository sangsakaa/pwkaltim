<x-app-layout>

  @php


  $user = auth()->user();

  $wilayah = 'Tidak diketahui';

  if ($user->regency?->name) {
  $wilayah = Str::startsWith($user->regency->name, 'Kab.')
  ? 'Kabupaten ' . ltrim(substr($user->regency->name, 4))
  : $user->regency->name;
  } elseif ($user->district?->name) {
  $wilayah = 'Kec. ' . $user->district->name;
  } elseif ($user->village?->name) {
  $wilayah = $user->village->name;
  } elseif ($user->province?->name) {
  $wilayah = $user->province->name;
  }

  $waktu = request('waktu', 'semua');
  @endphp

  <x-slot name="header">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

      <div class="flex items-center gap-3">
        <img
          src="{{ asset('image/logo.png') }}"
          alt="Logo"
          class="w-12 h-12">

        <div>
          <h2 class="text-xl font-bold text-gray-800">
            Dashboard Program Kerja
          </h2>

          <p class="text-sm text-gray-500">
            PW {{ $wilayah }}
          </p>
        </div>
      </div>

      <a
        href="{{ route('program-kerja.create') }}"
        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">
        + Tambah Program
      </a>
      <form
        action="{{ route('program-kerja.transfer-periode') }}"
        method="POST"
        onsubmit="return confirm(
        'Transfer seluruh program kerja dari periode sebelumnya ke periode aktif?'
    )">

        @csrf

        <button
          type="submit"
          class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg shadow">

          Transfer Program Tahun Sebelumnya

        </button>

      </form>

    </div>
  </x-slot>

  <div class="py-6">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

      {{-- ALERT --}}
      @if(session('success'))
      <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
        {{ session('success') }}
      </div>
      @endif

      {{-- STATISTIK --}}
      <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        <div class="bg-white rounded-xl shadow p-5">
          <p class="text-sm text-gray-500">
            Total Program Kerja
          </p>

          <h3 class="mt-2 text-3xl font-bold text-blue-600">
            {{ $data->total() }}
          </h3>
        </div>

        <div class="bg-white rounded-xl shadow p-5">
          <p class="text-sm text-gray-500">
            Periode Aktif
          </p>

          <h3 class="mt-2 font-semibold text-green-600">
            {{ $periodeAktif?->nama_periode ?? 'Belum ada periode aktif' }}
          </h3>
        </div>

        <div class="bg-white rounded-xl shadow p-5">
          <p class="text-sm text-gray-500">
            Wilayah
          </p>

          <h3 class="mt-2 font-semibold text-gray-800">
            {{ $wilayah }}
          </h3>
        </div>

      </div>

      {{-- FILTER --}}
      <div class="bg-white rounded-xl shadow p-5">

        <form
          method="GET"
          action="{{ route('program-kerja.index') }}"
          class="grid grid-cols-1 md:grid-cols-4 gap-4">

          <div class="md:col-span-2">
            <input
              type="text"
              name="q"
              value="{{ request('q') }}"
              placeholder="Cari program kerja..."
              class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
          </div>

          <div>
            <select
              name="waktu"
              class="w-full rounded-lg border-gray-300">

              <option value="semua">
                Semua Waktu
              </option>

              @foreach (['bulanan', 'triwulan', 'semester', 'tahunan'] as $item)
              <option
                value="{{ $item }}"
                @selected($waktu==$item)>
                {{ ucfirst($item) }}
              </option>
              @endforeach

            </select>
          </div>

          <button
            type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2">
            Terapkan Filter
          </button>

        </form>

      </div>

      {{-- TABEL --}}
      <div class="bg-white rounded-xl shadow overflow-hidden">

        <div class="overflow-x-auto">

          <table class="min-w-full divide-y divide-gray-200 text-sm">

            <thead class="bg-gray-50">

              <tr>
                <th class="px-4 py-3 text-left font-semibold text-gray-600">No</th>
                <th class="px-4 py-3 text-left font-semibold text-gray-600">Periode</th>
                <th class="px-4 py-3 text-left font-semibold text-gray-600">Uraian Kegiatan</th>
                <th class="px-4 py-3 text-left font-semibold text-gray-600">Waktu</th>
                <th class="px-4 py-3 text-left font-semibold text-gray-600">Penanggung Jawab</th>
                <th class="px-4 py-3 text-center font-semibold text-gray-600">Aksi</th>
              </tr>

            </thead>

            <tbody class="divide-y divide-gray-100">

              @forelse($data as $row)

              <tr class="hover:bg-gray-50">

                <td class="px-4 py-3">
                  {{ $row->nomor }}
                </td>

                <td class="px-4 py-3">
                  <span class="inline-flex px-2 py-1 rounded-full text-xs bg-green-100 text-green-700">
                    {{ $row->periodeTahunan?->nama_periode ?? '-' }}
                  </span>
                </td>

                <td class="px-4 py-3">
                  {{ $row->uraian_kegiatan }}
                </td>

                <td class="px-4 py-3 capitalize">
                  {{ $row->waktu_pelaksanaan }}
                </td>

                <td class="px-4 py-3">
                  {{ $row->penanggung_jawab }}
                </td>

                <td class="px-4 py-3">

                  <div class="flex justify-center gap-2">

                    <a
                      href="{{ route('program-kerja.show', $row) }}"
                      class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded text-xs">
                      Detail
                    </a>

                    <a
                      href="{{ route('program-kerja.edit', $row) }}"
                      class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs">
                      Edit
                    </a>

                    <form
                      method="POST"
                      action="{{ route('program-kerja.destroy', $row) }}"
                      onsubmit="return confirm('Hapus program kerja ini?')">

                      @csrf
                      @method('DELETE')

                      <button
                        type="submit"
                        class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs">
                        Hapus
                      </button>

                    </form>

                  </div>

                </td>

              </tr>

              @empty

              <tr>
                <td colspan="6" class="text-center py-10 text-gray-500">
                  Belum ada data program kerja.
                </td>
              </tr>

              @endforelse

            </tbody>

          </table>

        </div>

      </div>

      {{-- PAGINATION --}}
      <div>
        {{ $data->withQueryString()->links() }}
      </div>

    </div>

  </div>

</x-app-layout>