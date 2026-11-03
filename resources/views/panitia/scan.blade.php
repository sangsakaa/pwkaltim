<x-app-layout>

  {{-- HEADER --}}
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

  <div class="min-h-[calc(100dvh-180px)] px-3 py-4 sm:px-4 lg:h-[calc(100dvh-180px)] lg:min-h-0 lg:overflow-hidden">

    <div class="mx-auto flex max-w-7xl flex-col gap-4 lg:h-full">

      {{-- ALERT --}}
      @foreach ([
      'error' => 'red',
      'warning' => 'yellow',
      'success' => 'green'
      ] as $type => $color)

      @if(session($type))
      <div class="shrink-0 rounded-xl border border-{{ $color }}-200 bg-{{ $color }}-50 p-3 text-sm text-{{ $color }}-700">
        {{ session($type) }}
      </div>
      @endif

      @endforeach

      {{-- MAIN LAYOUT --}}
      <div class="grid grid-cols-1 gap-4 lg:min-h-0 lg:flex-1 lg:grid-cols-3 lg:overflow-hidden">

        {{-- ========================================= --}}
        {{-- QR SCANNER --}}
        {{-- ========================================= --}}

        <div class="flex min-w-0 flex-col lg:col-span-2 lg:min-h-0">

          <div class="overflow-hidden rounded-2xl border bg-white shadow-sm lg:flex lg:min-h-0 lg:flex-1 lg:flex-col">

            {{-- HEADER SCANNER --}}
            <div class="shrink-0 bg-gradient-to-r from-green-700 to-green-600 px-5 py-4 text-white">

              <div class="flex items-center justify-between gap-3">

                <div>
                  <h3 class="text-xl font-bold">
                    QR Scanner
                  </h3>

                  <p class="mt-1 text-sm text-green-100">
                    Arahkan kamera belakang ke QR reservasi
                  </p>
                </div>

                <div class="rounded-xl bg-white/20 p-3">
                  <svg xmlns="http://www.w3.org/2000/svg"
                    width="28"
                    height="28"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2">
                    <rect x="3" y="3" width="7" height="7" />
                    <rect x="14" y="3" width="7" height="7" />
                    <rect x="3" y="14" width="7" height="7" />
                    <path d="M14 14h3v3h-3z" />
                    <path d="M21 14v7" />
                    <path d="M14 21h3" />
                  </svg>
                </div>

              </div>
            </div>

            {{-- AREA KAMERA --}}
            <div class="flex flex-col gap-3 p-3 sm:p-4 lg:min-h-0 lg:flex-1">

              {{-- CAMERA PREVIEW --}}
              <div class="relative flex min-h-[280px] items-center justify-center overflow-hidden rounded-xl border border-gray-800 bg-black sm:min-h-[350px] lg:min-h-0 lg:flex-1">

                <div id="reader"
                  class="w-full">
                </div>

                {{-- OVERLAY STATUS --}}
                <div id="camera-placeholder"
                  class="absolute inset-0 flex flex-col items-center justify-center bg-gray-950 px-5 text-center text-white">

                  <svg xmlns="http://www.w3.org/2000/svg"
                    width="55"
                    height="55"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.5"
                    class="mb-3 text-gray-400">
                    <path d="M14 4h-4l-2 3H5a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3z" />
                    <circle cx="12" cy="13" r="3" />
                  </svg>

                  <p class="font-semibold">
                    Kamera belum aktif
                  </p>

                  <p class="mt-1 text-xs text-gray-400">
                    Tekan tombol mulai kamera
                  </p>

                </div>

              </div>

              {{-- CAMERA CONTROLS --}}
              <div class="grid grid-cols-2 gap-2 sm:grid-cols-4">

                <button type="button"
                  id="btn-start"
                  onclick="startScanner()"
                  class="rounded-xl bg-green-600 px-3 py-3 text-sm font-semibold text-white hover:bg-green-700">
                  ▶ Mulai Kamera
                </button>

                <button type="button"
                  id="btn-stop"
                  onclick="stopScanner()"
                  disabled
                  class="rounded-xl bg-red-600 px-3 py-3 text-sm font-semibold text-white hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-40">
                  ■ Stop Kamera
                </button>

                <button type="button"
                  id="btn-switch"
                  onclick="switchCamera()"
                  disabled
                  class="rounded-xl bg-blue-600 px-3 py-3 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-40">
                  ↻ Ganti Kamera
                </button>

                <button type="button"
                  id="btn-torch"
                  onclick="toggleTorch()"
                  disabled
                  class="rounded-xl bg-yellow-500 px-3 py-3 text-sm font-semibold text-white hover:bg-yellow-600 disabled:cursor-not-allowed disabled:opacity-40">
                  ☀ Senter
                </button>

              </div>

              {{-- CAMERA SELECT --}}
              <div>
                <label for="camera-select"
                  class="mb-1 block text-xs font-semibold text-gray-600">
                  Pilih Kamera
                </label>

                <select id="camera-select"
                  onchange="changeCamera(this.value)"
                  class="w-full rounded-xl border-gray-300 text-sm focus:border-green-600 focus:ring-green-600">
                  <option value="">
                    Kamera otomatis
                  </option>
                </select>
              </div>

              {{-- TIPS --}}
              <div class="shrink-0 rounded-xl border border-blue-200 bg-blue-50 px-4 py-3">

                <h4 class="text-sm font-semibold text-blue-700">
                  Tips Scan
                </h4>

                <p class="mt-1 text-xs leading-relaxed text-blue-600">
                  Pastikan QR terlihat jelas, arahkan kamera belakang ke QR,
                  jaga jarak sekitar 15–30 cm, dan hindari pantulan cahaya.
                </p>

              </div>

            </div>

          </div>

        </div>

        {{-- ========================================= --}}
        {{-- PANEL CHECK-IN --}}
        {{-- ========================================= --}}

        <div class="flex min-w-0 flex-col lg:min-h-0">

          <div class="overflow-hidden rounded-2xl border bg-white shadow-sm lg:flex lg:min-h-0 lg:flex-1 lg:flex-col">

            {{-- HEADER --}}
            <div class="shrink-0 bg-gray-900 px-5 py-4 text-white">

              <h3 class="text-xl font-bold">
                Check-in Reservasi
              </h3>

              <p class="mt-1 text-sm text-gray-300">
                Scan atau input kode secara manual
              </p>

            </div>

            <div class="flex flex-col gap-4 p-4 lg:min-h-0 lg:flex-1 lg:overflow-y-auto">

              {{-- STATUS --}}
              <div class="rounded-xl border border-green-200 bg-green-50 p-3">

                <p class="text-xs font-bold uppercase tracking-wide text-green-700">
                  Status
                </p>

                <div id="scan-status"
                  class="mt-2 text-sm text-green-700">
                  Menunggu QR code...
                </div>

              </div>

              {{-- INPUT --}}
              <div>

                <label for="reservation_code"
                  class="mb-2 block text-sm font-semibold text-gray-700">
                  Kode Reservasi
                </label>

                <input
                  id="reservation_code"
                  type="text"
                  autocomplete="off"
                  class="w-full rounded-xl border-gray-300 text-sm uppercase focus:border-green-600 focus:ring-green-600"
                  placeholder="Masukkan kode reservasi">

              </div>

              {{-- CHECK-IN BUTTON --}}
              <button
                type="button"
                id="btn-checkin"
                onclick="manualCheckin()"
                class="w-full rounded-xl bg-green-600 py-3 text-sm font-bold text-white transition hover:bg-green-700">

                ✓ Check-in Reservasi

              </button>

              {{-- ACTION BUTTONS --}}
              <div class="grid grid-cols-2 gap-3">

                <button
                  type="button"
                  onclick="clearInput()"
                  class="rounded-xl bg-gray-100 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-200">

                  Reset

                </button>

                <a
                  href="{{ route('admin.reservasi.data') }}"
                  class="rounded-xl bg-blue-600 py-3 text-center text-sm font-semibold text-white hover:bg-blue-700">

                  Data Reservasi

                </a>

              </div>

              {{-- PETUNJUK --}}
              <div class="rounded-xl border border-gray-200 bg-gray-50 p-3">

                <h4 class="text-sm font-semibold text-gray-700">
                  Petunjuk Penggunaan
                </h4>

                <ol class="mt-2 list-inside list-decimal space-y-1 text-xs leading-relaxed text-gray-500">
                  <li>Tekan tombol Mulai Kamera.</li>
                  <li>Izinkan akses kamera pada browser.</li>
                  <li>Arahkan kamera ke QR reservasi.</li>
                  <li>Sistem akan memproses check-in otomatis.</li>
                  <li>Pastikan status check-in berhasil.</li>
                </ol>

              </div>

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

  {{-- ========================================= --}}
  {{-- LIBRARY --}}
  {{-- ========================================= --}}

  <script src="https://unpkg.com/html5-qrcode"></script>

  {{-- SOUND --}}
  <audio id="success-sound"
    src="https://actions.google.com/sounds/v1/cartoon/clang_and_wobble.ogg"
    preload="auto"></audio>

  <audio id="error-sound"
    src="https://actions.google.com/sounds/v1/cartoon/cartoon_boing.ogg"
    preload="auto"></audio>


  {{-- ========================================= --}}
  {{-- JAVASCRIPT --}}
  {{-- ========================================= --}}

  <script>
    let html5QrCode = null;

    let cameras = [];

    let currentCameraId = null;

    let isScanning = false;

    let isProcessing = false;

    let lastScan = '';

    let torchEnabled = false;


    // =====================================
    // ELEMENT
    // =====================================

    const reader = document.getElementById('reader');

    const cameraPlaceholder = document.getElementById('camera-placeholder');

    const cameraSelect = document.getElementById('camera-select');

    const statusElement = document.getElementById('scan-status');

    const codeInput = document.getElementById('reservation_code');

    const btnStart = document.getElementById('btn-start');

    const btnStop = document.getElementById('btn-stop');

    const btnSwitch = document.getElementById('btn-switch');

    const btnTorch = document.getElementById('btn-torch');

    const btnCheckin = document.getElementById('btn-checkin');


    // =====================================
    // SOUND
    // =====================================

    function playSuccess() {

      const sound = document.getElementById('success-sound');

      sound.currentTime = 0;

      sound.play().catch(() => {});

    }


    function playError() {

      const sound = document.getElementById('error-sound');

      sound.currentTime = 0;

      sound.play().catch(() => {});

    }


    // =====================================
    // STATUS
    // =====================================

    function updateStatus(message, color = 'green') {

      const colors = {
        green: 'text-green-700',
        red: 'text-red-600',
        blue: 'text-blue-600',
        yellow: 'text-yellow-700'
      };

      statusElement.className = 'mt-2 text-sm ' + (colors[color] || colors.green);

      statusElement.textContent = message;

    }


    // =====================================
    // HTML ESCAPE
    // =====================================

    function escapeHtml(value) {

      return String(value ?? '-').replace(/[&<>"']/g, function(char) {

        return {
          '&': '&amp;',
          '<': '&lt;',
          '>': '&gt;',
          '"': '&quot;',
          "'": '&#039;'
        } [char];

      });

    }


    // =====================================
    // GET CAMERA LIST
    // =====================================

    async function getCameraList() {

      try {

        cameras = await Html5Qrcode.getCameras();

        cameraSelect.innerHTML = '';

        if (!cameras.length) {

          cameraSelect.innerHTML = '<option value="">Kamera tidak ditemukan</option>';

          return;

        }

        cameras.forEach((camera, index) => {

          const option = document.createElement('option');

          option.value = camera.id;

          option.textContent = camera.label || 'Kamera ' + (index + 1);

          cameraSelect.appendChild(option);

        });

        btnSwitch.disabled = cameras.length < 2;

      } catch (error) {

        console.error('Gagal mendapatkan kamera:', error);

        updateStatus('Tidak dapat mengakses daftar kamera.', 'red');

      }

    }


    // =====================================
    // PILIH KAMERA BELAKANG
    // =====================================

    function getBackCamera() {

      if (!cameras.length) return null;

      // Cari kamera berdasarkan nama
      let backCamera = cameras.find(camera => {

        return /back|rear|environment|belakang/i.test(camera.label);

      });

      // Jika tidak ditemukan, coba kamera terakhir.
      // Pada banyak HP, kamera belakang muncul setelah kamera depan.
      if (!backCamera && cameras.length > 1) {

        backCamera = cameras[cameras.length - 1];

      }

      return backCamera || cameras[0];

    }


    // =====================================
    // START CAMERA
    // =====================================

    async function startScanner(cameraId = null) {

      if (isScanning) return;

      try {

        btnStart.disabled = true;

        btnStart.textContent = 'Memulai...';

        updateStatus('Mengaktifkan kamera...', 'blue');

        cameraPlaceholder.classList.remove('hidden');

        if (!html5QrCode) {

          html5QrCode = new Html5Qrcode('reader');

        }

        let cameraConfig;

        if (cameraId) {

          cameraConfig = cameraId;

        } else {

          // Prioritaskan kamera belakang
          cameraConfig = {
            facingMode: 'environment'
          };

        }

        const config = {

          fps: 15,

          qrbox: function(viewfinderWidth, viewfinderHeight) {

            const minEdge = Math.min(
              viewfinderWidth,
              viewfinderHeight
            );

            const qrSize = Math.floor(
              Math.min(minEdge * 0.75, 280)
            );

            return {
              width: qrSize,
              height: qrSize
            };

          },

          disableFlip: false

        };

        try {

          await html5QrCode.start(
            cameraConfig,
            config,
            onScanSuccess,
            onScanFailure
          );

        } catch (firstError) {

          // Jika facingMode tidak berhasil,
          // coba daftar kamera yang tersedia.

          if (cameraId) throw firstError;

          await getCameraList();

          const backCamera = getBackCamera();

          if (!backCamera) throw firstError;

          cameraConfig = backCamera.id;

          await html5QrCode.start(
            cameraConfig,
            config,
            onScanSuccess,
            onScanFailure
          );

        }

        isScanning = true;

        currentCameraId = cameraConfig;

        cameraPlaceholder.classList.add('hidden');

        btnStart.disabled = true;

        btnStart.textContent = '✓ Kamera Aktif';

        btnStop.disabled = false;

        btnSwitch.disabled = cameras.length < 2;

        btnTorch.disabled = false;

        await getCameraList();

        if (typeof currentCameraId === 'string') {

          cameraSelect.value = currentCameraId;

        }

        updateStatus('Kamera aktif. Arahkan ke QR reservasi.', 'green');

      } catch (error) {

        console.error('Camera error:', error);

        isScanning = false;

        cameraPlaceholder.classList.remove('hidden');

        btnStart.disabled = false;

        btnStart.textContent = '▶ Mulai Kamera';

        btnStop.disabled = true;

        btnTorch.disabled = true;

        updateStatus(
          'Kamera gagal dibuka. Periksa izin kamera dan pastikan halaman menggunakan HTTPS.',
          'red'
        );

        playError();

      }

    }


    // =====================================
    // STOP CAMERA
    // =====================================

    async function stopScanner() {

      if (!html5QrCode || !isScanning) return;

      try {

        await html5QrCode.stop();

        isScanning = false;

        torchEnabled = false;

        cameraPlaceholder.classList.remove('hidden');

        btnStart.disabled = false;

        btnStart.textContent = '▶ Mulai Kamera';

        btnStop.disabled = true;

        btnTorch.disabled = true;

        updateStatus('Kamera dihentikan.', 'yellow');

      } catch (error) {

        console.error('Stop camera error:', error);

      }

    }


    // =====================================
    // SWITCH CAMERA
    // =====================================

    async function switchCamera() {

      if (!cameras.length) {

        await getCameraList();

      }

      if (cameras.length < 2) {

        updateStatus('Perangkat hanya menyediakan satu kamera.', 'red');

        return;

      }

      let currentIndex = cameras.findIndex(camera => {

        return camera.id === currentCameraId;

      });

      let nextIndex = (currentIndex + 1) % cameras.length;

      const nextCamera = cameras[nextIndex];

      await stopScanner();

      await startScanner(nextCamera.id);

    }


    // =====================================
    // CHANGE CAMERA
    // =====================================

    async function changeCamera(cameraId) {

      if (!cameraId) return;

      await stopScanner();

      await startScanner(cameraId);

    }


    // =====================================
    // TORCH / FLASH
    // =====================================

    async function toggleTorch() {

      if (!html5QrCode || !isScanning) return;

      try {

        torchEnabled = !torchEnabled;

        await html5QrCode.applyVideoConstraints({

          advanced: [{
            torch: torchEnabled
          }]

        });

        btnTorch.textContent = torchEnabled ?
          '☀ Senter Aktif' :
          '☀ Senter';

      } catch (error) {

        torchEnabled = false;

        updateStatus(
          'Fitur senter tidak didukung oleh kamera ini.',
          'yellow'
        );

      }

    }


    // =====================================
    // SCAN SUCCESS
    // =====================================

    function onScanSuccess(decodedText) {

      if (isProcessing) return;

      if (decodedText === lastScan) return;

      lastScan = decodedText;

      codeInput.value = decodedText;

      manualCheckin();

    }


    function onScanFailure(error) {

      // Tidak perlu menampilkan error setiap frame.
      // Scanner memang terus mencari QR code.

    }


    // =====================================
    // MANUAL CHECK-IN
    // =====================================

    async function manualCheckin() {

      const code = codeInput.value.trim();

      if (!code) {

        playError();

        updateStatus('Kode reservasi belum diisi.', 'red');

        return;

      }

      if (isProcessing) return;

      isProcessing = true;

      btnCheckin.disabled = true;

      btnCheckin.textContent = 'Memproses...';

      updateStatus('Sedang memproses check-in...', 'blue');

      try {

        const response = await fetch(
          "{{ route('admin.reservasi.checkin') }}", {
            method: 'POST',

            headers: {

              'Content-Type': 'application/json',

              'Accept': 'application/json',

              'X-CSRF-TOKEN': document.querySelector(
                'meta[name="csrf-token"]'
              ).content

            },

            body: JSON.stringify({

              reservation_code: code

            })

          }
        );

        const data = await response.json();

        if (!response.ok) {

          playError();

          updateStatus(
            data.message || 'Check-in gagal.',
            'red'
          );

          lastScan = '';

          return;

        }

        playSuccess();

        const result = data.data || {};

        const participant = result.participant ?? 0;

        statusElement.className = 'mt-2 text-sm text-green-700';

        statusElement.innerHTML = `

                    <div class="space-y-3">

                        <div class="text-lg font-bold text-green-700">
                            ✓ CHECK-IN BERHASIL
                        </div>

                        <div class="rounded-xl border border-green-200 bg-white p-3 text-sm">

                            <div class="mb-3">
                                <div class="text-xs text-gray-500">
                                    Ketua Rombongan
                                </div>

                                <div class="font-bold text-gray-800">
                                    ${escapeHtml(result.ketua_rombongan)}
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="text-xs text-gray-500">
                                    Nomor Reservasi
                                </div>

                                <div class="font-semibold text-gray-800">
                                    ${escapeHtml(result.reservation_number)}
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="text-xs text-gray-500">
                                    Kode Reservasi
                                </div>

                                <div class="font-semibold text-gray-800">
                                    ${escapeHtml(result.reservation_code)}
                                </div>
                            </div>

                            <div>
                                <div class="text-xs text-gray-500">
                                    Total Peserta
                                </div>

                                <div class="text-xl font-bold text-green-700">
                                    ${escapeHtml(participant)} Orang
                                </div>
                            </div>

                        </div>

                    </div>

                `;

        // Hentikan scanner setelah berhasil
        if (isScanning) {

          await stopScanner();

        }

      } catch (error) {

        console.error(error);

        playError();

        updateStatus(
          'Server error. Periksa koneksi internet atau respons server.',
          'red'
        );

      } finally {

        isProcessing = false;

        btnCheckin.disabled = false;

        btnCheckin.textContent = '✓ Check-in Reservasi';

      }

    }


    // =====================================
    // RESET
    // =====================================

    function clearInput() {

      codeInput.value = '';

      lastScan = '';

      isProcessing = false;

      updateStatus('Menunggu QR code...', 'green');

      codeInput.focus();

    }


    // =====================================
    // ENTER INPUT MANUAL
    // =====================================

    codeInput.addEventListener('keydown', function(event) {

      if (event.key === 'Enter') {

        event.preventDefault();

        manualCheckin();

      }

    });


    // =====================================
    // RESPONSIVE CAMERA
    // =====================================

    window.addEventListener('beforeunload', function() {

      if (html5QrCode && isScanning) {

        html5QrCode.stop().catch(() => {});

      }

    });
  </script>


  {{-- ========================================= --}}
  {{-- CSS RESPONSIVE SCANNER --}}
  {{-- ========================================= --}}

  <style>
    #reader {
      width: 100% !important;
      border: 0 !important;
      background: #000 !important;
    }

    #reader video {
      display: block !important;
      width: 100% !important;
      height: auto !important;
      max-height: 55vh !important;
      object-fit: contain !important;
      background: #000 !important;
    }

    #reader canvas {
      max-width: 100% !important;
    }

    #reader__scan_region {
      width: 100% !important;
      min-height: 250px !important;
      background: #000 !important;
    }

    #reader__scan_region img {
      display: none !important;
    }

    #reader__dashboard {
      width: 100% !important;
      padding: 5px !important;
      background: white !important;
    }

    #reader__dashboard_section_csr {
      text-align: center !important;
    }

    #reader__dashboard_section_csr button {
      margin: 5px !important;
      padding: 8px 12px !important;
      border-radius: 8px !important;
      background: #15803d !important;
      color: white !important;
      font-size: 13px !important;
    }

    #reader__dashboard_section_swaplink {
      color: #15803d !important;
      font-size: 13px !important;
    }

    @media (max-width: 640px) {

      #reader video {
        max-height: 45vh !important;
        object-fit: contain !important;
      }

      #reader__scan_region {
        min-height: 260px !important;
      }

    }

    @media (min-width: 1024px) {

      #reader video {
        max-height: 55vh !important;
      }

    }
  </style>

</x-app-layout>