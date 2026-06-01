
<x-app-layout>

  <div class="max-w-2xl mx-auto py-8 px-4">

    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">

      {{-- Header --}}
      <div class="bg-blue-600 text-white px-6 py-5">

        <h1 class="text-2xl font-bold">
          Update Reservasi
        </h1>

        <p class="text-sm opacity-90">
          Hanya jumlah peserta yang dapat diperbarui
        </p>

      </div>

      {{-- Body --}}
      <div class="p-6">

        <form
          action="{{ route('reservasi.update', $reservation->id) }}"
          method="POST">

          @csrf
          @method('PUT')

          {{-- Info Reservasi --}}
          <div class="mb-6">

            <label class="block text-sm font-medium text-slate-600 mb-2">
              No Reservasi
            </label>

            <input
              type="text"
              value="{{ $reservation->reservation_number }}"
              readonly
              class="w-full rounded-2xl border-slate-300 bg-slate-100">
          </div>

          {{-- Jumlah Peserta --}}
          <div class="grid grid-cols-2 gap-4">

            <div>
              <label class="block text-sm font-medium mb-2">
                Bapak
              </label>

              <input
                type="number"
                min="0"
                name="total_father"
                value="{{ old('total_father', $reservation->total_father) }}"
                class="w-full rounded-2xl border-slate-300">
            </div>

            <div>
              <label class="block text-sm font-medium mb-2">
                Ibu
              </label>

              <input
                type="number"
                min="0"
                name="total_mother"
                value="{{ old('total_mother', $reservation->total_mother) }}"
                class="w-full rounded-2xl border-slate-300">
            </div>

            <div>
              <label class="block text-sm font-medium mb-2">
                Remaja
              </label>

              <input
                type="number"
                min="0"
                name="total_teenager"
                value="{{ old('total_teenager', $reservation->total_teenager) }}"
                class="w-full rounded-2xl border-slate-300">
            </div>

            <div>
              <label class="block text-sm font-medium mb-2">
                Anak-anak
              </label>

              <input
                type="number"
                min="0"
                name="total_child"
                value="{{ old('total_child', $reservation->total_child) }}"
                class="w-full rounded-2xl border-slate-300">
            </div>

          </div>

          {{-- Total --}}
          <div class="mt-6">

            <label class="block text-sm font-medium mb-2">
              Total Peserta
            </label>

            <input
              type="text"
              readonly
              id="totalParticipant"
              value="{{ $reservation->total_participant }}"
              class="w-full rounded-2xl border-slate-300 bg-slate-100">
          </div>

          {{-- Button --}}
          <div class="mt-8 flex gap-3">

            <button
              type="submit"
              class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-2xl font-semibold">

              Update Reservasi

            </button>

          </div>

        </form>

      </div>
    </div>
  </div>

  <script>
    const inputs = document.querySelectorAll(
      '[name=total_father],[name=total_mother],[name=total_teenager],[name=total_child]'
    );

    const total = document.getElementById(
      'totalParticipant'
    );

    function calculate() {

      let sum = 0;

      inputs.forEach(input => {
        sum += Number(input.value || 0);
      });

      total.value = sum;
    }

    inputs.forEach(input => {
      input.addEventListener('input', calculate);
    });
  </script>

</x-app-layout>
