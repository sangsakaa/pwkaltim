<x-app-layout>

  <x-slot name="header">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
      <div>
        <h2 class="text-3xl font-bold text-slate-800">
          {{ $title }}
        </h2>

        <p class="text-sm text-slate-500 mt-1">
          Kelola data reservasi pengunjung
        </p>
      </div>
    </div>
  </x-slot>

  <div class="py-6">
    <div class="max-w-7xl mx-auto px-4">
      {{-- INFORMASI STATUS --}}
      <div class="mb-6">

        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-3xl p-6">

          <h3 class="text-lg font-bold text-slate-800 mb-4">
            Informasi Status Reservasi
          </h3>

          <div class="grid md:grid-cols-3 gap-4">

            <div class="bg-yellow-100 border border-yellow-200 rounded-2xl p-4">
              <div class="font-semibold text-yellow-800">
                🟡 Pending
              </div>

              <div class="text-sm text-yellow-700 mt-2">
                Reservasi sudah dibuat dan menunggu kedatangan peserta.
              </div>
            </div>

            <div class="bg-green-100 border border-green-200 rounded-2xl p-4">
              <div class="font-semibold text-green-800">
                🟢 Hadir
              </div>

              <div class="text-sm text-green-700 mt-2">
                Peserta telah melakukan check-in.
              </div>
            </div>

            <div class="bg-red-100 border border-red-200 rounded-2xl p-4">
              <div class="font-semibold text-red-800">
                🔴 Dibatalkan
              </div>

              <div class="text-sm text-red-700 mt-2">
                Reservasi dibatalkan dan tidak dapat digunakan kembali.
              </div>
            </div>

          </div>

          <div class="mt-5 text-sm text-slate-600">

            <strong>Cara Kerja Tombol:</strong>

            <ul class="list-disc ml-5 mt-2 space-y-1">

              <li>
                <b>Check-in</b> → Status berubah menjadi Hadir.
              </li>

              <li>
                <b>Batalkan</b> → Status berubah menjadi Dibatalkan.
              </li>

              <li>
                <b>Hapus</b> → Data reservasi dihapus permanen.
              </li>

            </ul>

          </div>

        </div>

      </div>

      <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">

        {{-- HEADER --}}
        <div class="border-b border-slate-200 bg-slate-50 p-6">

          <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

            <div>
              <h3 class="text-xl font-bold text-slate-800">
                {{ $title }}
              </h3>

              <p class="text-sm text-slate-500 mt-1">
                Total Reservasi :
                <span class="font-semibold">
                  {{ $reservations->total() }}
                </span>
              </p>
            </div>

            {{-- FILTER --}}
            <div class="flex flex-wrap gap-2">

              <a href="{{ route('admin.reservasi.data') }}"
                class="px-5 py-2 rounded-xl text-sm font-medium transition
                                {{ request()->routeIs('admin.reservasi.data')
                                    ? 'bg-blue-600 text-white'
                                    : 'bg-white border text-slate-700 hover:bg-slate-100' }}">
                Semua
              </a>

              <a href="{{ route('admin.reservasi.pending') }}"
                class="px-5 py-2 rounded-xl text-sm font-medium transition
                                {{ request()->routeIs('admin.reservasi.pending')
                                    ? 'bg-yellow-500 text-white'
                                    : 'bg-white border text-slate-700 hover:bg-slate-100' }}">
                Pending
              </a>

              <a href="{{ route('admin.reservasi.checked-in') }}"
                class="px-5 py-2 rounded-xl text-sm font-medium transition
                                {{ request()->routeIs('admin.reservasi.checked-in')
                                    ? 'bg-green-600 text-white'
                                    : 'bg-white border text-slate-700 hover:bg-slate-100' }}">
                Sudah Hadir
              </a>

              <a href="{{ route('admin.reservasi.cancelled') }}"
                class="px-5 py-2 rounded-xl text-sm font-medium transition
                                {{ request()->routeIs('admin.reservasi.cancelled')
                                    ? 'bg-red-600 text-white'
                                    : 'bg-white border text-slate-700 hover:bg-slate-100' }}">
                Dibatalkan
              </a>

              <a href="{{ route('admin.reservasi.scan') }}"
                class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium shadow">
                Scan QR
              </a>

            </div>

          </div>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">

          <table class="min-w-full text-sm">

            <thead class="bg-slate-100">

              <tr>
                <th class="px-6 py-4 text-left">No</th>
                <th class="px-6 py-4 text-left">Reservasi</th>
                <th class="px-6 py-4 text-left">Wilayah</th>
                <th class="px-6 py-4 text-left">Jenis</th>
                <th class="px-6 py-4 text-left">Peserta</th>
                <th class="px-6 py-4 text-center">Status</th>
                <th class="px-6 py-4 text-center">Aksi</th>
              </tr>

            </thead>

            <tbody class="divide-y divide-slate-200">

              @forelse($reservations as $item)

              <tr class="
        transition-all duration-200 hover:bg-slate-50

        @if($item->status == 'checked_in')
            bg-green-50/30
        @elseif($item->status == 'no_show')
            bg-red-50/30
        @endif
    ">

                {{-- NO --}}
                <td class="px-6 py-5 font-medium text-slate-600">
                  {{ $reservations->firstItem() + $loop->index }}
                </td>

                {{-- RESERVASI --}}
                <td class="px-6 py-5">

                  <div class="font-semibold text-slate-800">
                    {{ $item->reservation_number }}
                  </div>

                  <div class="mt-1">
                    <span class="inline-flex px-2 py-1 text-xs rounded-lg bg-slate-100 text-slate-600 font-medium">
                      {{ $item->reservation_code }}
                    </span>
                  </div>

                </td>

                {{-- WILAYAH --}}
                <td class="px-6 py-5">

                  <div class="space-y-1">

                    <div class="font-semibold text-slate-700">
                      {{ $item->regency?->name ?? '-' }}
                    </div>

                    <div class="text-xs text-slate-500">
                      {{ $item->district?->name ?? '-' }}
                    </div>

                    <div class="text-xs text-slate-400">
                      {{ $item->village?->name ?? '-' }}
                    </div>

                  </div>

                </td>

                {{-- JENIS --}}
                <td class="px-6 py-5">

                  @if($item->type == 'group')

                  <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">
                    👥 Rombongan
                  </span>

                  @else

                  <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-semibold">
                    👤 Perseorangan
                  </span>

                  @endif

                </td>

                {{-- PESERTA --}}
                <td class="px-6 py-5">

                  <div class="font-bold text-slate-800 mb-2">
                    {{ $item->total_participant }} Orang
                  </div>

                  <div class="grid grid-cols-2 gap-1 text-xs">

                    <div class="bg-blue-50 rounded px-2 py-1">
                      B: {{ $item->total_father }}
                    </div>

                    <div class="bg-pink-50 rounded px-2 py-1">
                      I: {{ $item->total_mother }}
                    </div>

                    <div class="bg-green-50 rounded px-2 py-1">
                      R: {{ $item->total_teenager }}
                    </div>

                    <div class="bg-yellow-50 rounded px-2 py-1">
                      A: {{ $item->total_child }}
                    </div>

                  </div>

                </td>

                {{-- STATUS --}}
                <td class="px-6 py-5 text-center">

                  @switch($item->status)

                  @case('pending')
                  <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">
                    🟡 Pending
                  </span>
                  @break

                  @case('checked_in')
                  <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                    🟢 Hadir
                  </span>
                  @break

                  @case('no_show')
                  <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-red-100 text-red-700 text-xs font-semibold">
                    🔴 Dibatalkan
                  </span>
                  @break

                  @default
                  <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-slate-100 text-slate-700 text-xs font-semibold">
                    Unknown
                  </span>

                  @endswitch

                </td>

                {{-- AKSI --}}
                <td class="px-6 py-5">

                  <div class="flex flex-wrap justify-center gap-2">

                    @if($item->status == 'pending')

                    {{-- CHECK IN --}}
                    <form action="{{ route('admin.reservasi.checkin') }}" method="POST">

                      @csrf

                      <input
                        type="hidden"
                        name="reservation_code"
                        value="{{ $item->reservation_code }}">

                      <button
                        type="submit"
                        class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl text-xs font-semibold shadow-sm">

                        ✓ Check-in

                      </button>

                    </form>

                    {{-- CANCEL --}}
                    <form
                      action="{{ route('reservasi.cancel',$item->id) }}"
                      method="POST"
                      class="cancel-form">

                      @csrf
                      @method('PUT')

                      <button
                        type="submit"
                        class="inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-xl text-xs font-semibold shadow-sm">

                        ⚠ Batalkan

                      </button>

                    </form>

                    @elseif($item->status == 'checked_in')

                    <span class="px-4 py-2 rounded-xl bg-green-100 text-green-700 text-xs font-semibold">
                      ✓ Sudah Check-in
                    </span>

                    @elseif($item->status == 'no_show')

                    <span class="px-4 py-2 rounded-xl bg-red-100 text-red-700 text-xs font-semibold">
                      ✕ Dibatalkan
                    </span>

                    @endif

                    {{-- HAPUS --}}
                    <form
                      action="{{ route('reservasi.destroy',$item->id) }}"
                      method="POST"
                      class="delete-form">

                      @csrf
                      @method('DELETE')

                      <button
                        type="submit"
                        class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl text-xs font-semibold shadow-sm">

                        🗑 Hapus

                      </button>

                    </form>

                  </div>

                </td>

              </tr>

              @empty

              <tr>

                <td colspan="7" class="py-20 text-center">

                  <div class="flex flex-col items-center">

                    <div class="text-5xl mb-3">
                      📭
                    </div>

                    <div class="font-semibold text-slate-600">
                      Tidak ada data reservasi
                    </div>

                    <div class="text-sm text-slate-400 mt-1">
                      Belum ada reservasi yang dapat ditampilkan
                    </div>

                  </div>

                </td>

              </tr>

              @endforelse

            </tbody>

          </table>

        </div>

        {{-- PAGINATION --}}
        <div class="border-t border-slate-200 bg-slate-50 px-6 py-4">
          {{ $reservations->links() }}
        </div>

      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    document.querySelectorAll('.cancel-form').forEach(form => {

      form.addEventListener('submit', function(e) {

        e.preventDefault();

        Swal.fire({
          title: 'Batalkan Reservasi?',
          text: 'Status akan berubah menjadi Dibatalkan',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Ya, Batalkan',
          cancelButtonText: 'Tidak'
        }).then((result) => {

          if (result.isConfirmed) {
            form.submit();
          }

        });

      });

    });

    document.querySelectorAll('.delete-form').forEach(form => {

      form.addEventListener('submit', function(e) {

        e.preventDefault();

        Swal.fire({
          title: 'Hapus Reservasi?',
          text: 'Data tidak dapat dikembalikan',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#dc2626',
          confirmButtonText: 'Ya, Hapus',
          cancelButtonText: 'Batal'
        }).then((result) => {

          if (result.isConfirmed) {
            form.submit();
          }

        });

      });

    });

    @if(session('success'))
    Swal.fire({
      icon: 'success',
      title: 'Berhasil',
      text: @json(session('success')),
      timer: 2000,
      showConfirmButton: false
    });
    @endif

    @if(session('error'))
    Swal.fire({
      icon: 'error',
      title: 'Gagal',
      text: @json(session('error'))
    });
    @endif
  </script>

</x-app-layout>