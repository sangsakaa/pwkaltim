<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>

  <title>PW KALTIM @yield('title')</title>
  <link rel="shortcut icon" href="{{ asset('image/logo.png') }}">

  <style>
    html {
      scroll-behavior: smooth;
    }

    .glass {
      background: rgba(4, 66, 38, 0.75);
      backdrop-filter: blur(14px);
    }

    .card {
      transition: 0.3s;
    }

    .card:hover {
      transform: translateY(-5px);
    }
  </style>
</head>

<body class="bg-gray-50 text-gray-800">

  <!-- NAV -->
  <nav class="fixed top-0 w-full z-50 glass text-white">
    <div class="max-w-7xl mx-auto px-4 flex justify-between items-center h-16">
      <div class="flex items-center gap-3">
        <img src="{{ asset('image/logo.png') }}" class="w-9 h-9 rounded-full">
        <span class="font-bold">PW KALTIM</span>
      </div>

      <div class="hidden md:flex gap-6 text-sm">
        <a href="/">Home</a>
        <a href="#profil">Profil</a>
        <a href="#postingan">Postingan</a>

        @auth
        <a href="/dashboard">Dashboard</a>
        @else
        <a href="/login">Login</a>
        @endauth
      </div>
    </div>
  </nav>

  <!-- HERO -->
  <section class="mt-16 py-16 text-center">
    <h1 class="text-4xl font-bold text-green-900">
      Selamat Datang di PW KALTIM
    </h1>
  </section>

  <!-- PROFIL -->
  <section id="profil" class="py-12 bg-white">
    <div class="max-w-6xl mx-auto px-4">
      <h2 class="text-2xl font-bold mb-6">Profil</h2>
      <p class="text-gray-600">...</p>
    </div>
  </section>

  {{-- ========================= --}}
  {{-- 🔥 POSTINGAN SECTION --}}
  {{-- ========================= --}}
  <section id="postingan" class="py-12 bg-gradient-to-b from-green-50 to-white">

    <div class="max-w-6xl mx-auto px-4">

      <h2 class="text-2xl font-bold text-green-900 mb-6">
        Informasi Terbaru
      </h2>

      @if($posts->count())

      <div class="grid md:grid-cols-3 gap-6">

        @foreach($posts as $post)
        <div class="bg-white rounded-xl shadow card overflow-hidden">

          @if($post->photo)
          <img src="{{ asset('storage/'.$post->photo) }}"
            class="h-44 w-full object-cover">
          @endif

          <div class="p-4 border-t-4 border-green-600">

            <a href="{{ route('post.public.show', $post->id) }}"
              class="font-bold text-green-800 hover:text-green-600">
              {{ $post->title }}
            </a>

            <p class="text-sm text-gray-500 mt-2">
              {{ \Illuminate\Support\Str::limit($post->content, 100) }}
            </p>

          </div>

        </div>
        @endforeach

      </div>

      @else
      <p class="text-gray-500">Belum ada postingan.</p>
      @endif

    </div>
  </section>

  <!-- FOOTER -->
  <footer class="bg-green-900 text-white py-8 mt-10">
    <div class="max-w-6xl mx-auto px-4 flex justify-between">
      <p>&copy; 2026 PW KALTIM</p>
    </div>
  </footer>

</body>

</html>