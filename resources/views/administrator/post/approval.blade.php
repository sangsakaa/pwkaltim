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
    <h2 class="text-xl font-bold text-gray-800">Detail Post</h2>
  </x-slot>

  {{-- HEADER --}}
  <div class="bg-white rounded-xl shadow-sm border overflow-hidden mb-6 flex">
    <div class="bg-green-700 p-4 flex items-center">
      <img src="{{ asset('image/logo.png') }}" class="w-10">
    </div>

    <div class="flex-1 bg-green-700 text-white flex items-center justify-center">
      <span class="uppercase font-semibold tracking-wide text-sm md:text-base">
        {{$user->name}}
        {{$user->regency?->name ? ' • ' . $user->regency->name : ''}}
        {{$user->district?->name ? ' • Kec. ' . $user->district->name : ''}}
        {{$user->village?->name ? ' • ' . $user->village->name : ''}}
        {{$user->province?->name ? ' • ' . $user->province->name : ''}}
      </span>
    </div>
  </div>

  {{-- TABS --}}
  <div x-data="{ tab: 'all' }" class="bg-white rounded-xl shadow-sm border overflow-hidden">

    {{-- TAB BUTTON (MODERN SEGMENTED CONTROL) --}}
    <div class="flex gap-2 p-3 bg-gray-50 border-b">

      <button @click="tab='all'"
        class="flex-1 py-2 rounded-lg text-sm font-semibold transition"
        :class="tab==='all' ? 'bg-gray-900 text-white' : 'bg-white text-gray-600 hover:bg-gray-100'">
        All ({{ count($allPosts) }})
      </button>

      <button @click="tab='pending'"
        class="flex-1 py-2 rounded-lg text-sm font-semibold transition"
        :class="tab==='pending' ? 'bg-green-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-100'">
        Pending ({{ count($pendingPosts) }})
      </button>

      <button @click="tab='rejected'"
        class="flex-1 py-2 rounded-lg text-sm font-semibold transition"
        :class="tab==='rejected' ? 'bg-red-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-100'">
        Rejected ({{ count($rejectedPosts) }})
      </button>

    </div>

    {{-- CONTENT --}}
    <div class="p-5 space-y-4">

      {{-- ALL --}}
      <div x-show="tab === 'all'">
        @forelse ($allPosts as $post)
        @include('administrator.post._modern-card', ['post' => $post])
        @empty
        <p class="text-gray-400 text-center py-10">Tidak ada post.</p>
        @endforelse
      </div>

      {{-- PENDING --}}
      <div x-show="tab === 'pending'">
        @forelse ($pendingPosts as $post)
        @include('administrator.post._modern-card', ['post' => $post])
        @empty
        <p class="text-gray-400 text-center py-10">Tidak ada post pending.</p>
        @endforelse
      </div>

      {{-- REJECTED --}}
      <div x-show="tab === 'rejected'">
        @forelse ($rejectedPosts as $post)

        @include('administrator.post._modern-card', ['post' => $post])

        @php
        $canDelete = auth()->user()->hasAnyRole([
        'superAdmin',
        'admin-provinsi',
        'admin-kabupaten'
        ]);
        @endphp

        <div class="flex justify-end mt-2">
          <form action="{{ route('post.destroy', $post->id) }}" method="POST">
            @csrf
            @method('DELETE')

            <button
              class="text-sm px-3 py-1.5 rounded-lg transition
                            {{ $canDelete ? 'bg-red-500 text-white hover:bg-red-600' : 'bg-gray-300 text-gray-500 cursor-not-allowed' }}"
              {{ $canDelete ? '' : 'disabled' }}>
              Hapus
            </button>
          </form>
        </div>

        @empty
        <p class="text-gray-400 text-center py-10">Tidak ada post ditolak.</p>
        @endforelse
      </div>

    </div>
  </div>

</x-app-layout>