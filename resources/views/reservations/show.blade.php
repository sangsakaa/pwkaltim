<x-app-layout>

  <div class="max-w-md mx-auto py-6 px-4">

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden">

      {{-- HEADER --}}
      <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white text-center py-5">
        <h1 class="text-2xl font-bold">
          Kartu Reservasi
        </h1>
        <p class="text-sm opacity-90">
          Tunjukkan kartu ini saat check-in
        </p>
      </div>

      {{-- BODY --}}
      <div id="reservation-card" class="p-6 space-y-4">

        {{-- NO RESERVASI --}}
        <div class="text-center">
          <p class="text-gray-500 text-sm">No Reservasi</p>
          <h2 class="text-lg font-bold text-gray-800">
            {{ $reservation->reservation_number ?? '-' }}
          </h2>

          <span class="inline-block mt-2 px-3 py-1 text-xs rounded-full
            {{ $reservation->status === 'checked_in' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
            {{ strtoupper($reservation->status ?? 'pending') }}
          </span>
        </div>

        {{-- DATA --}}
        <div class="space-y-3 text-sm border-t pt-4">

          <div class="flex justify-between">
            <span class="text-gray-500">Ketua Rombongan</span>
            <span class="font-semibold text-gray-800">
              {{ $reservation->ketua_rombongan ?? '-' }}
            </span>
          </div>

          <div class="flex justify-between">
            <span class="text-gray-500">Kode Reservasi</span>
            <span class="font-semibold text-gray-800">
              {{ $reservation->reservation_code ?? '-' }}
            </span>
          </div>

          <div class="flex justify-between">
            <span class="text-gray-500">Total Peserta</span>
            <span class="font-semibold text-gray-800">
              {{ $reservation->total_participant ?? 0 }}
            </span>
          </div>

        </div>

        {{-- DETAIL PESERTA --}}
        <div class="grid grid-cols-2 gap-2 text-xs text-gray-600 border-t pt-3">

          <div>Bapak: {{ $reservation->total_father ?? 0 }}</div>
          <div>Ibu: {{ $reservation->total_mother ?? 0 }}</div>
          <div>Remaja: {{ $reservation->total_teenager ?? 0 }}</div>
          <div>Anak: {{ $reservation->total_child ?? 0 }}</div>

        </div>

        {{-- QR --}}
        <div class="text-center border-t pt-4">

          <h3 class="font-semibold mb-3 text-gray-700">
            QR Check-in
          </h3>

          <img
            class="mx-auto w-44 rounded-xl shadow"
            src="{{ asset('storage/qrcodes/'.$reservation->reservation_code.'.svg') }}"
            alt="QR Code">

          <p class="text-xs text-gray-400 mt-3">
            Scan QR saat kedatangan
          </p>

        </div>
      </div>

      {{-- FOOTER --}}
      <div class="p-5 bg-gray-50 space-y-3">

        <button
          onclick="downloadCard()"
          class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-semibold shadow">

          Download Kartu Reservasi
        </button>

        <a href="{{ route('reservasi.edit', $reservation->id) }}"
          class="block text-center bg-yellow-500 hover:bg-yellow-600 text-white py-3 rounded-xl font-semibold">

          Update Data Reservasi
        </a>

      </div>

    </div>
  </div>

  {{-- html2canvas --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

  <script>
    function downloadCard() {
      const card = document.getElementById('reservation-card');

      html2canvas(card, {
        scale: 3,
        useCORS: true
      }).then(canvas => {

        const link = document.createElement('a');

        link.download =
          'kartu-reservasi-{{ $reservation->reservation_code }}.png';

        link.href = canvas.toDataURL('image/png');

        link.click();
      });
    }
  </script>

</x-app-layout>