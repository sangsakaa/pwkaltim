{{-- resources/views/periode-tahunan/index.blade.php --}}

<x-app-layout>

  @section('title', 'Periode Tahunan')

  <x-slot name="header">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

      <div>
        <h2 class="text-2xl font-bold text-gray-800">
          Periode Tahunan
        </h2>

        <p class="text-sm text-gray-500 mt-1">
          Kelola periode kepengurusan dan program kerja organisasi.
        </p>
      </div>

      <div class="flex flex-wrap gap-3">

        <form action="{{ route('periode-tahunan.generate') }}"
          method="POST"
          class="generate-form">

          @csrf

          <button
            type="submit"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-xl shadow-sm transition">

            <svg xmlns="http://www.w3.org/2000/svg"
              class="w-4 h-4"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor">

              <path stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 4v5h.582M20 20v-5h-.581M5.64 17.657A9 9 0 1018.36 6.343" />
            </svg>

            Generate Tahun {{ now()->year }}
          </button>

        </form>

        <a href="{{ route('periode-tahunan.create') }}"
          class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-sm transition">

          <svg xmlns="http://www.w3.org/2000/svg"
            class="w-4 h-4"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor">

            <path stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 4v16m8-8H4" />
          </svg>

          Tambah Periode
        </a>

      </div>

    </div>
  </x-slot>

  <div class="py-8">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

      {{-- Statistik --}}
      <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        <div class="bg-white rounded-2xl border shadow-sm p-6">

          <p class="text-sm text-gray-500">
            Total Periode
          </p>

          <h3 class="text-3xl font-bold text-gray-800 mt-2">
            {{ $periodes->total() }}
          </h3>

        </div>

        <div class="bg-white rounded-2xl border shadow-sm p-6">

          <p class="text-sm text-gray-500">
            Periode Aktif
          </p>

          <h3 class="text-3xl font-bold text-green-600 mt-2">
            {{ $periodes->where('is_active', true)->count() }}
          </h3>

        </div>

        <div class="bg-white rounded-2xl border shadow-sm p-6">

          <p class="text-sm text-gray-500">
            Periode Nonaktif
          </p>

          <h3 class="text-3xl font-bold text-gray-700 mt-2">
            {{ $periodes->where('is_active', false)->count() }}
          </h3>

        </div>

      </div>

      {{-- Table --}}
      <div class="bg-white rounded-2xl border shadow-sm overflow-hidden">

        <div class="px-6 py-4 border-b bg-gray-50">

          <h3 class="font-semibold text-gray-800">
            Daftar Periode Tahunan
          </h3>

        </div>

        <div class="overflow-x-auto">

          <table class="min-w-full">

            <thead class="bg-gray-50">

              <tr>

                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                  Nama Periode
                </th>

                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                  Tahun
                </th>

                <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-gray-500">
                  Status
                </th>

                <th class="px-6 py-4 text-right text-xs font-semibold uppercase text-gray-500">
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
                    Mulai :
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

                  <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">

                    <span class="w-2 h-2 bg-green-500 rounded-full"></span>

                    Aktif

                  </span>

                  @else

                  <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-semibold">

                    <span class="w-2 h-2 bg-gray-400 rounded-full"></span>

                    Tidak Aktif

                  </span>

                  @endif

                </td>

                <td class="px-6 py-4">

                  <div class="flex justify-end gap-2">

                    @if(!$periode->is_active)

                    <form action="{{ route('periode-tahunan.activate', $periode->id) }}"
                      method="POST"
                      class="activate-form">

                      @csrf
                      @method('PUT')

                      <button type="submit"
                        class="px-3 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm">

                        Aktifkan
                      </button>

                    </form>

                    @endif

                    @if($periode->is_active)

                    <form action="{{ route('periode-tahunan.finish', $periode->id) }}"
                      method="POST"
                      class="finish-form">

                      @csrf
                      @method('PUT')

                      <button type="submit"
                        class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm">

                        Akhiri
                      </button>

                    </form>

                    @endif

                    <a href="{{ route('periode-tahunan.edit', $periode->id) }}"
                      class="px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm">

                      Edit
                    </a>

                  </div>

                </td>

              </tr>

              @empty

              <tr>

                <td colspan="4" class="py-16 text-center text-gray-500">

                  Belum ada data periode tahunan.

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

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  @if(session('success'))
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Berhasil',
      text: @json(session('success')),
      timer: 2500,
      showConfirmButton: false
    });
  </script>
  @endif

  <script>
    document.querySelectorAll('.generate-form').forEach(form => {

      form.addEventListener('submit', function(e) {

        e.preventDefault();

        Swal.fire({
          title: 'Generate Periode?',
          text: 'Periode tahun {{ now()->year }} akan dibuat.',
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Generate',
          cancelButtonText: 'Batal'
        }).then((result) => {

          if (result.isConfirmed) {
            form.submit();
          }

        });

      });

    });

    document.querySelectorAll('.activate-form').forEach(form => {

      form.addEventListener('submit', function(e) {

        e.preventDefault();

        Swal.fire({
          title: 'Aktifkan Periode?',
          text: 'Periode ini akan menjadi periode aktif.',
          icon: 'success',
          showCancelButton: true,
          confirmButtonText: 'Aktifkan',
          cancelButtonText: 'Batal'
        }).then((result) => {

          if (result.isConfirmed) {
            form.submit();
          }

        });

      });

    });

    document.querySelectorAll('.finish-form').forEach(form => {

      form.addEventListener('submit', function(e) {

        e.preventDefault();

        Swal.fire({
          title: 'Akhiri Periode?',
          text: 'Periode aktif akan dinonaktifkan.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#dc2626',
          confirmButtonText: 'Akhiri',
          cancelButtonText: 'Batal'
        }).then((result) => {

          if (result.isConfirmed) {
            form.submit();
          }

        });

      });

    });
  </script>

</x-app-layout>