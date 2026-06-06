<x-app-layout>

  <x-slot name="header">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

      <div>
        <h2 class="text-2xl font-bold text-gray-800">
          Tambah Periode Tahunan
        </h2>

        <p class="mt-1 text-sm text-gray-500">
          Buat periode kepengurusan atau periode program kerja baru.
        </p>
      </div>

      <a
        href="{{ route('periode-tahunan.index') }}"
        class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-200 transition">

        <svg xmlns="http://www.w3.org/2000/svg"
          class="h-4 w-4"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor">

          <path stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M15 19l-7-7 7-7" />
        </svg>

        Kembali
      </a>

    </div>
  </x-slot>

  <div class="py-8">

    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

      {{-- Alert --}}
      @if ($errors->any())
      <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4">

        <div class="font-medium text-red-700">
          Terdapat kesalahan pada form:
        </div>

        <ul class="mt-2 list-disc list-inside text-sm text-red-600">
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>

      </div>
      @endif

      {{-- Card Form --}}
      <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

        {{-- Header Card --}}
        <div class="px-6 py-5 border-b bg-gradient-to-r from-green-600 to-green-700">

          <h3 class="text-lg font-semibold text-white">
            Form Periode Tahunan
          </h3>

          <p class="text-sm text-green-100 mt-1">
            Lengkapi informasi periode yang akan digunakan untuk program kerja.
          </p>

        </div>

        {{-- Form --}}
        <form
          action="{{ route('periode-tahunan.store') }}"
          method="POST">

          @csrf

          <div class="p-6">

            @include('periode-tahunan.form')

          </div>

        </form>

      </div>

    </div>

  </div>

</x-app-layout>