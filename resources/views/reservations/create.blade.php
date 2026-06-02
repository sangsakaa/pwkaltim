<x-app-layout>

  @section('title', 'Reservasi Pengunjung')

  <x-slot name="header">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-xl sm:text-2xl font-bold text-slate-800">
          Reservasi Pengunjung
        </h2>
        <p class="text-sm text-slate-500 mt-1">
          Form pendaftaran calon peserta Mujahadah Nisfussanah
        </p>
      </div>
    </div>
  </x-slot>

  <div class="max-w-7xl mx-auto space-y-6">

    {{-- FLASH MESSAGE --}}
    @if(session('success'))
    <div
      class="rounded-3xl border border-green-200 bg-green-50 p-5 shadow-sm">
      <div class="flex items-start gap-3">
        <div class="text-green-700 text-xl">
          ✅
        </div>

        <div>
          <h3 class="font-semibold text-green-800">
            Berhasil
          </h3>

          <p class="text-green-700 text-sm mt-1">
            {{ session('success') }}
          </p>
        </div>
      </div>
    </div>
    @endif

    @if(session('error'))
    <div
      class="rounded-3xl border border-red-200 bg-red-50 p-5 shadow-sm">
      <div class="flex items-start gap-3">
        <div class="text-red-700 text-xl">
          ❌
        </div>

        <div>
          <h3 class="font-semibold text-red-800">
            Terjadi Kesalahan
          </h3>

          <p class="text-red-700 text-sm mt-1">
            {{ session('error') }}
          </p>
        </div>
      </div>
    </div>
    @endif

    {{-- INFO --}}
    <div
      class="rounded-3xl border border-blue-100 bg-blue-50 px-5 py-4 text-blue-700 shadow-sm">

      <div class="flex gap-3 items-center">
        <span class="text-xl">ℹ️</span>

        <div>
          <h3 class="font-semibold">
            Informasi
          </h3>

          <p class="text-sm text-blue-600">
            Pendaftaran Calon Peserta Nisfussanah (Publik)
          </p>
        </div>
      </div>
    </div>

    {{-- HEADER CARD --}}
    <div
      class="overflow-hidden rounded-[32px] bg-gradient-to-br from-green-900 via-green-800 to-green-600 text-white shadow-xl">

      <div
        class="flex flex-col items-center gap-5 p-6 sm:flex-row sm:items-center sm:justify-between sm:p-8">

        {{-- LOGO --}}
        <div
          class=" items-center justify-center    ">

          <img
            src="{{ asset('image/logo.png') }}"
            class="h-16 w-16  sm:h-20 sm:w-20"
            alt="Logo">
        </div>

        {{-- TEXT --}}
        <div class="flex-1 text-center sm:text-left">

          <h1
            class="mt-4  text-sm font-extrabold uppercase leading-tight sm:text-3xl">

            Pendaftaran Calon Peserta
            <span class="block text-green-200">
              Mujahadah Nisfussanah
            </span>
          </h1>

          <p
            class="mt-3 text-sm leading-relaxed text-green-100 sm:text-base">

            Form pendaftaran peserta
            Mujahadah Nisfussanah Kabupaten Paser.
          </p>
        </div>
      </div>
    </div>

    {{-- NOTE --}}
    <div
      class="rounded-[28px] border border-yellow-200 bg-yellow-50 p-5 shadow-sm">

      <div class="flex items-start gap-2">
        <span class="text-sm">⚠️</span>
        <div>
          <h3 class="font-semibold text-yellow-800">
            Perhatian Pengisian Form
          </h3>

          <ul
            class="mt-3 space-y-2 text-sm text-yellow-700">
            <li>
              • Kolom bertanda
              <span class="font-bold text-red-500">*</span>
              wajib diisi
            </li>
            <li>
              • Pastikan wilayah dan jumlah peserta benar
            </li>

            <li>
              • QR Code dibuat otomatis setelah reservasi berhasil
            </li>
          </ul>
        </div>
      </div>
    </div>

    {{-- FORM --}}
    <form
      action="{{ route('reservations.store') }}"
      method="POST">

      @csrf

      <div
        class="overflow-hidden rounded-[32px] border border-slate-200 bg-white shadow-sm">

        {{-- HEADER FORM --}}
        <div
          class="border-b border-slate-100 bg-slate-50 px-6 py-5">

          <h3 class="text-lg font-bold text-slate-800">
            Form Reservasi Peserta
          </h3>

          <p class="mt-1 text-sm text-slate-500">
            Silakan isi data dengan benar
          </p>
        </div>

        <div class="p-5 sm:p-8">

          <div
            class="grid grid-cols-1 gap-8 xl:grid-cols-2">

            {{-- LEFT --}}
            <div class="space-y-6">

              <div class="border-b pb-3">
                <h3
                  class="font-semibold text-slate-800">
                  Informasi Kunjungan
                </h3>
              </div>

              {{-- Ketua --}}
              <div>
                <label
                  class="mb-2 block text-sm font-semibold text-slate-700">

                  Ketua Rombongan
                </label>

                <input
                  type="text"
                  name="ketua_rombongan"
                  value="{{ old('ketua_rombongan') }}"
                  placeholder="Masukkan nama ketua rombongan"
                  class="w-full rounded-2xl border-slate-300 px-4 py-3 focus:border-green-600 focus:ring-green-600">
              </div>

              {{-- TYPE --}}
              <div>
                <label
                  class="mb-2 block text-sm font-semibold text-slate-700">

                  Jenis Kunjungan
                  <span class="text-red-500">*</span>
                </label>

                <select
                  name="type"
                  required
                  class="w-full rounded-2xl border-slate-300 px-4 py-3 focus:border-green-600 focus:ring-green-600">

                  <option value="personal">
                    Perseorangan
                  </option>

                  <option value="group">
                    Rombongan
                  </option>
                </select>
              </div>

              {{-- WILAYAH --}}
              <div>

                <h4
                  class="mb-4 font-semibold text-slate-700">
                  Wilayah Domisili
                </h4>

                <div
                  class="grid grid-cols-1 gap-4 md:grid-cols-2">

                  <div>
                    <label class="mb-2 block text-sm">
                      Provinsi *
                    </label>

                    <select
                      id="province"
                      name="province_code"
                      required
                      class="w-full rounded-2xl border-slate-300 px-4 py-3">

                      <option value="">
                        Pilih Provinsi
                      </option>

                      @foreach($provinces as $province)
                      <option value="{{ $province->code }}">
                        {{ $province->name }}
                      </option>
                      @endforeach
                    </select>
                  </div>

                  <div>
                    <label class="mb-2 block text-sm">
                      Kabupaten *
                    </label>

                    <select
                      id="regency"
                      name="regency_id"
                      required
                      class="w-full rounded-2xl border-slate-300 px-4 py-3">

                      <option value="">
                        Pilih Kabupaten
                      </option>
                    </select>
                  </div>

                  <div>
                    <label class="mb-2 block text-sm">
                      Kecamatan *
                    </label>

                    <select
                      id="district"
                      name="district_id"
                      required
                      class="w-full rounded-2xl border-slate-300 px-4 py-3">

                      <option value="">
                        Pilih Kecamatan
                      </option>
                    </select>
                  </div>

                  <div>
                    <label class="mb-2 block text-sm">
                      Desa *
                    </label>

                    <select
                      id="village"
                      name="village_id"
                      required
                      class="w-full rounded-2xl border-slate-300 px-4 py-3">

                      <option value="">
                        Pilih Desa
                      </option>
                    </select>
                  </div>
                </div>
              </div>

              {{-- ALAMAT --}}
              <div>
                <label
                  class="mb-2 block text-sm font-semibold text-slate-700">

                  Alamat Lengkap
                </label>

                <textarea
                  name="address"
                  rows="5"
                  placeholder="Masukkan alamat lengkap"
                  class="w-full rounded-2xl border-slate-300 px-4 py-3 focus:border-green-600 focus:ring-green-600">{{ old('address') }}</textarea>
              </div>
            </div>

            {{-- RIGHT --}}
            <div class="space-y-6">

              <div class="border-b pb-3">
                <h3
                  class="font-semibold text-slate-800">
                  Jumlah Peserta
                </h3>
              </div>

              <div
                class="grid grid-cols-2 gap-4">

                @php
                $participants = [
                'total_father' => 'Bapak',
                'total_mother' => 'Ibu',
                'total_teenager' => 'Remaja',
                'total_child' => 'Anak',
                ];
                @endphp

                @foreach($participants as $name => $label)
                <div>
                  <label
                    class="mb-2 block text-sm font-medium text-slate-700">

                    {{ $label }}
                  </label>

                  <input
                    type="number"
                    min="0"
                    name="{{ $name }}"
                    value="{{ old($name, 0) }}"
                    class="w-full rounded-2xl border-slate-300 px-4 py-3 focus:border-green-600 focus:ring-green-600">
                </div>
                @endforeach
              </div>
            </div>
          </div>

          {{-- ACTION --}}
          <div
            class="mt-10 flex flex-col gap-3 border-t border-slate-100 pt-6 sm:flex-row">

            <button
              type="submit"
              class="rounded-2xl bg-green-700 px-6 py-4 font-semibold text-white transition hover:bg-green-800">

              Simpan Reservasi
            </button>

            <a
              href="/"
              class="rounded-2xl bg-slate-100 px-6 py-4 text-center font-medium transition hover:bg-slate-200">

              Kembali ke Beranda
            </a>
          </div>
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

          el.innerHTML =
            `<option value="">${placeholder}</option>`;

          data.forEach(i => {
            el.innerHTML +=
              `<option value="${i.code}">${i.name}</option>`;
          });
        });
    }

    document.getElementById('province')
      .addEventListener('change', function() {

        loadSelect(
          `/get-regencies/${this.value}`,
          'regency',
          'Pilih Kabupaten'
        );

        document.getElementById('district')
          .innerHTML =
          '<option value="">Pilih Kecamatan</option>';

        document.getElementById('village')
          .innerHTML =
          '<option value="">Pilih Desa</option>';
      });

    document.getElementById('regency')
      .addEventListener('change', function() {

        loadSelect(
          `/get-districts/${this.value}`,
          'district',
          'Pilih Kecamatan'
        );
      });

    document.getElementById('district')
      .addEventListener('change', function() {

        loadSelect(
          `/get-villages/${this.value}`,
          'village',
          'Pilih Desa'
        );
      });
  </script>

</x-app-layout>