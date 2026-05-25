<div x-data="{ openDelete: false }"
  class="bg-white border rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition">

  {{-- IMAGE HEADER (MODERN HERO) --}}
  @if ($post->photo)
  <div class="relative">
    <img src="{{ asset('storage/' . $post->photo) }}"
      class="w-full h-56 object-cover">

    {{-- STATUS BADGE OVER IMAGE --}}
    <div class="absolute top-3 left-3">
      <span class="text-xs px-3 py-1 rounded-full font-semibold backdrop-blur-md bg-white/80
                    @if($post->status === 'pending') text-yellow-700
                    @elseif($post->status === 'rejected') text-red-600
                    @else text-green-700
                    @endif">
        {{ strtoupper($post->status) }}
      </span>
    </div>
  </div>
  @endif

  {{-- CONTENT --}}
  <div class="p-4 space-y-3">

    {{-- TITLE --}}
    <h3 class="text-lg font-bold text-gray-800 leading-snug">
      {{ $post->title }}
    </h3>

    {{-- META --}}
    <p class="text-sm text-gray-500">
      Oleh <span class="font-medium text-gray-700">{{ $post->creator->name }}</span>
    </p>

    {{-- CONTENT TEXT --}}
    <p class="text-sm text-gray-600 leading-relaxed">
      {{ $post->content }}
    </p>

    {{-- ACTION BAR --}}
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 pt-3 border-t">

      {{-- APPROVE / REJECT --}}
      <form method="POST"
        action="{{ url('/post/'.$post->id.'/approve') }}"
        class="flex gap-2">

        @csrf
        @method('PUT')

        <button name="action" value="approve"
          class="px-3 py-1.5 text-sm rounded-lg bg-green-600 text-white hover:bg-green-700 transition">
          Approve
        </button>

        <button name="action" value="reject"
          class="px-3 py-1.5 text-sm rounded-lg bg-red-600 text-white hover:bg-red-700 transition">
          Reject
        </button>
      </form>

      {{-- DELETE --}}
      @php
      $canDelete = auth()->user()->hasAnyRole([
      'superAdmin',
      'admin-provinsi',
      'admin-kabupaten'
      ]);
      @endphp

      @if($canDelete)
      <button
        @click="openDelete = true"
        class="px-3 py-1.5 text-sm rounded-lg bg-gray-900 text-white hover:bg-gray-800 transition">
        Delete
      </button>
      @endif

    </div>
  </div>

  {{-- ================= DELETE MODAL ================= --}}
  <div
    x-show="openDelete"
    x-transition.opacity
    class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">

    <div
      @click.away="openDelete = false"
      class="bg-white w-full max-w-md rounded-2xl p-6 space-y-4 shadow-xl">

      <h2 class="text-lg font-bold text-gray-800">
        Konfirmasi Hapus
      </h2>

      <p class="text-sm text-gray-600">
        Yakin ingin menghapus post ini? Tindakan ini tidak dapat dibatalkan.
      </p>

      <div class="flex justify-end gap-2">

        <button
          @click="openDelete = false"
          class="px-4 py-2 text-sm rounded-lg bg-gray-200 hover:bg-gray-300 transition">
          Batal
        </button>

        <form action="{{ route('post.destroy', $post->id) }}" method="POST">
          @csrf
          @method('DELETE')

          <button type="submit"
            class="px-4 py-2 text-sm rounded-lg bg-red-600 text-white hover:bg-red-700 transition">
            Hapus
          </button>
        </form>

      </div>

    </div>
  </div>

</div>