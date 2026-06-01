
<x-app-layout>
  <div class="max-w-md mx-auto py-2 px-4">

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
      {{-- Header --}}
      <div class="bg-blue-600 text-white text-center py-4">
        <h1 class="text-2xl font-bold">
          Kartu Reservasi
        </h1>
        <p class="text-sm opacity-90">
          Tunjukkan kartu ini saat check-in
        </p>
      </div>

      {{-- Body Kartu --}}
      <div
        id="reservation-card"
        class="p-6">

        <div class="text-center mb-2">

          <p class="text-gray-500 text-sm">
            No Reservasi
          </p>

          <h2 class="text-lg font-bold">
            {{ $reservation->reservation_number }}
          </h2>

        </div>

        <div class="space-y-4 text-sm">
          <div class="flex justify-between">
            <span class="font-medium text-gray-500">
              Kode Reservasi
            </span>
            <span class="font-semibold">
              {{ $reservation->reservation_code }}
            </span>
          </div>

          <div class="flex justify-between">
            <span class="font-medium text-gray-500">
              Total Peserta
            </span>

            <span class="font-semibold">
              {{ $reservation->total_participant }}
            </span>
          </div>

        </div>

        {{-- QR Code --}}
        <div class="mt-4 text-center">

          <h3 class="font-semibold mb-3">
            QR Check-in
          </h3>

          <img
            class="mx-auto w-48"
            src="{{ asset('storage/qrcodes/'.$reservation->reservation_code.'.svg') }}"
            alt="QR Code">

          <p class="text-xs text-gray-500 mt-3">
            Scan QR saat kedatangan
          </p>

        </div>
      </div>

      {{-- Footer Action --}}
      <div class="p-5 bg-gray-50">

        <button
          onclick="downloadCard()"
          class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-semibold">

          Download Kartu Reservasi

        </button>

        <a href="/reservasi/edit"
          class="block text-center mt-3 bg-yellow-500 text-white py-3 rounded-xl font-semibold">

          Update Data Reservasi

        </a>

      </div>

    </div>
  </div>

  {{-- html2canvas CDN --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

  <script>
    function downloadCard() {

      const card = document.getElementById('reservation-card');

      html2canvas(card, {
        scale: 3
      }).then(canvas => {

        const link = document.createElement('a');

        link.download =
          'kartu-reservasi-{{ $reservation->reservation_code }}.png';

        link.href = canvas.toDataURL();

        link.click();
      });
    }
  </script>
</x-app-layout>
