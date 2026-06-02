<x-app-layout>

  <div class="max-w-md mx-auto py-6 px-4">

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">

      {{-- HEADER --}}
      <div class="bg-gradient-to-r from-blue-600 to-blue-500 text-white text-center py-5">

        <h1 class="text-xl font-bold">
          Verifikasi Data Peserta
        </h1>

        <p class="text-sm opacity-90 mt-1">
          Masukkan kode reservasi untuk melanjutkan
        </p>

      </div>

      {{-- BODY --}}
      <div class="p-6 space-y-5">

        {{-- FLASH ERROR --}}
        @if(session('error'))
        <div class="rounded-xl bg-red-50 border border-red-200 p-3 text-red-700 text-sm">
          {{ session('error') }}
        </div>
        @endif

        {{-- VALIDATION ERROR --}}
        @error('reservation_code')
        <div class="rounded-xl bg-red-50 border border-red-200 p-3 text-red-700 text-sm">
          {{ $message }}
        </div>
        @enderror

        {{-- FORM --}}
        <form action="{{ route('reservasi.find') }}" method="POST" class="space-y-5">

          @csrf

          {{-- INPUT --}}
          <div>
            <label class="block text-sm font-medium text-gray-600 mb-2 text-center">
              Kode Reservasi
            </label>

            <input
              type="text"
              name="reservation_code"
              value="{{ old('reservation_code') }}"
              placeholder="D7FTL2ID"
              autocomplete="off"
              required
              oninput="this.value=this.value.toUpperCase()"
              class="w-full border border-gray-300 rounded-2xl py-4 text-center text-lg font-semibold tracking-[6px]
                                   focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                   shadow-sm transition">

            @error('reservation_code')
            <p class="text-xs text-red-500 mt-2 text-center">
              {{ $message }}
            </p>
            @enderror
          </div>

          {{-- BUTTON --}}
          <button
            type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 active:scale-[0.98]
                               transition text-white py-3 rounded-xl font-semibold shadow-md">

            Cari Reservasi
          </button>

        </form>

      </div>

    </div>

  </div>

</x-app-layout>