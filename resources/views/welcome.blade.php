<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>

  <title>PW KALTIM @yield('title')</title>
  <link rel="shortcut icon" href="{{ asset('image/logo.png') }}">

  <!-- Toastr -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  <style>
    html {
      scroll-behavior: smooth;
    }

    /* Green glass navbar */
    .glass {
      background: rgba(4, 66, 38, 0.75);
      backdrop-filter: blur(14px);
    }

    .card {
      transition: 0.3s;
      border: 1px solid #e5e7eb;
    }

    .card:hover {
      transform: translateY(-5px);
      border-color: #16a34a;
      box-shadow: 0 10px 25px rgba(22, 163, 74, 0.15);
    }
  </style>
</head>

<body class="bg-gray-50 text-gray-800">

  <!-- NAVBAR -->
  <nav class="fixed top-0 w-full z-50 glass text-white shadow-lg border-b border-green-700/30">
    <div class="max-w-7xl mx-auto px-4 flex justify-between items-center h-16">

      <!-- Logo -->
      <div class="flex items-center gap-3">
        <img src="{{ asset('image/logo.png') }}" class="w-9 h-9 rounded-full">
        <span class="font-bold tracking-wide">PW KALTIM</span>
      </div>

      <!-- Desktop Menu -->
      <div class="hidden md:flex gap-6 text-sm font-medium">
        <a href="/" class="hover:text-green-300">Home</a>
        <a href="#home" class="hover:text-green-300">About</a>
        <a href="#profil" class="hover:text-green-300">Profil</a>
        <a href="#persyaratan" class="hover:text-green-300">Informasi</a>

        @auth
        <a href="{{ url('/dashboard') }}" class="hover:text-green-300">Dashboard</a>
        @else
        <a href="{{ route('login') }}" class="hover:text-green-300">Login</a>
        @endauth
      </div>

      <!-- Mobile -->
      <button id="menu-toggle" class="md:hidden text-white text-2xl">☰</button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden px-4 pb-4 text-white">
      <div class="flex flex-col gap-2 text-sm">
        <a href="#home">Home</a>
        <a href="#profil">Profil</a>
        <a href="#persyaratan">Informasi</a>
      </div>
    </div>
  </nav>

  <!-- HERO SLIDER -->
  <section class="mt-16 relative overflow-hidden">

    <!-- overlay -->
    <div class="absolute inset-0 bg-gradient-to-r from-green-900/60 to-black/30 z-10"></div>

    <div id="slider" class="flex transition-transform duration-700 relative z-0">
      <img src="{{ asset('image/slide.png') }}" class="w-full flex-shrink-0">
      <img src="{{ asset('image/slide2.png') }}" class="w-full flex-shrink-0">
      <img src="{{ asset('image/slide.png') }}" class="w-full flex-shrink-0">
    </div>

    <button id="prev" class="absolute left-3 top-1/2 z-20 -translate-y-1/2 bg-green-800/60 text-white px-3 py-2 rounded-full">
      ‹
    </button>

    <button id="next" class="absolute right-3 top-1/2 z-20 -translate-y-1/2 bg-green-800/60 text-white px-3 py-2 rounded-full">
      ›
    </button>
  </section>

  <!-- HERO TEXT -->
  <section id="home" class="py-16">
    <div class="max-w-6xl mx-auto px-4 text-center">
      <h1 class="text-3xl md:text-4xl font-bold text-green-900 mb-3">
        Selamat Datang di YPW KALTIM
      </h1>
      <p class="text-gray-500">
        SINTAK - Sistem Informasi Terpadu Pengamal Kalimantan Timur
      </p>
    </div>
  </section>

  <!-- PROFIL -->
  <section id="profil" class="py-12 bg-white">
    <div class="max-w-6xl mx-auto px-4">
      <h2 class="text-2xl font-bold text-green-900 mb-6">Profil</h2>

      <div class="grid md:grid-cols-2 gap-6 text-gray-600">
        <div>
          <!-- isi profil -->
        </div>
        <div>
          <!-- isi profil -->
        </div>
      </div>
    </div>
  </section>

  <!-- INFORMASI -->
  <section id="persyaratan" class="py-12 bg-gradient-to-b from-green-50 to-white">
    <div class="max-w-6xl mx-auto px-4">

      <h2 class="text-2xl font-bold text-green-900 mb-6">
        Informasi Terbaru
      </h2>

      @php
      use App\Models\Post;
      $posts = Post::where('status','approved')->latest()->take(3)->get();
      @endphp

      @if($posts->count())
      <div class="grid md:grid-cols-3 gap-6">

        @foreach($posts as $post)
        <div class="bg-white rounded-2xl card overflow-hidden">

          @if($post->photo)
          <img src="{{ asset('storage/'.$post->photo) }}" class="h-44 w-full object-cover">
          @endif

          <div class="p-4 border-t-4 border-green-600">
            <a href="/post-detail/{{$post->id}}" class="font-bold text-green-800 hover:text-green-600">
              {{ $post->title }}
            </a>

            <p class="text-sm text-gray-500 mt-2">
              {{ \Illuminate\Support\Str::limit($post->content, 90) }}
            </p>
          </div>

        </div>
        @endforeach

      </div>
      @else
      <p class="text-gray-500">Tidak ada data.</p>
      @endif

    </div>
  </section>

  <!-- FOOTER -->
  <footer class="bg-green-900 text-white py-8 mt-10">
    <div class="max-w-6xl mx-auto px-4 flex flex-col md:flex-row justify-between">
      <p>&copy; 2026 PW KALTIM</p>
      <div class="flex gap-4 text-sm mt-3 md:mt-0">
        <a href="#" class="hover:text-green-300">Privacy</a>
        <a href="#" class="hover:text-green-300">Terms</a>
      </div>
    </div>
  </footer>

  <!-- SCRIPT -->
  <script>
    let slider = document.getElementById('slider');
    let index = 0;
    const total = slider.children.length;

    function move() {
      slider.style.transform = `translateX(-${index * 100}%)`;
    }

    document.getElementById('next').onclick = () => {
      index = (index + 1) % total;
      move();
    }

    document.getElementById('prev').onclick = () => {
      index = (index - 1 + total) % total;
      move();
    }

    setInterval(() => {
      index = (index + 1) % total;
      move();
    }, 5000);

    document.getElementById('menu-toggle').onclick = () => {
      document.getElementById('mobile-menu').classList.toggle('hidden');
    }
  </script>

</body>

</html>