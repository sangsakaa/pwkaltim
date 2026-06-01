<x-app-layout>

  @section('title', 'Reservasi Pengunjung')

  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="text-xl font-bold text-gray-800">
        Reservasi Pengunjung
      </h2>
    </div>
  </x-slot>

  <div class="space-y-6">

    {{-- FLASH MESSAGE --}}
    @if(session('success'))
    <div class="rounded-lg bg-green-100 border border-green-200 text-green-700 p-4">
      {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="rounded-lg bg-red-100 border border-red-200 text-red-700 p-4">
      {{ session('error') }}
    </div>
    @endif

    {{-- INFO --}}
    <div class="rounded-lg bg-blue-100 text-blue-700 p-4">
      Form Reservasi Pengunjung (Publik)
    </div>

    {{-- HEADER CARD --}}
    <div class="bg-gradient-to-r from-green-800 to-green-600 text-white rounded-xl shadow flex overflow-hidden">

      <div class="bg-green-900 flex items-center justify-center p-4">
        <img src="{{ asset('image/logo.png') }}" class="w-12 h-12" alt="logo">
      </div>

      <div class="p-4">
        <h3 class="text-lg font-bold uppercase">
          Reservasi Pengunjung
        </h3>
        <p class="text-sm text-green-100">
          Form reservasi kedatangan pengunjung
        </p>
      </div>

    </div>

    {{-- NOTE --}}
    <div class="rounded-lg bg-yellow-50 border border-yellow-300 text-yellow-800 p-4 text-sm">
      <p class="font-bold">⚠️ Perhatian Pengisian Form</p>
      <ul class="list-disc ml-5 mt-2 space-y-1">
        <li>Kolom bertanda <span class="text-red-600 font-bold">*</span> wajib diisi</li>
        <li>Pastikan wilayah dan jumlah peserta benar</li>
        <li>QR Code akan dibuat otomatis setelah reservasi berhasil</li>
      </ul>
    </div>

    {{-- FORM --}}
    <form action="{{ route('reservations.store') }}" method="POST">
      @csrf

      <div class="bg-white rounded-xl shadow p-6">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

          {{-- LEFT --}}
          <div class="space-y-5">

            <h3 class="font-semibold border-b pb-2">
              Informasi Kunjungan
            </h3>
            <div class="mb-4">
              <label class="block font-semibold text-gray-700 mb-2">
                Ketua Rombongan
              </label>

              <input
                type="text"
                name="ketua_rombongan"
                value="{{ old('ketua_rombongan') }}"
                placeholder="Nama ketua rombongan"
                class="w-full rounded-2xl border-gray-300 focus:border-green-600 focus:ring-green-600 px-4 py-3">
            </div>

            {{-- TYPE --}}
            <div>
              <label class="block mb-2 font-medium">Jenis Kunjungan *</label>
              <select name="type" required class="w-full rounded-lg border-gray-300">
                <option value="personal">Perseorangan</option>
                <option value="group">Rombongan</option>
              </select>
            </div>


            {{-- WILAYAH --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

              <div>
                <label>Provinsi *</label>
                <select id="province" name="province_code" required class="w-full rounded-lg border-gray-300">
                  <option value="">Pilih Provinsi</option>
                  @foreach($provinces as $province)
                  <option value="{{ $province->code }}">{{ $province->name }}</option>
                  @endforeach
                </select>
              </div>

              <div>
                <label>Kabupaten *</label>
                <select id="regency" name="regency_id" required class="w-full rounded-lg border-gray-300">
                  <option value="">Pilih Kabupaten</option>
                </select>
              </div>

              <div>
                <label>Kecamatan *</label>
                <select id="district" name="district_id" required class="w-full rounded-lg border-gray-300">
                  <option value="">Pilih Kecamatan</option>
                </select>
              </div>

              <div>
                <label>Desa *</label>
                <select id="village" name="village_id" required class="w-full rounded-lg border-gray-300">
                  <option value="">Pilih Desa</option>
                </select>
              </div>

            </div>

            {{-- ADDRESS --}}
            <div>
              <label class="block mb-2 font-medium">Alamat</label>
              <textarea
                name="address"
                rows="4"
                class="w-full rounded-lg border-gray-300"
                placeholder="Alamat lengkap">{{ old('address') }}</textarea>
            </div>

          </div>

          {{-- RIGHT --}}
          <div class="space-y-5">

            <h3 class="font-semibold border-b pb-2">
              Jumlah Peserta
            </h3>

            <div class="grid grid-cols-2 gap-4">

              <div>
                <label>Bapak</label>
                <input type="number" min="0" name="total_father" value="0"
                  class="w-full rounded-lg border-gray-300">
              </div>

              <div>
                <label>Ibu</label>
                <input type="number" min="0" name="total_mother" value="0"
                  class="w-full rounded-lg border-gray-300">
              </div>

              <div>
                <label>Remaja</label>
                <input type="number" min="0" name="total_teenager" value="0"
                  class="w-full rounded-lg border-gray-300">
              </div>

              <div>
                <label>Anak</label>
                <input type="number" min="0" name="total_child" value="0"
                  class="w-full rounded-lg border-gray-300">
              </div>

            </div>

          </div>
        </div>

        {{-- ACTION --}}
        <div class="flex gap-3 mt-8">
          <button type="submit"
            class="bg-green-700 hover:bg-green-800 text-white px-6 py-2 rounded-lg">
            Simpan Reservasi
          </button>

          <a href="/"
            class="bg-gray-200 hover:bg-gray-300 px-6 py-2 rounded-lg">
            Beranda
          </a>
        </div>

      </div>
    </form>
  </div>

  {{-- AJAX --}}
  <script>
    function loadSelect(url, target, placeholder) {
      fetch(url)
        .then(res => res.json())
        .then(data => {
          let el = document.getElementById(target);
          el.innerHTML = `<option value="">${placeholder}</option>`;

          data.forEach(i => {
            el.innerHTML += `<option value="${i.code}">${i.name}</option>`;
          });
        });
    }

    document.getElementById('province').addEventListener('change', function() {
      loadSelect(`/get-regencies/${this.value}`, 'regency', 'Pilih Kabupaten');
      document.getElementById('district').innerHTML = '<option value="">Pilih Kecamatan</option>';
      document.getElementById('village').innerHTML = '<option value="">Pilih Desa</option>';
    });

    document.getElementById('regency').addEventListener('change', function() {
      loadSelect(`/get-districts/${this.value}`, 'district', 'Pilih Kecamatan');
    });

    document.getElementById('district').addEventListener('change', function() {
      loadSelect(`/get-villages/${this.value}`, 'village', 'Pilih Desa');
    });
  </script>

</x-app-layout>