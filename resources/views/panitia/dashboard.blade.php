<x-app-layout>

  <div class="max-w-7xl mx-auto py-10 px-4">

    <h1 class="text-3xl font-bold mb-8">
      Dashboard Reservasi
    </h1>

    @if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded mb-5">
      {{ session('success') }}
    </div>
    @endif

    <div class="grid md:grid-cols-3 gap-5">

      <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="text-gray-500">
          Total Reservasi
        </h2>

        <p class="text-4xl font-bold">
          {{ $totalReservation }}
        </p>
      </div>

      <div class="bg-green-100 p-6 rounded-xl shadow">
        <h2 class="text-gray-600">
          Sudah Check-in
        </h2>

        <p class="text-4xl font-bold">
          {{ $checkedIn }}
        </p>
      </div>

      <div class="bg-yellow-100 p-6 rounded-xl shadow">
        <h2 class="text-gray-600">
          Pending
        </h2>

        <p class="text-4xl font-bold">
          {{ $pending }}
        </p>
      </div>

    </div>

    <div class="mt-8">
      <a href="{{ route('admin.reservasi.scan') }}"
        class="bg-blue-600 text-white px-5 py-3 rounded-lg">
        Scan QR Check-in
      </a>
    </div>

  </div>

</x-app-layout>