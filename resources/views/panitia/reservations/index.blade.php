
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

      {{-- Success Alert --}}
      @if(session('success'))
      <div class="mb-5 rounded-2xl border border-green-200 bg-green-50 p-4">
        <div class="flex items-center gap-2 text-green-700">
          <svg xmlns="http://www.w3.org/2000/svg"
            class="w-5 h-5"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor">

            <path stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M5 13l4 4L19 7" />
          </svg>

          <span class="font-medium">
            {{ session('success') }}
          </span>
        </div>
      </div>
      @endif

      {{-- Main Card --}}
      <div class="bg-white rounded-[30px] shadow-sm border border-slate-200 overflow-hidden">

        {{-- Header --}}
        <div class="border-b border-slate-200 bg-slate-50 p-6">

          <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

            <div>

              <h3 class="text-xl font-bold text-slate-800">
                {{ $title }}
              </h3>

              <p class="text-sm text-slate-500 mt-1">
                Total reservasi:
                <span class="font-semibold text-slate-700">
                  {{ $reservations->total() }}
                </span>
              </p>

            </div>

            {{-- Filter --}}
            <div class="flex flex-wrap gap-2">

              <a href="{{ route('admin.reservasi.data') }}"
                class="px-5 py-2 rounded-xl text-sm font-medium transition
                                {{ request()->routeIs('admin.reservasi.data')
                                    ? 'bg-blue-600 text-white shadow'
                                    : 'bg-white border hover:bg-slate-100 text-slate-700' }}">
                Semua
              </a>

              <a href="{{ route('admin.reservasi.checked-in') }}"
                class="px-5 py-2 rounded-xl text-sm font-medium transition
                                {{ request()->routeIs('admin.reservasi.checked-in')
                                    ? 'bg-green-600 text-white shadow'
                                    : 'bg-white border hover:bg-slate-100 text-slate-700' }}">
                Sudah Hadir
              </a>

              <a href="{{ route('admin.reservasi.pending') }}"
                class="px-5 py-2 rounded-xl text-sm font-medium transition
                                {{ request()->routeIs('admin.reservasi.pending')
                                    ? 'bg-yellow-500 text-white shadow'
                                    : 'bg-white border hover:bg-slate-100 text-slate-700' }}">
                Pending
              </a>

              <a href="{{ route('admin.reservasi.scan') }}"
                class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium transition shadow">
                Scan QR
              </a>

            </div>

          </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">

          <table class="min-w-full text-sm">

            <thead class="bg-slate-100 text-slate-700">

              <tr>
                <th class="px-6 py-4 text-left font-semibold">No</th>
                <th class="px-6 py-4 text-left font-semibold">Reservasi</th>
                <th class="px-6 py-4 text-left font-semibold">Wilayah</th>
                <th class="px-6 py-4 text-left font-semibold">Jenis</th>
                <th class="px-6 py-4 text-left font-semibold">Peserta</th>
                
                <th class="px-6 py-4 text-center font-semibold">Status</th>
                <th class="px-6 py-4 text-center font-semibold">Aksi</th>
              </tr>

            </thead>

            <tbody class="divide-y divide-slate-100">

              @forelse($reservations as $item)

              <tr class="hover:bg-slate-50 transition">

                {{-- Nomor --}}
                <td class="px-6 py-5 text-slate-500 font-medium">
                  {{ $reservations->firstItem() + $loop->index }}
                </td>

                {{-- Reservasi --}}
                <td class="px-6 py-5">

                  <div class="font-semibold text-slate-800">
                    {{ $item->reservation_number }}
                  </div>

                  <div class="text-xs text-slate-500 mt-1">
                    {{ $item->reservation_code }}
                  </div>

                </td>

                {{-- Wilayah --}}
                <td class="px-6 py-5">

                  <div class="font-medium text-slate-700">
                    {{ $item->regency?->name }}
                  </div>

                  <div class="text-xs text-slate-500">
                    {{ $item->district?->name }}
                  </div>

                  <div class="text-xs text-slate-400">
                    {{ $item->village?->name }}
                  </div>

                </td>

                {{-- Jenis --}}
                <td class="px-6 py-5">

                  @if($item->type === 'group')
                  <span class="px-4 py-1.5 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">
                    Rombongan
                  </span>
                  @else
                  <span class="px-4 py-1.5 rounded-full bg-slate-100 text-slate-700 text-xs font-semibold">
                    Perseorangan
                  </span>
                  @endif

                </td>

                {{-- Peserta --}}
                <td class="px-6 py-5">

                  <div class="font-medium">
                    Total:
                    <span class="font-bold">
                      {{ $item->total_participant }}
                    </span>
                  </div>

                  <div class="text-xs text-slate-500 mt-1">
                    B: {{ $item->total_father }}
                    •
                    I: {{ $item->total_mother }}
                    •
                    R: {{ $item->total_teenager }}
                    •
                    A: {{ $item->total_child }}
                  </div>

                </td>

                {{-- Kendaraan --}}
                

                {{-- Status --}}
                <td class="px-6 py-5 text-center">

                  @if($item->status === 'checked_in')
                  <span class="inline-flex items-center gap-1 px-4 py-2 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                    ● Hadir
                  </span>
                  @else
                  <span class="inline-flex items-center gap-1 px-4 py-2 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">
                    ● Pending
                  </span>
                  @endif

                </td>

                {{-- Aksi --}}
                <td class="px-6 py-5 text-center">

                  @if($item->status !== 'checked_in')

                  <form
                    action="{{ route('admin.reservasi.checkin') }}"
                    method="POST">

                    @csrf

                    <input
                      type="hidden"
                      name="reservation_code"
                      value="{{ $item->reservation_code }}">

                    <button
                      class="bg-green-600 hover:bg-green-700 transition text-white px-5 py-2 rounded-xl text-xs font-semibold shadow-sm">
                      Check-in
                    </button>
                  </form>

                  @else

                  <span class="text-slate-400 text-xs font-medium">
                    selesai
                  </span>

                  @endif

                </td>

              </tr>

              @empty

              <tr>
                <td colspan="8"
                  class="py-16 text-center text-slate-500">

                  Tidak ada data reservasi

                </td>
              </tr>

              @endforelse

            </tbody>

          </table>

        </div>

        {{-- Pagination --}}
        <div class="border-t border-slate-200 bg-slate-50 px-6 py-4">
          {{ $reservations->links() }}
        </div>

      </div>
    </div>
  </div>

</x-app-layout>
