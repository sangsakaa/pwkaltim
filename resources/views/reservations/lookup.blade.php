<x-app-layout>

  <div class="max-w-md mx-auto py-4 px-4">

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden">

      {{-- HEADER --}}
      <div class="bg-blue-600 text-white text-center py-4">

        <h1 class="text-2xl font-bold">
          Update Reservasi
        </h1>

        <p class="text-sm opacity-90">
          Masukkan kode reservasi
        </p>

      </div>

      {{-- BODY --}}
      <div class="p-6 space-y-5">

        {{-- ERROR --}}
        @if(session('error'))
        <div class="rounded-xl bg-red-50 border border-red-200 p-3 text-red-700 text-sm">
          {{ session('error') }}
        </div>
        @endif

        @error('reservation_code')
        <div class="rounded-xl bg-red-50 border border-red-200 p-3 text-red-700 text-sm">
          {{ $message }}
        </div>
        @enderror

        {{-- FORM --}}
        <form action="{{ route('reservasi.find') }}" method="POST" class="space-y-4">

          @csrf

          {{-- INPUT BLOCK --}}
          <div class="text-center">

            <label class="block text-sm font-medium text-gray-500 mb-2">
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
              class="w-full border border-gray-300 rounded-2xl py-4 text-center text-lg font-semibold tracking-[6px] focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm">

          </div>

          {{-- BUTTON --}}
          <button
            type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 active:scale-95 transition text-white py-3 rounded-xl font-semibold shadow-md">

            Cari Reservasi

          </button>

        </form>

      </div>

    </div>

  </div>

</x-app-layout>