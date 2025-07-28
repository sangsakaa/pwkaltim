<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $post->title }} - MyBlog</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800">

  {{-- Navbar --}}
  <nav class="bg-gray-800 text-white">
    <div class="max-w-6xl mx-auto px-4 py-4 flex flex-col md:flex-row md:items-center md:justify-between">
      <a href="/" class="text-2xl font-bold">MyBlog</a>
      <div class="flex gap-4 mt-2 md:mt-0">
        <a href="/" class="hover:text-red-500 transition">Beranda</a>
        <!-- <a href="/posts" class="hover:text-red-500 transition">Postingan</a> -->
        <!-- <a href="/about" class="hover:text-red-500 transition">Tentang</a> -->
      </div>
    </div>
  </nav>

  {{-- Konten Utama --}}
  <main class="max-w-4xl mx-auto mt-10 px-4">
    <div class="bg-white shadow-md rounded-lg p-6">
      <h1 class="text-3xl font-bold text-gray-900 mb-6">{{ $post->title }}</h1>

      @if ($post->photo)
      <div class="mb-6">
        <img src="{{ asset('storage/' . $post->photo) }}" alt="Foto Postingan" class="w-full max-h-[500px] object-cover rounded-md shadow-sm">
      </div>
      @endif

      <div class="prose prose-lg max-w-none text-justify leading-relaxed tracking-normal text-gray-800">
        @foreach (explode("\n", $post->content) as $paragraph)
        <p>{{ $paragraph }}</p>
        @endforeach
      </div>
      {{-- Navigasi Postingan --}}
      <div class="mt-10 flex flex-col md:flex-row justify-between gap-4">
        @if ($previousPost)
        <a href="{{ route('post.public.show', $previousPost->id) }}" class="inline-block px-6 py-3 bg-gray-200 hover:bg-gray-300 rounded-lg font-semibold text-gray-800 transition">
          ← {{ Str::limit($previousPost->title, 30) }}
        </a>
        @else
        <div></div>
        @endif

        @if ($nextPost)
        <a href="{{ route('post.public.show', $nextPost->id) }}" class="inline-block px-6 py-3 bg-red-500 hover:bg-red-600 text-white rounded-lg font-semibold transition">
          {{ Str::limit($nextPost->title, 30) }} →
        </a>
        @else
        <div></div>
        @endif
      </div>
    </div>
  </main>

  {{-- Footer --}}
  <footer class="bg-gray-800 text-white text-center py-4 mt-10">
    <p class="text-sm">&copy; {{ date('Y') }} MyBlog. Semua hak dilindungi.</p>
  </footer>

</body>

</html>