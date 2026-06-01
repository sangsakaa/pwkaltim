<x-app-layout>

  <div class="max-w-7xl mx-auto py-10 px-4">

    {{-- HEADER --}}
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-800">
        Dashboard Reservasi
      </h1>
      <p class="text-gray-500 mt-1">
        Ringkasan data reservasi dan check-in pengunjung
      </p>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 p-4 rounded-xl">
      {{ session('success') }}
    </div>
    @endif

    {{-- STATS GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

      {{-- TOTAL --}}
      <div class="bg-white rounded-2xl shadow hover:shadow-lg transition p-6 border">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-gray-500">Total Reservasi</p>
            <h2 class="text-3xl font-bold text-gray-800 mt-2">
              {{ $totalReservation }}
            </h2>
          </div>

          <div class="bg-blue-100 text-blue-600 p-3 rounded-xl">
            📊
          </div>
        </div>
      </div>

      {{-- CHECKED IN --}}
      <div class="bg-white rounded-2xl shadow hover:shadow-lg transition p-6 border">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-gray-500">Sudah Check-in</p>
            <h2 class="text-3xl font-bold text-green-600 mt-2">
              {{ $checkedIn }}
            </h2>
          </div>

          <div class="bg-green-100 text-green-600 p-3 rounded-xl">
            ✅
          </div>
        </div>
      </div>

      {{-- PENDING --}}
      <div class="bg-white rounded-2xl shadow hover:shadow-lg transition p-6 border">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-gray-500">Pending</p>
            <h2 class="text-3xl font-bold text-yellow-500 mt-2">
              {{ $pending }}
            </h2>
          </div>

          <div class="bg-yellow-100 text-yellow-600 p-3 rounded-xl">
            ⏳
          </div>
        </div>
      </div>

    </div>

    {{-- ACTION --}}
    <div class="mt-10 flex flex-wrap gap-4">

      <a href="{{ route('admin.reservasi.scan') }}"
        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl shadow transition">
        📷 Scan QR Check-in
      </a>

      <a href="{{ route('admin.reservasi.data') }}"
        class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl transition">
        📄 Data Reservasi
      </a>

    </div>

  </div>

</x-app-layout>