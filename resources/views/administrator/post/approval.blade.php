<x-app-layout>

  @php
  $user = auth()->user();

  $wilayah = match (true) {
  $user->regency?->name => $user->regency->name,
  $user->district?->name => 'Kec. ' . $user->district->name,
  $user->village?->name => $user->village->name,
  $user->province?->name => $user->province->name,
  default => 'Tidak diketahui',
  };
  @endphp

  <x-slot name="header">
    @section('title', 'PW ' . $wilayah)
    <h2 class="text-xl font-semibold">Detail Post</h2>
  </x-slot>

  {{-- HEADER --}}
  <div class="bg-white rounded-md shadow-md overflow-hidden mb-4 flex">
    <div class="bg-green-800 p-3 flex items-center">
      <img src="{{ asset('image/logo.png') }}" class="w-12">
    </div>

    <div class="flex-1 bg-green-800 text-white flex items-center justify-center">
      <span class="uppercase font-semibold text-lg">
        {{$user->name}}
        {{$user->regency?->name ? ' - ' . $user->regency->name : ''}}
        {{$user->district?->name ? ' - Kec. ' . $user->district->name : ''}}
        {{$user->village?->name ? ' - ' . $user->village->name : ''}}
        {{$user->province?->name ? ' - ' . $user->province->name : ''}}
      </span>
    </div>
  </div>

  {{-- TABS --}}
  <div x-data="{ tab: 'pending' }" class="bg-white rounded-md shadow-md">

    {{-- TAB BUTTON --}}
    <div class="flex border-b">
      <button
        @click="tab = 'pending'"
        :class="tab === 'pending' ? 'border-b-2 border-green-700 text-green-700' : 'text-gray-500'"
        class="flex-1 p-3 font-semibold">
        Pending ({{ count($pendingPosts) }})
      </button>

      <button
        @click="tab = 'rejected'"
        :class="tab === 'rejected' ? 'border-b-2 border-red-600 text-red-600' : 'text-gray-500'"
        class="flex-1 p-3 font-semibold">
        Rejected ({{ count($rejectedPosts) }})
      </button>
    </div>

    {{-- CONTENT --}}
    <div class="p-4 space-y-4">

      {{-- ================= PENDING ================= --}}
      <div x-show="tab === 'pending'">
        @forelse ($pendingPosts as $post)
        <div class="border rounded-md p-4 space-y-2">

          <h3 class="font-bold text-lg">{{ $post->title }}</h3>

          @if ($post->photo)
          <img src="{{ asset('storage/' . $post->photo) }}"
            class="w-full max-h-72 object-cover rounded-md">
          @endif

          <p class="text-sm text-gray-500">
            Oleh: {{ $post->creator->name }}
          </p>

          <p>{{ $post->content }}</p>

          <form method="POST"
            action="{{ url('/post/'.$post->id.'/approve') }}"
            class="flex gap-2">
            @csrf
            @method('PUT')

            <button name="action" value="approve"
              class="bg-green-700 text-white px-3 py-1 rounded">
              Approve
            </button>

            <button name="action" value="reject"
              class="bg-red-600 text-white px-3 py-1 rounded">
              Reject
            </button>
          </form>

        </div>
        @empty
        <p class="text-gray-500">Tidak ada post pending.</p>
        @endforelse
      </div>

      {{-- ================= REJECTED ================= --}}
      <div x-show="tab === 'rejected'">

        @forelse ($rejectedPosts as $post)
        <div class="border rounded-md p-4 space-y-2">

          <h3 class="font-bold text-lg">{{ $post->title }}</h3>

          {{-- ✅ GAMBAR FULL (FIX DI SINI) --}}
          @if ($post->photo)
          <img src="{{ asset('storage/' . $post->photo) }}"
            class="w-full max-h-72 object-cover rounded-md">
          @endif

          <p class="text-sm text-gray-500">
            Oleh: {{ $post->creator->name }}
          </p>

          <p>{{ $post->content }}</p>

          <div class="flex gap-2">

            <form method="POST"
              action="{{ url('/post/'.$post->id.'/approve') }}"
              class="flex gap-2">
              @csrf
              @method('PUT')

              <button name="action" value="approve"
                class="bg-green-700 text-white px-3 py-1 rounded">
                Approve
              </button>

              <button name="action" value="reject"
                class="bg-red-600 text-white px-3 py-1 rounded">
                Reject
              </button>
            </form>

            @php
            $canDelete = auth()->user()->hasAnyRole([
            'superAdmin',
            'admin-provinsi',
            'admin-kabupaten'
            ]);
            @endphp

            <form action="{{ route('post.destroy', $post->id) }}" method="POST">
              @csrf
              @method('DELETE')

              <button
                class="px-3 py-1 rounded text-white
                                {{ $canDelete ? 'bg-red-500 hover:bg-red-600' : 'bg-gray-400 cursor-not-allowed' }}"
                {{ $canDelete ? '' : 'disabled' }}>
                Hapus
              </button>
            </form>

          </div>

        </div>
        @empty
        <p class="text-gray-500">Tidak ada post ditolak.</p>
        @endforelse

      </div>

    </div>
  </div>

</x-app-layout>