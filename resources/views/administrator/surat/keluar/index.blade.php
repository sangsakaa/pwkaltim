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
  @endphp

  @section('title', 'PW ' . $wilayah)

  <x-slot name="header">
    <div class="flex items-center justify-between">
      <div class="flex items-center gap-4">
        <div
          class="w-14 h-14 bg-gradient-to-br from-green-600 to-emerald-700 rounded-2xl flex items-center justify-center shadow-lg">
          <img src="{{ asset('image/logo.png') }}" alt="Logo" class="w-10 h-10 object-contain">
        </div>

        <div>
          <h2 class="text-2xl font-bold text-gray-800">
            Dashboard PW {{ $wilayah }}
          </h2>
          <p class="text-sm text-gray-500">
            Sistem Pengelolaan Surat dan Administrasi
          </p>
        </div>
      </div>
    </div>
  </x-slot>

  <div class="p-4 sm:p-6 space-y-6">

    <!-- Hero Card -->
    <div
      class="bg-gradient-to-r from-emerald-600 via-green-600 to-teal-600 rounded-3xl shadow-xl overflow-hidden">
      <div class="p-8 text-white">
        <div class="flex flex-col lg:flex-row justify-between items-center gap-6">

          <div class="flex items-center gap-5">
            <div class="bg-white/20 backdrop-blur-sm p-4 rounded-2xl">
              <img src="{{ asset('image/logo.png') }}" alt="Logo"
                class="w-16 h-16 object-contain">
            </div>

            <div>
              <h3 class="text-3xl font-bold">
                PW {{ $wilayah }}
              </h3>

              <p class="text-green-100 mt-1">
                Dashboard Pengelolaan Surat Organisasi
              </p>
            </div>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl px-6 py-4 text-center">
              <h4 class="text-3xl font-bold">
                {{ $surat->total() }}
              </h4>
              <p class="text-sm text-green-100">
                Total Surat
              </p>
            </div>

            <div class="bg-white/10 backdrop-blur-sm rounded-2xl px-6 py-4 text-center">
              <h4 class="text-3xl font-bold">
                {{ $surat->count() }}
              </h4>
              <p class="text-sm text-green-100">
                Halaman Ini
              </p>
            </div>
          </div>

        </div>
      </div>
    </div>

    <!-- Content -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden">

      <!-- Header Content -->
      <div class="p-6 border-b border-gray-100">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

          <!-- Search -->
          <form method="GET" action="{{ route('surat.index') }}"
            class="relative w-full md:w-96">

            <input
              type="text"
              name="search"
              value="{{ request('search') }}"
              placeholder="Cari nomor surat, perihal, atau tujuan..."
              class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500">

            <svg class="absolute left-3 top-3.5 w-5 h-5 text-gray-400"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24">
              <path stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
            </svg>
          </form>

          <!-- Add Button -->
          <a href="{{ route('surat.create') }}"
            class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl shadow transition">

            <svg class="w-5 h-5"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24">
              <path stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 4v16m8-8H4" />
            </svg>

            Tambah Surat
          </a>

        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div
          class="mt-5 flex items-center gap-3 p-4 bg-green-50 border border-green-200 rounded-xl">
          <div
            class="w-8 h-8 flex items-center justify-center rounded-full bg-green-100 text-green-600 font-bold">
            ✓
          </div>

          <div class="text-green-700">
            {{ session('success') }}
          </div>
        </div>
        @endif

      </div>

      <!-- Table -->
      <div class="overflow-x-auto">

        <table class="min-w-full">

          <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
              <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">
                No
              </th>

              <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">
                Nomor Surat
              </th>

              <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">
                Perihal
              </th>

              <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">
                Kepada
              </th>

              <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">
                Tanggal
              </th>

              <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">
                Aksi
              </th>
            </tr>
          </thead>

          <tbody class="divide-y divide-gray-100">

            @forelse ($surat as $i => $item)
            <tr
              class="{{ $loop->even ? 'bg-gray-50/40' : 'bg-white' }} hover:bg-green-50 transition">

              <td class="px-6 py-4 font-medium text-gray-700">
                {{ $surat->firstItem() + $i }}
              </td>

              <td class="px-6 py-4">
                <span class="font-medium text-gray-800">
                  {{ $item->nomor_surat }}
                </span>
              </td>

              <td class="px-6 py-4 text-gray-700">
                {{ $item->perihal }}
              </td>

              <td class="px-6 py-4 text-gray-700">
                {{ $item->kepada }}
              </td>

              <td class="px-6 py-4 text-gray-700">
                {{ $item->tanggal_masehi ? \Carbon\Carbon::parse($item->tanggal_masehi)->format('d-m-Y') : '-' }}
              </td>

              <td class="px-6 py-4">
                <div class="flex justify-center gap-2">

                  <a href="{{ route('surat.show', $item->id) }}"
                    class="px-3 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-sm shadow">
                    👁
                  </a>

                  <a href="{{ route('surat.edit', $item->id) }}"
                    class="px-3 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-sm shadow">
                    ✏️
                  </a>

                  <form
                    action="{{ route('surat.destroy', $item->id) }}"
                    method="POST"
                    class="delete-form">

                    @csrf
                    @method('DELETE')

                    <button
                      type="submit"
                      class="btn-delete px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm shadow">
                      🗑
                    </button>
                  </form>

                </div>
              </td>

            </tr>

            @empty

            <tr>
              <td colspan="6">

                <div class="py-20 text-center">

                  <div class="text-7xl mb-4">
                    📄
                  </div>

                  <h3 class="text-xl font-semibold text-gray-700">
                    Belum Ada Data Surat
                  </h3>

                  <p class="text-gray-500 mt-2">
                    Data surat yang ditambahkan akan tampil di sini.
                  </p>

                </div>

              </td>
            </tr>

            @endforelse

          </tbody>

        </table>

      </div>

      <!-- Pagination -->
      @if($surat->hasPages())
      <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
        {{ $surat->links() }}
      </div>
      @endif

    </div>

  </div>

  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    document.querySelectorAll('.btn-delete').forEach(btn => {
      btn.addEventListener('click', function(e) {

        e.preventDefault();

        const form = this.closest('form');

        Swal.fire({
          title: 'Hapus surat?',
          text: 'Data yang dihapus tidak dapat dikembalikan.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#dc2626',
          cancelButtonColor: '#6b7280',
          confirmButtonText: 'Ya, Hapus',
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