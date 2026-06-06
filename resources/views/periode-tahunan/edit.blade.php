<x-app-layout>

  <x-slot name="header">
    <div class="flex items-center justify-between">

      <div>
        <h2 class="text-2xl font-bold text-gray-800">
          Edit Periode Tahunan
        </h2>

        <p class="text-sm text-gray-500">
          Perbarui informasi periode tahunan.
        </p>
      </div>

      <a
        href="{{ route('periode-tahunan.index') }}"
        class="px-4 py-2 bg-gray-100 border rounded-lg hover:bg-gray-200">

        Kembali
      </a>

    </div>
  </x-slot>

  <div class="py-8">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

      <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">

        <div class="px-6 py-5 bg-gradient-to-r from-blue-600 to-blue-700">
          <h3 class="text-lg font-semibold text-white">
            Form Edit Periode
          </h3>
        </div>

        <form
          action="{{ route('periode-tahunan.update', $periodeTahunan->id) }}"
          method="POST">

          @csrf
          @method('PUT')

          <div class="p-6">
            @include('periode-tahunan.form')
          </div>

        </form>

      </div>

    </div>
  </div>

</x-app-layout>