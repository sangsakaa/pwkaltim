<x-app-layout>

  <x-slot name="header">
    <div class="flex items-center justify-between py-1">
      <div>
        <h2 class="text-xl font-bold text-gray-800">
          Scan QR Reservasi
        </h2>
        <p class="text-xs text-gray-500">
          Scan QR untuk check-in pengunjung
        </p>
      </div>
    </div>
  </x-slot>

  <div class="h-[calc(100dvh-100px)] min-h-0 overflow-hidden px-4 py-3">
    <div class="mx-auto flex h-full max-w-7xl flex-col">

      {{-- ALERT --}}
      @foreach (['error' => 'red', 'warning' => 'yellow', 'success' => 'green'] as $type => $color)
      @if(session($type))
      <div class="mb-3 shrink-0 rounded-xl border border-{{ $color }}-200 bg-{{ $color }}-50 p-3 text-sm text-{{ $color }}-700">
        {{ session($type) }}
      </div>
      @endif
      @endforeach

      {{-- MAIN LAYOUT --}}
      <div class="grid min-h-0 flex-1 grid-cols-1 gap-4 overflow-y-auto lg:grid-cols-3 lg:overflow-hidden">

        {{-- SCANNER --}}
        <div class="flex min-h-0 flex-col lg:col-span-2">
          <div class="flex min-h-0 flex-1 flex-col overflow-hidden rounded-2xl border bg-white shadow-sm">

            <div class="shrink-0 bg-gradient-to-r from-green-700 to-green-600 px-5 py-3 text-white">
              <h3 class="text-lg font-bold">QR Scanner</h3>
              <p class="text-xs text-green-100">
                Arahkan kamera ke QR reservasi
              </p>
            </div>

            <div class="flex min-h-0 flex-1 flex-col p-3">
              <div class="flex min-h-0 flex-1 items-center justify-center overflow-hidden rounded-xl border bg-gray-50">
                <div id="reader" class="w-full max-w-2xl"></div>
              </div>

              <div class="mt-3 shrink-0 rounded-xl border border-blue-200 bg-blue-50 px-4 py-2">
                <h4 class="text-sm font-semibold text-blue-700">Tips Scan</h4>
                <p class="mt-1 text-xs text-blue-600">
                  Pastikan QR jelas • Jarak 15–30 cm • Tunggu auto detect
                </p>
              </div>
            </div>

          </div>
        </div>

        {{-- PANEL CHECK-IN --}}
        <div class="flex min-h-0 flex-col">
          <div class="flex min-h-0 flex-1 flex-col overflow-hidden rounded-2xl border bg-white shadow-sm">

            <div class="shrink-0 bg-gray-900 px-5 py-4 text-white">
              <h3 class="text-lg font-bold">Check-in Reservasi</h3>
              <p class="text-xs text-gray-300">Scan atau input manual</p>
            </div>

            <div class="flex min-h-0 flex-1 flex-col overflow-y-auto p-4">

              {{-- STATUS --}}
              <div class="mb-4 shrink-0 rounded-xl border border-green-200 bg-green-50 p-3">
                <p class="text-xs font-semibold uppercase text-green-700">
                  Status
                </p>
                <div id="scan-status" class="mt-1 text-sm text-green-700">
                  Menunggu QR code...
                </div>
              </div>

              {{-- INPUT --}}
              <div class="shrink-0">
                <label for="reservation_code" class="mb-2 block text-sm font-semibold">
                  Kode Reservasi
                </label>

                <input
                  id="reservation_code"
                  type="text"
                  class="w-full rounded-xl border-gray-300 text-sm focus:border-green-600 focus:ring-green-600"
                  placeholder="Scan atau input manual" />
              </div>

              {{-- BUTTON --}}
              <button
                type="button"
                onclick="manualCheckin()"
                class="mt-4 w-full shrink-0 rounded-xl bg-green-600 py-3 text-sm font-semibold text-white transition hover:bg-green-700">
                ✓ Check-in
              </button>

              {{-- ACTION --}}
              <div class="mt-3 grid shrink-0 grid-cols-2 gap-3">
                <button
                  type="button"
                  onclick="clearInput()"
                  class="rounded-xl bg-gray-100 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-200">
                  Reset
                </button>

                <a
                  href="{{ route('admin.reservasi.data') }}"
                  class="rounded-xl bg-blue-600 py-3 text-center text-sm font-semibold text-white hover:bg-blue-700">
                  Data
                </a>
              </div>

            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  {{-- LIBRARY SCANNER --}}
  <script src="https://unpkg.com/html5-qrcode"></script>

  {{-- SOUND --}}
  <audio id="success-sound" src="https://actions.google.com/sounds/v1/cartoon/clang_and_wobble.ogg" preload="auto"></audio>
  <audio id="error-sound" src="https://actions.google.com/sounds/v1/cartoon/cartoon_boing.ogg" preload="auto"></audio>

  <script>
    let lastScan = '';

    function playSuccess() {
      document.getElementById('success-sound').play().catch(() => {});
    }

    function playError() {
      document.getElementById('error-sound').play().catch(() => {});
    }

    function updateStatus(html) {
      document.getElementById('scan-status').innerHTML = html;
    }

    function clearInput() {
      document.getElementById('reservation_code').value = '';
      updateStatus('Menunggu QR code...');
      lastScan = '';
    }

    async function manualCheckin() {
      const code = document.getElementById('reservation_code').value.trim();

      if (!code) {
        playError();
        updateStatus('<div class="font-semibold text-red-600">⚠️ Kode kosong</div>');
        return;
      }

      updateStatus('<div class="animate-pulse text-blue-600">⏳ Memproses...</div>');

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
          updateStatus(`<div class="font-semibold text-red-600">❌ ${data.message ?? 'Check-in gagal'}</div>`);
          return;
        }

        playSuccess();

        const result = data.data ?? {};

        updateStatus(`
          <div class="space-y-2 text-green-700">
            <div class="text-lg font-bold">✅ CHECK-IN BERHASIL</div>
            <div class="space-y-1 rounded-xl border bg-white p-3 text-sm">
              <div>
                <span class="font-semibold">Ketua Rombongan:</span><br>
                ${result.ketua_rombongan ?? '-'}
              </div>
              <div>
                <span class="font-semibold">No Reservasi:</span><br>
                ${result.reservation_number ?? '-'}
              </div>
              <div>
                <span class="font-semibold">Kode:</span><br>
                ${result.reservation_code ?? '-'}
              </div>
              <div>
                <span class="font-semibold">Total Peserta:</span><br>
                ${result.participant ?? 0}
              </div>
            </div>
          </div>
        `);

      } catch (err) {
        playError();
        updateStatus('<div class="text-red-600">❌ Server error</div>');
      }
    }

    function onScanSuccess(decodedText) {
      if (decodedText === lastScan) return;

      lastScan = decodedText;
      document.getElementById('reservation_code').value = decodedText;

      manualCheckin();

      setTimeout(() => {
        lastScan = '';
      }, 2500);
    }

    new Html5QrcodeScanner("reader", {
      fps: 10,
      qrbox: {
        width: 220,
        height: 220
      }
    }).render(onScanSuccess);
  </script>

  {{-- BATASI TINGGI AREA SCANNER --}}
  <style>
    #reader {
      border: 0 !important;
    }

    #reader video {
      max-height: 48vh !important;
      object-fit: cover;
    }

    #reader img {
      display: inline-block;
    }

    #reader__scan_region {
      min-height: 0 !important;
    }

    #reader__dashboard_section_csr button,
    #reader__dashboard_section_swaplink {
      margin: 4px !important;
    }

    @media (min-width: 1024px) {
      #reader video {
        max-height: 48vh !important;
      }
    }
  </style>

</x-app-layout>