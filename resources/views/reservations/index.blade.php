<x-app-layout>

  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="text-2xl font-bold text-gray-800">
        {{ $title }}
      </h2>
    </div>
  </x-slot>

  <div class="py-6">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

      {{-- FLASH --}}
      @if(session('success'))
      <div class="mb-5 rounded-lg bg-green-100 border border-green-200 text-green-700 px-4 py-3">
        {{ session('success') }}
      </div>
      @endif

      {{-- CARD --}}
      <div class="bg-white rounded-2xl shadow overflow-hidden">

        {{-- HEADER --}}
        <div class="px-6 py-5 border-b bg-gray-50">

          <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">

            <div>
              <h3 class="text-lg font-semibold text-gray-800">
                {{ $title }}
              </h3>

              <p class="text-sm text-gray-500">
                Total data:
                <span class="font-semibold">
                  {{ $reservations->total() }}
                </span>
              </p>
            </div>

            <div class="flex gap-2 flex-wrap">

              <a
                href="{{ route('admin.reservasi.data') }}"
                class="px-4 py-2 rounded-lg text-sm font-medium
                                {{ request()->routeIs('admin.reservasi.data')
                                    ? 'bg-blue-600 text-white'
                                    : 'bg-gray-100 hover:bg-gray-200 text-gray-700' }}">
                Semua
              </a>

              <a
                href="{{ route('admin.reservasi.checked-in') }}"
                class="px-4 py-2 rounded-lg text-sm font-medium
                                {{ request()->routeIs('admin.reservasi.checked-in')
                                    ? 'bg-green-600 text-white'
                                    : 'bg-gray-100 hover:bg-gray-200 text-gray-700' }}">
                Sudah Check-in
              </a>

              <a
                href="{{ route('admin.reservasi.pending') }}"
                class="px-4 py-2 rounded-lg text-sm font-medium
                                {{ request()->routeIs('admin.reservasi.pending')
                                    ? 'bg-yellow-500 text-white'
                                    : 'bg-gray-100 hover:bg-gray-200 text-gray-700' }}">
                Pending
              </a>

              <a
                href="{{ route('admin.reservasi.scan') }}"
                class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium">
                Scan QR
              </a>

            </div>

          </div>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">

          <table class="min-w-full divide-y divide-gray-200">

            <thead class="bg-gray-100">

              <tr>

                <th class="px-5 py-3 text-left text-xs font-bold uppercase text-gray-600">
                  No
                </th>

                <th class="px-5 py-3 text-left text-xs font-bold uppercase text-gray-600">
                  Reservasi
                </th>

                <th class="px-5 py-3 text-left text-xs font-bold uppercase text-gray-600">
                  Wilayah
                </th>

                <th class="px-5 py-3 text-left text-xs font-bold uppercase text-gray-600">
                  Jenis
                </th>

                <th class="px-5 py-3 text-left text-xs font-bold uppercase text-gray-600">
                  Peserta
                </th>

                <th class="px-5 py-3 text-left text-xs font-bold uppercase text-gray-600">
                  Kendaraan
                </th>

                <th class="px-5 py-3 text-center text-xs font-bold uppercase text-gray-600">
                  Status
                </th>

                <th class="px-5 py-3 text-center text-xs font-bold uppercase text-gray-600">
                  Aksi
                </th>

              </tr>

            </thead>

            <tbody class="divide-y divide-gray-200 bg-white">

              @forelse($reservations as $item)

              <tr class="hover:bg-gray-50">

                {{-- NOMOR --}}
                <td class="px-5 py-4 text-sm text-gray-700">
                  {{ $loop->iteration + ($reservations->currentPage() - 1) * $reservations->perPage() }}
                </td>

                {{-- RESERVASI --}}
                <td class="px-5 py-4">

                  <div class="font-semibold text-gray-900">
                    {{ $item->reservation_number }}
                  </div>

                  <div class="text-sm text-gray-500">
                    {{ $item->reservation_code }}
                  </div>
                </td>

                {{-- WILAYAH --}}
                <td class="px-5 py-4 text-sm text-gray-700">

                  <div>
                    {{ $item->regency?->name ?? '-' }}
                  </div>

                  <div class="text-gray-500 text-xs">
                    {{ $item->district?->name ?? '-' }}
                  </div>

                  <div class="text-gray-400 text-xs">
                    {{ $item->village?->name ?? '-' }}
                  </div>

                </td>

                {{-- JENIS --}}
                <td class="px-5 py-4">

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
                <td class="px-5 py-4 text-sm text-gray-700">

                  <div>
                    Total:
                    <span class="font-bold">
                      {{ $item->total_participant }}
                    </span>
                  </div>

                  <div class="text-xs text-gray-500 mt-1">
                    B:
                    {{ $item->total_father }}

                    |
                    I:
                    {{ $item->total_mother }}

                    |
                    R:
                    {{ $item->total_teenager }}

                    |
                    A:
                    {{ $item->total_child }}
                  </div>

                </td>

                {{-- KENDARAAN --}}
                <td class="px-5 py-4 text-sm text-gray-700">

                  <div class="font-medium">
                    {{ ucfirst($item->vehicle_type) }}
                  </div>

                  <div class="text-xs text-gray-500">
                    {{ $item->vehicle_name ?? '-' }}
                  </div>

                  <div class="text-xs text-gray-400">
                    {{ $item->vehicle_number ?? '-' }}
                  </div>

                </td>

                {{-- STATUS --}}
                <td class="px-5 py-4 text-center">

                  @if($item->status === 'checked_in')
                  <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                    Sudah Hadir
                  </span>
                  @else
                  <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">
                    Pending
                  </span>
                  @endif

                </td>

                {{-- AKSI --}}
                <td class="px-5 py-4 text-center">

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
                      class="bg-green-600 hover:bg-green-700 text-white text-xs px-4 py-2 rounded-lg">
                      Check-in
                    </button>

                  </form>

                  @else

                  <span class="text-xs text-gray-400">
                    selesai
                  </span>

                  @endif

                </td>

              </tr>

              @empty

              <tr>
                <td colspan="8"
                  class="px-6 py-10 text-center text-gray-500">

                  Tidak ada data reservasi

                </td>
              </tr>

              @endforelse

            </tbody>
          </table>

        </div>

        {{-- PAGINATION --}}
        <div class="px-6 py-4 border-t bg-gray-50">
          {{ $reservations->links() }}
        </div>

      </div>

    </div>
  </div>

</x-app-layout>