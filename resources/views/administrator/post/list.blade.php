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
        {{ __('Management Pengamal') }}
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
  <div class="p-2 overflow-hidden bg-white rounded-md shadow-md mt-2">
    <div class="flex justify-between items-center">
      <div class="w-full p-4">
        <h2 class="text-2xl font-semibold mb-4">Daftar Postingan yang Disetujui</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4">
          @forelse ($posts as $post)
          <div class="border p-4 rounded shadow">

            <a href="" class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
              <h3 class="text-xl font-bold">{{ $post->title }}</h3>
            </a>
            <p class="text-sm text-gray-600">
              Oleh: {{ $post->creator->name }} <br>
              Disetujui oleh: {{ optional($post->approver)->name }} <br>
              Tanggal Disetujui:
              @if ($post->approved_at)
              {{ \Carbon\Carbon::parse($post->approved_at)->translatedFormat('d F Y') }}
              @else
              -
              @endif
            </p>
            <p class="mt-2">{{ Str::limit($post->content, 50) }}</p>

            <form method="POST" action="/post/{{ $post->id }}/approve" class="mt-4 flex gap-2">
              @csrf
              @method('PUT')

              @if (!$post->approved_at)
              <button type="submit" name="action" value="approve" class="bg-green-700 text-white px-2 py-1 rounded">
                Approve
              </button>
              @endif

              <button type="submit" name="action" value="reject" class="bg-red-700 text-white px-2 py-1 rounded">
                Reject
              </button>
            </form>
          </div>
          @empty
          <div class="col-span-3">
            <p class="text-center text-gray-500">Tidak ada postingan yang telah disetujui.</p>
          </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>



</x-app-layout>