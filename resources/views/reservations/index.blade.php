<x-app-layout>

  <x-slot name="header">
    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
      <div>
        <h2 class="text-2xl font-bold text-gray-800">
          {{ $title }}
        </h2>
        <p class="mt-1 text-sm text-gray-500">
          Kelola, periksa, pulihkan, dan cetak kartu reservasi
        </p>
      </div>
    </div>
  </x-slot>

  <div class="py-6">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

      {{-- NOTIFIKASI --}}
      @if(session('success'))
      <div class="mb-4 rounded-xl border border-green-200 bg-green-50 p-4 text-green-700">
        {{ session('success') }}
      </div>
      @endif

      @if(session('error'))
      <div class="mb-4 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
        {{ session('error') }}
      </div>
      @endif

      @if($errors->any())
      <div class="mb-4 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
        <p class="font-semibold">Terjadi kesalahan:</p>
        <ul class="mt-2 list-inside list-disc text-sm">
          @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

        {{-- HEADER DAN NAVIGASI --}}
        <div class="border-b bg-gray-50 px-6 py-5">
          <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

            <div>
              <h3 class="text-lg font-semibold text-gray-800">
                {{ $title }}
              </h3>

              <p class="mt-1 text-sm text-gray-500">
                Total data:
                <span class="font-bold text-gray-800">
                  {{ $reservations->total() }}
                </span>
              </p>
            </div>

            <div class="flex flex-wrap gap-2">

              <a href="{{ route('admin.reservasi.data') }}"
                class="rounded-lg px-4 py-2 text-sm font-medium
                               {{ request()->routeIs('admin.reservasi.data')
                                   ? 'bg-blue-600 text-white'
                                   : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Semua
              </a>

              <a href="{{ route('admin.reservasi.checked-in') }}"
                class="rounded-lg px-4 py-2 text-sm font-medium
                               {{ request()->routeIs('admin.reservasi.checked-in')
                                   ? 'bg-green-600 text-white'
                                   : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Sudah Check-in
              </a>

              <a href="{{ route('admin.reservasi.pending') }}"
                class="rounded-lg px-4 py-2 text-sm font-medium
                               {{ request()->routeIs('admin.reservasi.pending')
                                   ? 'bg-yellow-500 text-white'
                                   : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Pending
              </a>

              <a href="{{ route('admin.reservasi.scan') }}"
                class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                Scan QR
              </a>

            </div>
          </div>
        </div>

        {{-- TABEL RESERVASI --}}
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">

            <thead class="bg-gray-100">
              <tr>
                <th class="whitespace-nowrap px-5 py-3 text-left text-xs font-bold uppercase text-gray-600">
                  No
                </th>

                <th class="whitespace-nowrap px-5 py-3 text-left text-xs font-bold uppercase text-gray-600">
                  Reservasi
                </th>

                <th class="whitespace-nowrap px-5 py-3 text-left text-xs font-bold uppercase text-gray-600">
                  Wilayah
                </th>

                <th class="whitespace-nowrap px-5 py-3 text-left text-xs font-bold uppercase text-gray-600">
                  Jenis
                </th>

                <th class="whitespace-nowrap px-5 py-3 text-left text-xs font-bold uppercase text-gray-600">
                  Peserta
                </th>

                <th class="whitespace-nowrap px-5 py-3 text-left text-xs font-bold uppercase text-gray-600">
                  Kendaraan
                </th>

                <th class="whitespace-nowrap px-5 py-3 text-center text-xs font-bold uppercase text-gray-600">
                  Status
                </th>

                <th class="whitespace-nowrap px-5 py-3 text-center text-xs font-bold uppercase text-gray-600">
                  Aksi
                </th>
              </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 bg-white">

              @forelse($reservations as $item)

              <tr class="hover:bg-gray-50">

                {{-- NOMOR --}}
                <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-700">
                  {{ $loop->iteration + ($reservations->currentPage() - 1) * $reservations->perPage() }}
                </td>

                {{-- INFORMASI RESERVASI --}}
                <td class="min-w-48 px-5 py-4">
                  <div class="font-semibold text-gray-900">
                    {{ $item->reservation_number }}
                  </div>

                  <div class="mt-1 text-sm text-gray-500">
                    Kode: {{ $item->reservation_code }}
                  </div>

                  <div class="mt-1 text-xs text-gray-500">
                    {{ $item->ketua_rombongan }}
                  </div>
                </td>

                {{-- WILAYAH --}}
                <td class="min-w-40 px-5 py-4 text-sm text-gray-700">
                  <div>
                    {{ $item->regency?->name ?? '-' }}
                  </div>

                  <div class="mt-1 text-xs text-gray-500">
                    {{ $item->district?->name ?? '-' }}
                  </div>

                  <div class="mt-1 text-xs text-gray-400">
                    {{ $item->village?->name ?? '-' }}
                  </div>
                </td>

                {{-- JENIS --}}
                <td class="whitespace-nowrap px-5 py-4">
                  @if($item->type === 'group')
                  <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                    Rombongan
                  </span>
                  @else
                  <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">
                    Perseorangan
                  </span>
                  @endif
                </td>

                {{-- PESERTA --}}
                <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-700">
                  <div>
                    Total:
                    <span class="font-bold">
                      {{ $item->total_participant }}
                    </span>
                  </div>

                  <div class="mt-1 text-xs text-gray-500">
                    B: {{ $item->total_father }}
                    | I: {{ $item->total_mother }}
                    | R: {{ $item->total_teenager }}
                    | A: {{ $item->total_child }}
                  </div>
                </td>

                {{-- KENDARAAN --}}
                <td class="min-w-36 px-5 py-4 text-sm text-gray-700">
                  <div class="font-medium">
                    {{ $item->vehicle_type ? ucfirst($item->vehicle_type) : '-' }}
                  </div>

                  <div class="mt-1 text-xs text-gray-500">
                    {{ $item->vehicle_name ?? '-' }}
                  </div>

                  <div class="mt-1 text-xs text-gray-400">
                    {{ $item->vehicle_number ?? '-' }}
                  </div>
                </td>

                {{-- STATUS --}}
                <td class="whitespace-nowrap px-5 py-4 text-center">
                  @switch($item->status)

                  @case('pending')
                  <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">
                    Pending
                  </span>
                  @break

                  @case('checked_in')
                  <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                    Sudah Hadir
                  </span>
                  @break

                  @case('no_show')
                  <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                    Dibatalkan
                  </span>
                  @break

                  @default
                  <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs text-gray-600">
                    {{ $item->status }}
                  </span>

                  @endswitch
                </td>

                {{-- AKSI --}}
                <td class="px-5 py-4">
                  <div class="flex min-w-40 flex-wrap items-center justify-center gap-2">

                    {{-- CETAK KARTU --}}
                    @if($item->status !== 'no_show')
                    <a href="{{ route('admin.reservasi.card', $item->id) }}"
                      target="_blank"
                      rel="noopener"
                      class="rounded-lg bg-blue-600 px-3 py-2 text-xs font-semibold text-white hover:bg-blue-700">
                      Cetak Kartu
                    </a>
                    @endif

                    {{-- AKSI UNTUK PENDING --}}
                    @if($item->status === 'pending')

                    <form action="{{ route('admin.reservasi.checkin') }}"
                      method="POST"
                      class="checkin-form">
                      @csrf

                      <input type="hidden"
                        name="reservation_code"
                        value="{{ $item->reservation_code }}">

                      <button type="submit"
                        class="rounded-lg bg-green-600 px-3 py-2 text-xs font-semibold text-white hover:bg-green-700">
                        Check-in
                      </button>
                    </form>

                    <form action="{{ route('reservasi.cancel', $item->id) }}"
                      method="POST"
                      class="cancel-form">
                      @csrf
                      @method('PUT')

                      <button type="submit"
                        class="rounded-lg bg-yellow-500 px-3 py-2 text-xs font-semibold text-white hover:bg-yellow-600">
                        Batalkan
                      </button>
                    </form>

                    @endif

                    {{-- KEMBALIKAN KE PENDING --}}
                    @if(in_array($item->status, ['checked_in', 'no_show']))

                    <form action="{{ route('admin.reservasi.restore-pending', $item->id) }}"
                      method="POST"
                      class="restore-form">
                      @csrf

                      <button type="submit"
                        class="rounded-lg bg-amber-500 px-3 py-2 text-xs font-semibold text-white hover:bg-amber-600">
                        Kembali ke Pending
                      </button>
                    </form>

                    @endif

                    {{-- HAPUS UNTUK SEMUA STATUS --}}
                    <form action="{{ route('reservasi.destroy', $item->id) }}"
                      method="POST"
                      class="delete-form">
                      @csrf
                      @method('DELETE')

                      <button type="submit"
                        class="rounded-lg bg-red-600 px-3 py-2 text-xs font-semibold text-white hover:bg-red-700">
                        Hapus
                      </button>
                    </form>

                  </div>
                </td>

              </tr>

              @empty

              <tr>
                <td colspan="8"
                  class="px-6 py-10 text-center text-gray-500">
                  Tidak ada data reservasi.
                </td>
              </tr>

              @endforelse

            </tbody>
          </table>
        </div>

        {{-- PAGINATION --}}
        <div class="border-t bg-gray-50 px-6 py-4">
          {{ $reservations->links() }}
        </div>

      </div>
    </div>
  </div>

  {{-- SWEETALERT --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {

      // Konfirmasi check-in
      document.querySelectorAll('.checkin-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
          e.preventDefault();

          Swal.fire({
            title: 'Konfirmasi Check-in?',
            text: 'Pastikan reservasi dan pengunjung sudah benar.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#16a34a',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Check-in',
            cancelButtonText: 'Batal'
          }).then(function(result) {
            if (result.isConfirmed) {
              form.submit();
            }
          });
        });
      });

      // Konfirmasi pembatalan
      document.querySelectorAll('.cancel-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
          e.preventDefault();

          Swal.fire({
            title: 'Batalkan Reservasi?',
            text: 'Status reservasi akan berubah menjadi Dibatalkan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#eab308',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Batalkan',
            cancelButtonText: 'Tutup'
          }).then(function(result) {
            if (result.isConfirmed) {
              form.submit();
            }
          });
        });
      });

      // Konfirmasi pemulihan
      document.querySelectorAll('.restore-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
          e.preventDefault();

          Swal.fire({
            title: 'Kembalikan ke Pending?',
            text: 'Reservasi yang sudah check-in atau dibatalkan akan kembali ke status Pending.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#d97706',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Kembalikan',
            cancelButtonText: 'Batal'
          }).then(function(result) {
            if (result.isConfirmed) {
              form.submit();
            }
          });
        });
      });

      // Konfirmasi hapus
      document.querySelectorAll('.delete-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
          e.preventDefault();

          Swal.fire({
            title: 'Hapus Reservasi?',
            text: 'Data yang dihapus mungkin tidak dapat dikembalikan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
          }).then(function(result) {
            if (result.isConfirmed) {
              form.submit();
            }
          });
        });
      });

      // Notifikasi berhasil
      @if(session('success'))
      Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: {
          {
            Illuminate\ Support\ Js::from(session('success'))
          }
        },
        timer: 2500,
        showConfirmButton: false
      });
      @endif

      // Notifikasi gagal
      @if(session('error'))
      Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: {
          {
            Illuminate\ Support\ Js::from(session('error'))
          }
        },
        confirmButtonText: 'Tutup'
      });
      @endif

    });
  </script>

</x-app-layout>