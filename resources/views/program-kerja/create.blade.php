<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl">Tambah Program Kerja</h2>
  </x-slot>

  @include('components.flash') {{-- opsional --}}
  <form method="POST" action="{{ route('program-kerja.store') }}" class="bg-white shadow rounded p-4">
    @csrf
    @include('program-kerja._form')
  </form>
</x-app-layout>