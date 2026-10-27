<x-app-layout>

  {{-- HEADER --}}
  <x-slot name="header">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
      <div>
        <h2 class="text-xl font-bold text-slate-800">{{ $title }}</h2>
        <p class="text-xs text-slate-500 mt-1">Kelola reservasi dan check-in pengunjung</p>
      </div>
    </div>
  </x-slot>

  <div class="py-4">
    <div class="max-w-[1600px] mx-auto px-3 sm:px-5 space-y-4">

      {{-- INFORMASI STATUS RINGKAS --}}
      <div class="bg-white border border-slate-200 rounded-xl p-3">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-3">
          <h3 class="text-sm font-bold text-slate-700">Informasi Status Reservasi</h3>
          <p class="text-xs text-slate-500">
            Check-in: hadir &nbsp;·&nbsp; Batalkan: ubah status &nbsp;·&nbsp; Hapus: permanen
          </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
          <div class="flex items-center gap-3 rounded-lg bg-amber-50 border border-amber-100 px-3 py-2">
            <span class="text-lg">🟡</span>
            <div>
              <div class="text-sm font-semibold text-amber-800">Pending</div>
              <p class="text-xs text-amber-700">Menunggu kedatangan</p>
            </div>
          </div>

          <div class="flex items-center gap-3 rounded-lg bg-green-50 border border-green-100 px-3 py-2">
            <span class="text-lg">🟢</span>
            <div>
              <div class="text-sm font-semibold text-green-800">Hadir</div>
              <p class="text-xs text-green-700">Sudah check-in</p>
            </div>
          </div>

          <div class="flex items-center gap-3 rounded-lg bg-red-50 border border-red-100 px-3 py-2">
            <span class="text-lg">🔴</span>
            <div>
              <div class="text-sm font-semibold text-red-800">Dibatalkan</div>
              <p class="text-xs text-red-700">Tidak dapat digunakan kembali</p>
            </div>
          </div>
        </div>
      </div>

      {{-- TABEL RESERVASI --}}
      <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

        {{-- TOOLBAR --}}
        <div class="p-3 sm:p-4 border-b border-slate-200 space-y-3">

          <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-3">

            <div class="flex-shrink-0">
              <h3 class="text-base font-bold text-slate-800">{{ $title }}</h3>
              <p class="text-xs text-slate-500 mt-1">
                Total hasil:
                <span class="font-bold text-slate-700">{{ $reservations->total() }}</span>
                reservasi
              </p>
            </div>

            {{-- PENCARIAN OTOMATIS --}}
            <form action="{{ url()->current() }}" method="GET"
              id="liveSearchForm" class="w-full xl:max-w-sm">

              <div class="relative">
                <span class="absolute inset-y-0 left-3 flex items-center text-slate-400 pointer-events-none">
                  🔎
                </span>

                <input
                  type="search"
                  name="search"
                  id="liveSearch"
                  value="{{ $search ?? request('search', '') }}"
                  placeholder="Cari nomor, kode, wilayah, ketua..."
                  autocomplete="off"
                  class="w-full rounded-lg border border-slate-300 bg-white py-2 pl-9 pr-20 text-sm
                                           focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none">

                <span id="searchIndicator"
                  class="hidden absolute inset-y-0 right-3 items-center text-xs text-blue-600">
                  Mencari...
                </span>
              </div>
              <p class="text-[11px] text-slate-400 mt-1">
                Hasil diperbarui otomatis saat Anda mengetik.
              </p>
            </form>
          </div>

          {{-- FILTER STATUS --}}
          <div class="flex flex-wrap items-center gap-1.5">
            <a href="{{ route('admin.reservasi.data') }}"
              class="px-3 py-1.5 rounded-lg text-xs font-semibold transition
                           {{ request()->routeIs('admin.reservasi.data')
                                ? 'bg-blue-600 text-white'
                                : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
              Semua
            </a>

            <a href="{{ route('admin.reservasi.pending') }}"
              class="px-3 py-1.5 rounded-lg text-xs font-semibold transition
                           {{ request()->routeIs('admin.reservasi.pending')
                                ? 'bg-amber-500 text-white'
                                : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
              Pending
            </a>

            <a href="{{ route('admin.reservasi.checked-in') }}"
              class="px-3 py-1.5 rounded-lg text-xs font-semibold transition
                           {{ request()->routeIs('admin.reservasi.checked-in')
                                ? 'bg-green-600 text-white'
                                : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
              Sudah Hadir
            </a>

            <a href="{{ route('admin.reservasi.cancelled') }}"
              class="px-3 py-1.5 rounded-lg text-xs font-semibold transition
                           {{ request()->routeIs('admin.reservasi.cancelled')
                                ? 'bg-red-600 text-white'
                                : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
              Dibatalkan
            </a>

            <a href="{{ route('admin.reservasi.scan') }}"
              class="px-3 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold">
              Scan QR
            </a>
          </div>
        </div>

        {{-- TABEL --}}
        <div class="overflow-x-auto">
          <table class="min-w-full text-sm whitespace-nowrap">

            <thead class="bg-slate-50 text-slate-600">
              <tr>
                <th class="px-4 py-3 text-left text-xs font-bold uppercase">No</th>
                <th class="px-4 py-3 text-left text-xs font-bold uppercase">Reservasi</th>
                <th class="px-4 py-3 text-left text-xs font-bold uppercase">Wilayah</th>
                <th class="px-4 py-3 text-left text-xs font-bold uppercase">Jenis</th>
                <th class="px-4 py-3 text-left text-xs font-bold uppercase">Peserta</th>
                <th class="px-4 py-3 text-center text-xs font-bold uppercase">Status</th>
                <th class="px-4 py-3 text-center text-xs font-bold uppercase">Aksi</th>
              </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">

              @forelse($reservations as $item)
              <tr class="hover:bg-slate-50 transition
                                    @if($item->status == 'checked_in') bg-green-50/30
                                    @elseif($item->status == 'no_show') bg-red-50/30
                                    @endif">

                {{-- NOMOR --}}
                <td class="px-4 py-3 text-slate-500">
                  {{ $reservations->firstItem() + $loop->index }}
                </td>

                {{-- RESERVASI --}}
                <td class="px-4 py-3">
                  <div class="font-semibold text-slate-800">
                    {{ $item->reservation_number }}
                  </div>
                  <div class="text-xs text-slate-500 mt-1">
                    Kode:
                    <span class="font-medium text-slate-700">
                      {{ $item->reservation_code }}
                    </span>
                  </div>
                </td>

                {{-- WILAYAH --}}
                <td class="px-4 py-3">
                  <div class="font-medium text-slate-700">
                    {{ $item->regency?->name ?? '-' }}
                  </div>
                  <div class="text-xs text-slate-500">
                    {{ $item->district?->name ?? '-' }}
                  </div>
                  <div class="text-xs text-slate-400">
                    {{ $item->village?->name ?? '-' }}
                  </div>
                </td>

                {{-- JENIS --}}
                <td class="px-4 py-3">
                  @if($item->type == 'group')
                  <span class="inline-flex px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-semibold">
                    👥 Rombongan
                  </span>
                  @else
                  <span class="inline-flex px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-semibold">
                    👤 Perseorangan
                  </span>
                  @endif
                </td>

                {{-- PESERTA --}}
                <td class="px-4 py-3">
                  <div class="font-bold text-slate-800 mb-1.5">
                    {{ $item->total_participant }} orang
                  </div>

                  <div class="grid grid-cols-2 gap-1 text-[11px]">
                    <span class="bg-blue-50 text-blue-700 rounded px-1.5 py-1">B: {{ $item->total_father }}</span>
                    <span class="bg-pink-50 text-pink-700 rounded px-1.5 py-1">I: {{ $item->total_mother }}</span>
                    <span class="bg-green-50 text-green-700 rounded px-1.5 py-1">R: {{ $item->total_teenager }}</span>
                    <span class="bg-amber-50 text-amber-700 rounded px-1.5 py-1">A: {{ $item->total_child }}</span>
                  </div>
                </td>

                {{-- STATUS --}}
                <td class="px-4 py-3 text-center">
                  @switch($item->status)
                  @case('pending')
                  <span class="inline-flex px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-semibold">
                    Pending
                  </span>
                  @break

                  @case('checked_in')
                  <span class="inline-flex px-2.5 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                    Hadir
                  </span>
                  @break

                  @case('no_show')
                  <span class="inline-flex px-2.5 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">
                    Dibatalkan
                  </span>
                  @break

                  @default
                  <span class="inline-flex px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 text-xs">
                    Tidak diketahui
                  </span>
                  @endswitch
                </td>

                {{-- AKSI --}}
                <td class="px-4 py-3">
                  <div class="flex justify-center items-center gap-1.5">

                    @if($item->status == 'pending')
                    {{-- CHECK-IN --}}
                    <form action="{{ route('admin.reservasi.checkin') }}" method="POST">
                      @csrf
                      <input type="hidden" name="reservation_code"
                        value="{{ $item->reservation_code }}">

                      <button type="submit"
                        class="px-2.5 py-1.5 rounded-lg bg-green-600 hover:bg-green-700 text-white text-xs font-semibold">
                        ✓ Check-in
                      </button>
                    </form>

                    {{-- BATALKAN --}}
                    <form action="{{ route('reservasi.cancel', $item->id) }}"
                      method="POST" class="cancel-form">
                      @csrf
                      @method('PUT')

                      <button type="submit"
                        class="px-2.5 py-1.5 rounded-lg bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold">
                        Batalkan
                      </button>
                    </form>

                    @elseif($item->status == 'checked_in')
                    <span class="text-xs font-medium text-green-700">✓ Sudah hadir</span>

                    @elseif($item->status == 'no_show')
                    <span class="text-xs font-medium text-red-700">✕ Dibatalkan</span>
                    @endif

                    {{-- HAPUS --}}
                    <form action="{{ route('reservasi.destroy', $item->id) }}"
                      method="POST" class="delete-form">
                      @csrf
                      @method('DELETE')

                      <button type="submit"
                        class="px-2.5 py-1.5 rounded-lg bg-red-600 hover:bg-red-700 text-white text-xs font-semibold">
                        Hapus
                      </button>
                    </form>

                  </div>
                </td>
              </tr>

              @empty
              <tr>
                <td colspan="7" class="px-4 py-12 text-center">
                  <div class="text-3xl mb-2">📭</div>
                  <p class="font-semibold text-slate-600">Tidak ada data reservasi</p>
                  <p class="text-xs text-slate-400 mt-1">
                    Coba ubah kata pencarian atau pilih filter lainnya.
                  </p>
                </td>
              </tr>
              @endforelse

            </tbody>
          </table>
        </div>

        {{-- PAGINATION --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 px-4 py-3 border-t border-slate-200 bg-slate-50">
          <p class="text-xs text-slate-500">
            Menampilkan {{ $reservations->firstItem() ?? 0 }}–{{ $reservations->lastItem() ?? 0 }}
            dari {{ $reservations->total() }} data
          </p>
          <div>
            {{ $reservations->withQueryString()->links() }}
          </div>
        </div>

      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    // Konfirmasi pembatalan
    document.querySelectorAll('.cancel-form').forEach(form => {
      form.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
          title: 'Batalkan reservasi?',
          text: 'Status akan berubah menjadi Dibatalkan.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Ya, Batalkan',
          cancelButtonText: 'Tidak',
          confirmButtonColor: '#d97706'
        }).then(result => {
          if (result.isConfirmed) {
            form.submit();
          }
        });
      });
    });

    // Konfirmasi hapus
    document.querySelectorAll('.delete-form').forEach(form => {
      form.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
          title: 'Hapus reservasi?',
          text: 'Data yang dihapus tidak dapat dikembalikan.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Ya, Hapus',
          cancelButtonText: 'Batal',
          confirmButtonColor: '#dc2626'
        }).then(result => {
          if (result.isConfirmed) {
            form.submit();
          }
        });
      });
    });

    // Notifikasi
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

    // Pencarian otomatis saat mengetik
    document.addEventListener('DOMContentLoaded', function() {
      const input = document.getElementById('liveSearch');
      const indicator = document.getElementById('searchIndicator');

      if (!input) return;

      let timer;

      input.addEventListener('input', function() {
        clearTimeout(timer);

        if (indicator) {
          indicator.classList.remove('hidden');
          indicator.classList.add('flex');
        }

        timer = setTimeout(function() {
          const params = new URLSearchParams(window.location.search);
          const value = input.value.trim();

          if (value) {
            params.set('search', value);
          } else {
            params.delete('search');
          }

          params.delete('page');

          const query = params.toString();
          const url = window.location.pathname + (query ? '?' + query : '');

          if (url !== window.location.pathname + window.location.search) {
            window.location.href = url;
          } else if (indicator) {
            indicator.classList.add('hidden');
            indicator.classList.remove('flex');
          }
        }, 400);
      });
    });
  </script>

</x-app-layout>