<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ Str::title($post->title) }} - MyBlog</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <style>
    body.modal-open {
      overflow: hidden;
    }
  </style>
</head>

<body class="bg-gray-100 text-gray-800 font-sans antialiased">

  <div
    x-data="{
    open: false,
    img: '',
    init() {
      this.$watch('open', value => {
        document.body.classList.toggle('modal-open', value);
      });
    },

    cal: {
      month: new Date().getMonth(),
      year: new Date().getFullYear(),

      get monthName() {
        return new Date(this.year, this.month)
          .toLocaleString('id-ID', { month: 'long' });
      },

      get days() {
        return new Date(this.year, this.month + 1, 0).getDate();
      },

      get blanks() {
        return new Array(new Date(this.year, this.month, 1).getDay());
      },

      isToday(day) {
        const t = new Date();
        return day === t.getDate() &&
          this.month === t.getMonth() &&
          this.year === t.getFullYear();
      },

      prevMonth() {
        this.month = this.month === 0 ? 11 : this.month - 1;
        if (this.month === 11) this.year--;
      },

      nextMonth() {
        this.month = this.month === 11 ? 0 : this.month + 1;
        if (this.month === 0) this.year++;
      }
    }
  }"
    x-init="init()"
    @keydown.escape.window="open = false">

    {{-- NAVBAR (GLASS STYLE) --}}
    <nav class="sticky top-0 z-40 bg-white/70 backdrop-blur border-b shadow-sm">
      <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between">
        <a href="/" class="text-xl font-bold text-gray-800 hover:text-red-500">
          MyBlog
        </a>
        <a href="/" class="text-gray-600 hover:text-red-500">Beranda</a>
      </div>
    </nav>

    {{-- MAIN --}}
    <main class="max-w-6xl mx-auto mt-8 px-4 grid grid-cols-1 md:grid-cols-3 gap-6">

      {{-- ARTICLE --}}
      <div class="md:col-span-2">
        <div class="bg-white rounded-2xl shadow-md p-6 md:p-8">

          <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 leading-tight">
            {{ Str::title($post->title) }}
          </h1>

          <div class="text-sm text-gray-500 mb-6 flex gap-4 flex-wrap">
            <span>👤 {{ $post->author->name ?? 'Admin' }}</span>
            <span>📅 {{ $post->created_at->format('d M Y') }}</span>
            <span>⏱️ {{ str_word_count($post->content) }} kata</span>
          </div>

          @if ($post->photo)
          <img
            src="{{ asset('storage/' . $post->photo) }}"
            class="w-full max-h-[500px] object-cover rounded-xl shadow-md cursor-pointer hover:scale-[1.01] transition"
            @click="open = true; img = '{{ asset('storage/' . $post->photo) }}'">
          @endif

          <div class="mt-6 text-gray-700 leading-relaxed space-y-4">
            @foreach (explode("\n", $post->content) as $p)
            @if(trim($p))
            <p>{{ $p }}</p>
            @endif
            @endforeach
          </div>

        </div>
      </div>

      {{-- SIDEBAR (STICKY MODERN) --}}
      <aside class="space-y-6 md:sticky md:top-24 h-fit">

        <div class="bg-white rounded-2xl shadow p-4">
          <h2 class="font-bold mb-3">🔥 Terbaru</h2>

          @foreach ($latestPosts ?? [] as $latest)
          <a href="{{ route('post.public.show', $latest->id) }}"
            class="block py-2 text-sm border-b hover:text-red-500">
            {{ Str::limit($latest->title, 40) }}
          </a>
          @endforeach
        </div>

        <div class="bg-white rounded-2xl shadow p-4">
          <h2 class="font-bold mb-3">📌 Lainnya</h2>

          @foreach ($olderPosts ?? [] as $old)
          <a href="{{ route('post.public.show', $old->id) }}"
            class="block py-2 text-sm border-b hover:text-gray-600">
            {{ Str::limit($old->title, 40) }}
          </a>
          @endforeach
        </div>

        {{-- CALENDAR --}}
        <div class="bg-white rounded-2xl shadow p-4">

          <div class="flex justify-between items-center mb-3">
            <button @click="cal.prevMonth()" class="px-2 py-1 bg-gray-100 rounded hover:bg-gray-200">←</button>

            <h2 class="font-bold capitalize text-gray-800">
              <span x-text="cal.monthName"></span>
              <span x-text="cal.year"></span>
            </h2>

            <button @click="cal.nextMonth()" class="px-2 py-1 bg-gray-100 rounded hover:bg-gray-200">→</button>
          </div>

          <div class="grid grid-cols-7 text-xs text-center text-gray-400 mb-2">
            <div>Min</div>
            <div>Sen</div>
            <div>Sel</div>
            <div>Rab</div>
            <div>Kam</div>
            <div>Jum</div>
            <div>Sab</div>
          </div>

          <div class="grid grid-cols-7 text-sm text-center gap-1">
            <template x-for="b in cal.blanks">
              <div></div>
            </template>

            <template x-for="day in cal.days">
              <div
                class="p-2 rounded-lg transition"
                :class="cal.isToday(day)
              ? 'bg-red-500 text-white font-bold shadow'
              : 'hover:bg-gray-100'"
                x-text="day">
              </div>
            </template>
          </div>

        </div>

      </aside>

    </main>

    {{-- FOOTER --}}
    <footer class="bg-gray-900 text-white text-center py-6 mt-12">
      <p class="text-sm opacity-70">&copy; {{ date('Y') }} MyBlog</p>
    </footer>

    {{-- MODAL IMAGE (SMOOTH + LOCK SCROLL) --}}
    <div
      x-show="open"
      x-transition.opacity
      class="fixed inset-0 bg-black/80 backdrop-blur flex items-center justify-center z-50"
      @click.self="open = false"
      style="display:none">

      <div class="relative max-w-5xl w-full px-4">
        <img :src="img"
          class="w-full max-h-[90vh] object-contain rounded-xl shadow-2xl">

        <button
          class="absolute top-3 right-3 bg-white text-black px-3 py-1 rounded-full shadow"
          @click="open = false">
          ✕
        </button>
      </div>
    </div>

  </div>

</body>

</html>