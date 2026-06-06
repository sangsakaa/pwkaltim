{{-- resources/views/periode-tahunan/index.blade.php --}}

<x-app-layout>

  <x-slot name="header">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

      <div>
        <h2 class="text-2xl font-bold text-gray-800">
          Periode Tahunan
        </h2>

        <p class="text-sm text-gray-500 mt-1">
          Kelola periode kepengurusan dan program kerja organisasi.
        </p>
      </div>

      
      <div class="flex gap-2">

        <form
          action="{{ route('periode-tahunan.generate') }}"
          method="POST">

          @csrf

          <button
            type="submit"
            onclick="return confirm('Generate periode tahun {{ now()->year }} ?')"
            class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg">

            Generate Tahun {{ now()->year }}
          </button>

        </form>

        <a
          href="{{ route('periode-tahunan.create') }}"
          class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">

          Tambah Periode
        </a>

      </div>

    </div>
  </x-slot>

  <div class="py-8">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

      {{-- Alert Success --}}
      @if(session('success'))
      <div class="rounded-xl border border-green-200 bg-green-50 p-4">

        <div class="flex items-center gap-3">

          <svg xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5 text-green-600"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor">

            <path stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M5 13l4 4L19 7" />
          </svg>

          <span class="text-green-700">
            {{ session('success') }}
          </span>

        </div>

      </div>
      @endif

      {{-- Statistik --}}
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div class="bg-white border rounded-xl p-5 shadow-sm">
          <p class="text-sm text-gray-500">Total Periode</p>
          <h3 class="mt-2 text-3xl font-bold text-gray-800">
            {{ $periodes->total() }}
          </h3>
        </div>

        <div class="bg-white border rounded-xl p-5 shadow-sm">
          <p class="text-sm text-gray-500">Periode Aktif</p>

          <h3 class="mt-2 text-3xl font-bold text-green-600">
            {{ $periodes->where('is_active', true)->count() }}
          </h3>
        </div>

        <div class="bg-white border rounded-xl p-5 shadow-sm">
          <p class="text-sm text-gray-500">Periode Nonaktif</p>

          <h3 class="mt-2 text-3xl font-bold text-gray-700">
            {{ $periodes->where('is_active', false)->count() }}
          </h3>
        </div>

      </div>

      {{-- Table --}}
      <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

        <div class="px-6 py-4 border-b bg-gray-50">

          <h3 class="font-semibold text-gray-800">
            Daftar Periode Tahunan
          </h3>

        </div>

        <div class="overflow-x-auto">

          <table class="min-w-full divide-y divide-gray-200">

            <thead class="bg-gray-50">

              <tr>

                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                  Nama Periode
                </th>

                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                  Tahun
                </th>

                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                  Status
                </th>

                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">
                  Aksi
                </th>

              </tr>

            </thead>

            <tbody class="divide-y divide-gray-100">

              @forelse($periodes as $periode)

              <tr class="hover:bg-gray-50 transition">

                <td class="px-6 py-4">

                  <div class="font-medium text-gray-900">
                    {{ $periode->nama_periode }}
                  </div>

                  @if($periode->tanggal_mulai)
                  <div class="text-xs text-gray-500 mt-1">
                    Mulai:
                    {{ \Carbon\Carbon::parse($periode->tanggal_mulai)->translatedFormat('d F Y') }}
                  </div>
                  @endif

                </td>

                <td class="px-6 py-4 text-gray-700">
                  {{ $periode->tahun_mulai }}
                  -
                  {{ $periode->tahun_selesai }}
                </td>

                <td class="px-6 py-4">

                  @if($periode->is_active)

                  <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">

                    <span class="w-2 h-2 bg-green-500 rounded-full"></span>

                    Aktif
                  </span>

                  @else

                  <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">

                    <span class="w-2 h-2 bg-gray-400 rounded-full"></span>

                    Tidak Aktif
                  </span>

                  @endif

                </td>

                <td class="px-6 py-4">

                  <div class="flex justify-end gap-2">

                    @if(!$periode->is_active)

                    <form
                      action="{{ route('periode-tahunan.activate', $periode->id) }}"
                      method="POST">

                      @csrf
                      @method('PUT')

                      <button
                        type="submit"
                        onclick="return confirm('Aktifkan periode ini?')"
                        class="px-3 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm">

                        Aktifkan
                      </button>

                    </form>

                    @endif

                    @if($periode->is_active)

                    <form
                      action="{{ route('periode-tahunan.finish', $periode->id) }}"
                      method="POST">

                      @csrf
                      @method('PUT')

                      <button
                        type="submit"
                        onclick="return confirm('Akhiri periode ini?')"
                        class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm">

                        Akhiri
                      </button>

                    </form>

                    @endif

                    <a
                      href="{{ route('periode-tahunan.edit', $periode->id) }}"
                      class="px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm">

                      Edit
                    </a>

                  </div>

                </td>

              </tr>

              @empty

              <tr>

                <td colspan="4" class="px-6 py-16 text-center">

                  <div class="flex flex-col items-center">

                    <svg xmlns="http://www.w3.org/2000/svg"
                      class="w-16 h-16 text-gray-300"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor">

                      <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.5"
                        d="M9 17v-2a4 4 0 014-4h4" />

                    </svg>

                    <h3 class="mt-4 text-lg font-semibold text-gray-700">
                      Belum Ada Periode
                    </h3>

                    <p class="mt-1 text-gray-500">
                      Silakan buat periode tahunan terlebih dahulu.
                    </p>

                    <a
                      href="{{ route('periode-tahunan.create') }}"
                      class="mt-4 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">

                      Tambah Periode
                    </a>

                  </div>

                </td>

              </tr>

              @endforelse

            </tbody>

          </table>

        </div>

        <div class="px-6 py-4 border-t bg-gray-50">
          {{ $periodes->links() }}
        </div>

      </div>

    </div>

  </div>

</x-app-layout>