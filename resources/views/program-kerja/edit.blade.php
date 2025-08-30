<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl">Perbaharui Program Kerja</h2>
  </x-slot>

  @include('components.flash') {{-- opsional --}}
  <!-- <form method="POST" action="{{ route('program-kerja.store') }}" class="bg-white shadow rounded p-4">
    @csrf
    @include('program-kerja._form')
  </form> -->
  <form method="POST" action="{{ route('program-kerja.update', $program_kerja->id) }}" class="bg-white shadow rounded p-4">
    @csrf
    @method('PUT') {{-- atau PATCH --}}

    @include('program-kerja._form')

    <!-- <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
      Update
    </button> -->
  </form>



</x-app-layout>