<x-app-layout>

  <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center
                    sm:justify-between gap-3 mb-6">

      <div>
        <h1 class="text-xl font-bold tracking-tight text-gray-800">
          Dashboard Panitia
        </h1>
        <p class="text-xs text-gray-500 mt-1">
          Ringkasan reservasi dan peserta pengunjung
        </p>
      </div>

      <div class="text-xs text-gray-500 bg-white border
                        rounded-lg px-3 py-2 w-fit">
        📅 {{ now()->translatedFormat('d F Y') }}
      </div>

    </div>

    {{-- ALERT --}}
    @if(session('success'))
    <div class="mb-5 rounded-lg border border-green-200
                        bg-green-50 px-4 py-3 text-sm text-green-700">
      {{ session('success') }}
    </div>
    @endif

    {{-- STATISTIK UTAMA --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-6">

      {{-- RESERVASI --}}
      <div class="bg-white border border-gray-200 rounded-xl p-4
                        hover:border-blue-300 transition">
        <div class="flex items-center justify-between mb-3">
          <span class="text-xs font-medium text-gray-500">
            Total Reservasi
          </span>
          <span class="text-lg">📋</span>
        </div>
        <div class="text-2xl font-bold text-gray-800">
          {{ number_format($totalReservation ?? 0) }}
        </div>
        <p class="text-[11px] text-gray-400 mt-1">
          Seluruh pendaftaran
        </p>
      </div>

      {{-- PESERTA --}}
      <div class="bg-white border border-gray-200 rounded-xl p-4
                        hover:border-indigo-300 transition">
        <div class="flex items-center justify-between mb-3">
          <span class="text-xs font-medium text-gray-500">
            Total Peserta
          </span>
          <span class="text-lg">👥</span>
        </div>
        <div class="text-2xl font-bold text-indigo-600">
          {{ number_format($totalParticipant ?? 0) }}
        </div>
        <p class="text-[11px] text-gray-400 mt-1">
          Semua kategori
        </p>
      </div>

      {{-- CHECK-IN --}}
      <div class="bg-white border border-gray-200 rounded-xl p-4
                        hover:border-green-300 transition">
        <div class="flex items-center justify-between mb-3">
          <span class="text-xs font-medium text-gray-500">
            Sudah Check-in
          </span>
          <span class="text-lg">✓</span>
        </div>
        <div class="text-2xl font-bold text-green-600">
          {{ number_format($checkedIn ?? 0) }}
        </div>
        <p class="text-[11px] text-gray-400 mt-1">
          Reservasi terverifikasi
        </p>
      </div>

      {{-- PENDING --}}
      <div class="bg-white border border-gray-200 rounded-xl p-4
                        hover:border-amber-300 transition">
        <div class="flex items-center justify-between mb-3">
          <span class="text-xs font-medium text-gray-500">
            Pending
          </span>
          <span class="text-lg">◷</span>
        </div>
        <div class="text-2xl font-bold text-amber-500">
          {{ number_format($pending ?? 0) }}
        </div>
        <p class="text-[11px] text-gray-400 mt-1">
          Menunggu proses
        </p>
      </div>

    </div>

    {{-- RINCIAN PESERTA --}}
    <div class="bg-white border border-gray-200 rounded-xl p-4 sm:p-5 mb-6">

      <div class="flex items-center justify-between mb-4">
        <div>
          <h2 class="text-sm font-bold text-gray-800">
            Rincian Peserta
          </h2>
          <p class="text-xs text-gray-400 mt-1">
            Berdasarkan kategori usia
          </p>
        </div>
        <span class="text-xs text-gray-500 bg-gray-50
                             border rounded-md px-2 py-1">
          {{ number_format($totalParticipant ?? 0) }} orang
        </span>
      </div>

      <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">

        {{-- BAPAK --}}
        <div class="rounded-lg bg-blue-50/70 border border-blue-100 p-3">
          <div class="flex items-center gap-2 mb-2">
            <span class="flex items-center justify-center
                                     w-8 h-8 rounded-lg bg-blue-100 text-blue-700">
              👨
            </span>
            <span class="text-xs text-gray-600">Bapak</span>
          </div>
          <div class="text-xl font-bold text-blue-700">
            {{ number_format($totalFather ?? 0) }}
          </div>
          <p class="text-[10px] text-gray-500 mt-1">
            Dewasa laki-laki
          </p>
        </div>

        {{-- IBU --}}
        <div class="rounded-lg bg-pink-50/70 border border-pink-100 p-3">
          <div class="flex items-center gap-2 mb-2">
            <span class="flex items-center justify-center
                                     w-8 h-8 rounded-lg bg-pink-100 text-pink-700">
              👩
            </span>
            <span class="text-xs text-gray-600">Ibu</span>
          </div>
          <div class="text-xl font-bold text-pink-700">
            {{ number_format($totalMother ?? 0) }}
          </div>
          <p class="text-[10px] text-gray-500 mt-1">
            Dewasa perempuan
          </p>
        </div>

        {{-- REMAJA --}}
        <div class="rounded-lg bg-violet-50/70 border border-violet-100 p-3">
          <div class="flex items-center gap-2 mb-2">
            <span class="flex items-center justify-center
                                     w-8 h-8 rounded-lg bg-violet-100 text-violet-700">
              🧑
            </span>
            <span class="text-xs text-gray-600">Remaja</span>
          </div>
          <div class="text-xl font-bold text-violet-700">
            {{ number_format($totalTeenager ?? 0) }}
          </div>
          <p class="text-[10px] text-gray-500 mt-1">
            Usia remaja
          </p>
        </div>

        {{-- ANAK --}}
        <div class="rounded-lg bg-orange-50/70 border border-orange-100 p-3">
          <div class="flex items-center gap-2 mb-2">
            <span class="flex items-center justify-center
                                     w-8 h-8 rounded-lg bg-orange-100 text-orange-700">
              🧒
            </span>
            <span class="text-xs text-gray-600">Anak-anak</span>
          </div>
          <div class="text-xl font-bold text-orange-700">
            {{ number_format($totalChild ?? 0) }}
          </div>
          <p class="text-[10px] text-gray-500 mt-1">
            Usia anak-anak
          </p>
        </div>

      </div>
    </div>

    {{-- PROGRES CHECK-IN --}}
    <div class="bg-white border border-gray-200 rounded-xl p-4 sm:p-5 mb-6">

      @php
      $persentaseCheckin = ($totalReservation ?? 0) > 0
      ? (($checkedIn ?? 0) / $totalReservation) * 100
      : 0;
      @endphp

      <div class="flex justify-between items-center gap-3 mb-3">
        <div>
          <h2 class="text-sm font-bold text-gray-800">
            Progres Check-in
          </h2>
          <p class="text-xs text-gray-400 mt-1">
            Berdasarkan jumlah reservasi
          </p>
        </div>
        <span class="text-sm font-bold text-teal-600">
          {{ number_format($persentaseCheckin, 1) }}%
        </span>
      </div>

      <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
        <div class="h-full bg-teal-500 rounded-full transition-all duration-500"
          style="width: {{ min(100, max(0, $persentaseCheckin)) }}%">
        </div>
      </div>

      <div class="flex justify-between text-[11px] text-gray-500 mt-2">
        <span>{{ number_format($checkedIn ?? 0) }} sudah check-in</span>
        <span>{{ number_format($pending ?? 0) }} pending</span>
      </div>

    </div>

    {{-- MENU AKSI --}}
    <div class="flex flex-wrap gap-2">

      <a href="{{ route('admin.reservasi.scan') }}"
        class="inline-flex items-center gap-2 bg-blue-600
                      hover:bg-blue-700 text-white text-xs font-semibold
                      px-4 py-2.5 rounded-lg transition">
        <span>📷</span>
        Scan QR Check-in
      </a>

      <a href="{{ route('admin.reservasi.data') }}"
        class="inline-flex items-center gap-2 bg-white
                      hover:bg-gray-50 text-gray-700 text-xs font-semibold
                      px-4 py-2.5 rounded-lg border border-gray-200 transition">
        <span>📄</span>
        Data Reservasi
      </a>

    </div>

  </div>

</x-app-layout>