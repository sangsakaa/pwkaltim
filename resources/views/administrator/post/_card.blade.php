<div class="bg-white border rounded-xl p-4 shadow-sm hover:shadow-md transition space-y-3">

  {{-- TITLE --}}
  <div class="flex justify-between items-start gap-2">
    <h3 class="font-bold text-lg text-gray-800">{{ $post->title }}</h3>

    {{-- STATUS BADGE --}}
    <span class="text-xs px-2 py-1 rounded-full font-semibold
            @if($post->status === 'pending') bg-yellow-100 text-yellow-700
            @elseif($post->status === 'rejected') bg-red-100 text-red-600
            @else bg-green-100 text-green-700
            @endif">
      {{ strtoupper($post->status) }}
    </span>
  </div>

  {{-- IMAGE --}}
  @if ($post->photo)
  <img src="{{ asset('storage/' . $post->photo) }}"
    class="w-full h-52 object-cover rounded-lg">
  @endif

  {{-- META --}}
  <p class="text-sm text-gray-500">
    Oleh <span class="font-medium text-gray-700">{{ $post->creator->name }}</span>
  </p>

  {{-- CONTENT --}}
  <p class="text-gray-600 text-sm leading-relaxed">
    {{ $post->content }}
  </p>

  {{-- ACTION --}}
  <form method="POST" action="{{ url('/post/'.$post->id.'/approve') }}" class="flex gap-2 pt-2">
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

</div>