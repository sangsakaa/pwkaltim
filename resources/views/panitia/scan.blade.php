<x-app-layout>

  <x-slot name="header">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-2xl font-bold text-gray-800">
          Scan QR Reservasi
        </h2>
        <p class="text-sm text-gray-500">
          Scan QR untuk check-in pengunjung
        </p>
      </div>
    </div>
  </x-slot>

  <div class="py-6 px-4">
    <div class="max-w-5xl mx-auto">

      {{-- ALERT --}}
      @foreach (['error' => 'red', 'warning' => 'yellow', 'success' => 'green'] as $type => $color)
      @if(session($type))
      <div class="mb-5 rounded-2xl border border-{{ $color }}-200 bg-{{ $color }}-50 p-4 text-{{ $color }}-700">
        {{ session($type) }}
      </div>
      @endif
      @endforeach

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- SCANNER --}}
        <div class="lg:col-span-2">
          <div class="bg-white rounded-3xl shadow border overflow-hidden">

            <div class="bg-gradient-to-r from-green-700 to-green-600 px-6 py-5 text-white">
              <h3 class="font-bold text-xl">QR Scanner</h3>
              <p class="text-green-100 text-sm">Arahkan kamera ke QR reservasi</p>
            </div>

            <div class="p-5">
              <div class="rounded-3xl border bg-gray-50 overflow-hidden">
                <div id="reader"></div>
              </div>

              <div class="mt-5 bg-blue-50 border border-blue-200 p-4 rounded-2xl">
                <h4 class="font-semibold text-blue-700">Tips Scan</h4>
                <ul class="text-sm text-blue-600 mt-2 list-disc ml-4">
                  <li>Pastikan QR jelas</li>
                  <li>Jarak 15–30 cm</li>
                  <li>Tunggu auto detect</li>
                </ul>
              </div>
            </div>

          </div>
        </div>

        {{-- PANEL --}}
        <div>

          <div class="bg-white rounded-3xl shadow border sticky top-5 overflow-hidden">

            <div class="bg-gray-900 text-white px-6 py-5">
              <h3 class="font-bold text-lg">Check-in Reservasi</h3>
              <p class="text-sm text-gray-300">Scan atau manual</p>
            </div>

            <div class="p-6">

              {{-- STATUS --}}
              <div class="mb-5 bg-green-50 border border-green-200 p-4 rounded-2xl">
                <p class="text-xs text-green-700 font-semibold uppercase">Status</p>
                <div id="scan-status" class="text-sm text-green-700 mt-1">
                  Menunggu QR code...
                </div>
              </div>

              {{-- INPUT --}}
              <label class="block font-semibold mb-2">Kode Reservasi</label>
              <input
                id="reservation_code"
                type="text"
                class="w-full rounded-2xl border-gray-300 focus:ring-green-600 focus:border-green-600"
                placeholder="Scan atau input manual" />

              {{-- BUTTON --}}
              <button
                onclick="manualCheckin()"
                class="w-full mt-5 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-2xl">
                ✓ Check-in
              </button>

              {{-- ACTION --}}
              <div class="grid grid-cols-2 gap-3 mt-4">

                <button onclick="clearInput()" class="bg-gray-100 rounded-2xl py-3">
                  Reset
                </button>

                <a href="{{ route('admin.reservasi.data') }}"
                  class="bg-blue-600 text-white text-center rounded-2xl py-3">
                  Data
                </a>

              </div>

            </div>
          </div>

        </div>

      </div>
    </div>
  </div>

  {{-- LIB --}}
  <script src="https://unpkg.com/html5-qrcode"></script>

  {{-- SOUND --}}
  <audio id="success-sound" src="https://actions.google.com/sounds/v1/cartoon/clang_and_wobble.ogg" preload="auto"></audio>
  <audio id="error-sound" src="https://actions.google.com/sounds/v1/cartoon/cartoon_boing.ogg" preload="auto"></audio>

  <script>
    let lastScan = '';

    function playSuccess() {
      document.getElementById('success-sound').play();
    }

    function playError() {
      document.getElementById('error-sound').play();
    }

    function updateStatus(html) {
      document.getElementById('scan-status').innerHTML = html;
    }

    function clearInput() {
      document.getElementById('reservation_code').value = '';
      updateStatus('Menunggu QR code...');
    }

    async function manualCheckin() {
      const code = document.getElementById('reservation_code').value.trim();

      if (!code) {
        playError();
        updateStatus(`<div class="text-red-600 font-semibold">⚠️ Kode kosong</div>`);
        return;
      }

      updateStatus(`<div class="text-blue-600 animate-pulse">⏳ Memproses...</div>`);

      try {
        const res = await fetch("{{ route('admin.reservasi.checkin') }}", {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          },
          body: JSON.stringify({
            reservation_code: code
          })
        });

        const data = await res.json();

        if (!res.ok) {
          playError();
          updateStatus(`<div class="text-red-600 font-semibold">❌ ${data.message}</div>`);
          return;
        }

        playSuccess();

        updateStatus(`
          <div class="text-green-700 space-y-2">

            <div class="font-bold text-lg">
              ✅ CHECK-IN BERHASIL
            </div>

            <div class="bg-white border rounded-xl p-3 text-sm space-y-1">

              <div>
                <span class="font-semibold">Ketua Rombongan:</span><br>
                ${data.data.ketua_rombongan ?? '-'}
              </div>

              <div>
                <span class="font-semibold">No Reservasi:</span><br>
                ${data.data.reservation_number}
              </div>

              <div>
                <span class="font-semibold">Kode:</span><br>
                ${data.data.reservation_code}
              </div>

              <div>
                <span class="font-semibold">Total Peserta:</span><br>
                ${data.data.participant ?? 0}
              </div>

            </div>

          </div>
        `);

      } catch (err) {
        playError();
        updateStatus(`<div class="text-red-600">❌ Server error</div>`);
      }
    }

    function onScanSuccess(decodedText) {
      if (decodedText === lastScan) return;

      lastScan = decodedText;
      document.getElementById('reservation_code').value = decodedText;

      manualCheckin();

      setTimeout(() => lastScan = '', 2500);
    }

    new Html5QrcodeScanner("reader", {
      fps: 10,
      qrbox: {
        width: 260,
        height: 260
      }
    }).render(onScanSuccess);
  </script>

</x-app-layout>