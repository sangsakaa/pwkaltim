<x-app-layout>
  <x-slot name="header">
    @php
    $user = auth()->user();

    if ($user->regency?->name) {
    if (Str::startsWith($user->regency->name, 'Kab.')) {
    $wilayah = 'Kabupaten ' . ltrim(substr($user->regency->name, 4));
    } else {
    $wilayah = $user->regency->name; // Biarkan 'Kota ...' atau lainnya
    }
    } elseif ($user->district?->name) {
    $wilayah = 'Kec. ' . $user->district->name;
    } elseif ($user->village?->name) {
    $wilayah = $user->village->name;
    } elseif ($user->province?->name) {
    $wilayah = $user->province->name;
    } else {
    $wilayah = 'Tidak diketahui';
    }
    @endphp
    @section('title', 'PW '. $wilayah )
    <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between ">
      <h2 class="text-xl font-semibold leading-tight">
        {{ __('Detail Pengamal') }}
      </h2>
    </div>
  </x-slot>

  <div class=" gap-2 grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1">
    <div class="  p-2 overflow-hidden bg-white rounded-md shadow-md">
      <div class="  flex ">

        <div class="bg-green-800 flex flex-col items-center justify-center p-1">
          <img src="{{ asset('image/logo.png') }}" width="50" alt="Logo">
        </div>

        <div class="bg-green-800 w-full sm:grid sm:grid-cols-1 flex flex-col items-center text-white fw-semibold p-4">
          @php
          $user = auth()->user();

          if ($user->regency?->name) {
          if (Str::startsWith($user->regency->name, 'Kab.')) {
          $wilayah = 'Kabupaten ' . ltrim(substr($user->regency->name, 4));
          } else {
          $wilayah = $user->regency->name; // Biarkan 'Kota ...' atau lainnya
          }
          } elseif ($user->district?->name) {
          $wilayah = 'Kec. ' . $user->district->name;
          } elseif ($user->village?->name) {
          $wilayah = $user->village->name;
          } elseif ($user->province?->name) {
          $wilayah = $user->province->name;
          } else {
          $wilayah = 'Tidak diketahui';
          }
          @endphp
          <span class="uppercase text-lg fw-semibold">PW {{ $wilayah }}</span>
        </div>

      </div>
    </div>
  </div>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
    {{-- Kolom Pending --}}
    <div class="p-2 overflow-hidden bg-white rounded-md shadow-md">
      <div class="flex justify-between items-center">
        <div class="overflow-auto w-full">
          <div class="bg-white p-6 rounded shadow">
            <h2 class="text-2xl font-semibold mb-4">Daftar Postingan Pending</h2>
            @forelse ($posts as $post)
            <div class="border p-4 mb-4 rounded w-full">
              <h3 class="text-xl font-bold">{{ $post->title }}</h3>
              @if ($post->photo)
              <img src="{{ asset('storage/' . $post->photo) }}" alt="Foto Postingan">
              @endif

              <p class="text-sm text-gray-600 mb-2">Dikirim oleh: {{ $post->creator->name }}</p>
              <p>{{ $post->content }}</p>

              <form method="POST" action="/post/{{ $post->id }}/approve" class="mt-4 flex gap-2">
                @csrf
                @method('PUT')
                <button name="action" value="approve" class="bg-green-800 text-white px-3 py-1 rounded">Approve</button>
                <button name="action" value="reject" class="bg-red-600 text-white px-3 py-1 rounded">Reject</button>
              </form>
            </div>
            @empty
            <div class="bg-yellow-100 text-yellow-800 p-4 rounded mb-4">
              Tidak ada postingan yang menunggu persetujuan.
            </div>
            @endforelse

          </div>
        </div>
      </div>
    </div>

    {{-- Kolom Reject --}}
    <div class="p-2 overflow-hidden bg-white rounded-md shadow-md">
      <div class="flex justify-between items-center">
        <div class="overflow-auto w-full">
          <div class="bg-white p-6 rounded shadow">
            <h2 class="text-2xl font-semibold mb-4">Daftar Postingan Reject</h2>
            @forelse ($rejectposts as $post)
            <div class="border p-4 mb-4 rounded">
              <h3 class="text-xl font-bold">{{ $post->title }}</h3>
              <p class="text-sm text-gray-600 mb-2">Dikirim oleh: {{ $post->creator->name }}</p>
              <p>{{ $post->content }}</p>

              <div class="flex gap-2">
                <form method="POST" action="/post/{{ $post->id }}/approve" class="flex gap-2">
                  @csrf
                  @method('PUT')
                  <button name="action" value="approve" class="bg-green-800 text-white px-3 py-1 rounded">Approve</button>
                  <button name="action" value="reject" class="bg-red-600 text-white px-3 py-1 rounded">Reject</button>
                </form>

                <form action="{{ route('post.destroy', $post->id) }}" method="POST" class="inline">
                  @csrf
                  @method('DELETE')
                  @php
                  $canDelete = auth()->user()->hasAnyRole(['superAdmin', 'admin-provinsi', 'admin-kabupaten']);
                  @endphp
                  <button
                    type="submit"
                    class="px-4 py-1 text-white rounded 
          {{ $canDelete ? 'bg-red-500 hover:bg-red-600' : 'bg-gray-400 cursor-not-allowed' }}"
                    {{ $canDelete ? '' : 'disabled' }}>
                    Hapus
                  </button>
                </form>
              </div>
            </div>
            @empty
            <div class="bg-yellow-100 text-yellow-800 p-4 rounded mb-4">
              Tidak ada postingan yang ditolak.
            </div>
            @endforelse

          </div>
        </div>
      </div>
    </div>
  </div>



</x-app-layout>