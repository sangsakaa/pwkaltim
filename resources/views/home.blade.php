<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>PW KALTIM - SINTAK</title>

  <!-- Favicon -->
  <link rel="icon"
    href="https://pendataan.ypwkalimantantimur.my.id/image/logo.png">

  <!-- SEO -->
  <meta name="description"
    content="SINTAK - Sistem Informasi Terpadu Pengamal Kalimantan Timur">

  <!-- Open Graph / WhatsApp -->
  <meta property="og:type" content="website">
  <meta property="og:title" content="PW KALTIM - SINTAK">
  <meta property="og:description"
    content="Sistem Informasi Terpadu Pengamal Kalimantan Timur">
  <meta property="og:url"
    content="https://pendataan.ypwkalimantantimur.my.id">

  <meta property="og:image"
    content="https://pendataan.ypwkalimantantimur.my.id/image/logo.png">
  <meta property="og:image:secure_url"
    content="https://pendataan.ypwkalimantantimur.my.id/image/logo.png">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">

  <!-- Twitter -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="PW KALTIM - SINTAK">
  <meta name="twitter:description"
    content="Sistem Informasi Terpadu Pengamal Kalimantan Timur">
  <meta name="twitter:image"
    content="https://pendataan.ypwkalimantantimur.my.id/image/logo.png">

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Toastr -->
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  <style>
    html {
      scroll-behavior: smooth;
    }

    body {
      background: #f8fafc;
    }

    .glass {
      background: rgba(4, 66, 38, 0.85);
      backdrop-filter: blur(15px);
    }

    .card {
      transition: .3s ease;
      border: 1px solid #e5e7eb;
    }

    .card:hover {
      transform: translateY(-5px);
      border-color: #16a34a;
      box-shadow: 0 10px 25px rgba(22, 163, 74, .15);
    }

    .slider-image {
      width: 100%;
      height: 75vh;
      object-fit: cover;
      flex-shrink: 0;
    }

    @media(max-width:768px) {
      .slider-image {
        height: 45vh;
      }
    }
  </style>
</head>

<body class="text-gray-800">

  <!-- NAVBAR -->
  <nav
    class="fixed top-0 w-full z-50 glass text-white border-b border-green-700/30 shadow-lg">

    <div
      class="max-w-7xl mx-auto px-5 h-16 flex items-center justify-between">

      <div class="flex items-center gap-3">
        <img src="https://pendataan.ypwkalimantantimur.my.id/image/logo.png"
          class="w-10 h-10 rounded-full object-cover">

        <span class="font-bold text-lg">
          PW KALTIM
        </span>
      </div>

      <!-- Desktop -->
      <div class="hidden md:flex gap-8 text-sm font-medium">
        <a href="#home" class="hover:text-green-300">
          Home
        </a>

        <a href="#profil" class="hover:text-green-300">
          Profil
        </a>

        <a href="#info" class="hover:text-green-300">
          Informasi
        </a>

        <a href="#link" class="hover:text-green-300">
          Link Publik
        </a>
      </div>

      <!-- Mobile Button -->
      <button id="menu-toggle"
        class="md:hidden text-2xl">
        ☰
      </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu"
      class="hidden md:hidden px-5 pb-4 bg-green-900">

      <div class="flex flex-col gap-3 text-sm">
        <a href="#home">Home</a>
        <a href="#profil">Profil</a>
        <a href="#info">Informasi</a>
        <a href="#link">Link Publik</a>
      </div>
    </div>
  </nav>

  <!-- HERO -->
  <section class="mt-16 relative overflow-hidden">

    <div
      class="absolute inset-0 bg-gradient-to-r from-green-950/70 to-black/30 z-10">
    </div>

    <div id="slider"
      class="flex transition-transform duration-700">

      <img src="https://pendataan.ypwkalimantantimur.my.id/image/slide.png"
        class="slider-image">

      <img src="https://pendataan.ypwkalimantantimur.my.id/image/slide2.png"
        class="slider-image">

      <img src="https://pendataan.ypwkalimantantimur.my.id/image/slide.png"
        class="slider-image">
    </div>

    <button id="prev"
      class="absolute left-4 top-1/2 -translate-y-1/2 z-20 bg-green-800/70 px-4 py-2 rounded-full text-white">
      ‹
    </button>

    <button id="next"
      class="absolute right-4 top-1/2 -translate-y-1/2 z-20 bg-green-800/70 px-4 py-2 rounded-full text-white">
      ›
    </button>
  </section>

  <!-- HOME -->
  <section id="home"
    class="py-20 text-center px-5">

    <h1
      class="text-4xl md:text-5xl font-bold text-green-900">
      Selamat Datang di YPW KALTIM
    </h1>

    <p class="text-gray-500 mt-4">
      SINTAK - Sistem Informasi Terpadu Pengamal Kalimantan Timur
    </p>
  </section>

  <!-- PROFIL -->
  <section id="profil"
    class="bg-white py-20">

    <div class="max-w-6xl mx-auto px-5">

      <h2
        class="text-3xl font-bold text-green-900 mb-8">
        Profil
      </h2>

      <div class="grid md:grid-cols-2 gap-6">

        <div class="card rounded-2xl p-6 bg-white">
          Isi profil kiri
        </div>

        <div class="card rounded-2xl p-6 bg-white">
          Isi profil kanan
        </div>

      </div>
    </div>
  </section>

  <!-- INFORMASI -->
  <section id="info"
    class="py-20 bg-gradient-to-b from-green-50 to-white">

    <div class="max-w-6xl mx-auto px-5">

      <h2
        class="text-3xl font-bold text-green-900 mb-8">
        Informasi Terbaru
      </h2>

      <div class="grid md:grid-cols-3 gap-6">

        <a href="/reservasi"
          class="card p-6 rounded-2xl bg-green-50 hover:bg-green-100 block">

          <h3 class="font-semibold text-green-800">
            Reservasi
          </h3>

          <p class="text-sm text-gray-600 mt-2">
            Buka halaman reservasi utama
          </p>
        </a>

        <a href="/reservasi/edit"
          class="card p-6 rounded-2xl bg-green-50 hover:bg-green-100 block">

          <h3 class="font-semibold text-green-800">
            Edit Reservasi
          </h3>

          <p class="text-sm text-gray-600 mt-2">
            Edit data reservasi yang sudah dibuat
          </p>
        </a>

        <a href="/pengamal/public/create"
          class="card p-6 rounded-2xl bg-green-50 hover:bg-green-100 block">

          <h3 class="font-semibold text-green-800">
            Daftar Pengamal
          </h3>

          <p class="text-sm text-gray-600 mt-2">
            Form pendaftaran pengamal baru
          </p>
        </a>
      </div>
    </div>
  </section>

  <!-- LINK PUBLIK -->
  <section id="link"
    class="bg-white py-20">

    <div class="max-w-6xl mx-auto px-5">

      <h2
        class="text-3xl font-bold text-green-900 mb-8">
        Link Publik
      </h2>

      <div class="grid md:grid-cols-3 gap-6">

        <a href="/dashboard"
          class="card p-6 rounded-2xl bg-green-50 hover:bg-green-100">

          Dashboard
        </a>

        <a href="/login"
          class="card p-6 rounded-2xl bg-green-50 hover:bg-green-100">

          Login
        </a>

        <a href="/register"
          class="card p-6 rounded-2xl bg-green-50 hover:bg-green-100">

          Pendaftaran
        </a>

      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="bg-green-900 text-white py-8">

    <div
      class="max-w-6xl mx-auto px-5 flex justify-between flex-wrap gap-3">

      <p>© 2026 PW KALTIM</p>

      <div class="flex gap-4 text-sm">
        <a href="#">Privacy</a>
        <a href="#">Terms</a>
      </div>
    </div>
  </footer>

  <script>
    const slider = document.getElementById('slider');
    const total = slider.children.length;

    let index = 0;

    function moveSlider() {
      slider.style.transform =
        `translateX(-${index * 100}%)`;
    }

    document
      .getElementById('next')
      .onclick = () => {
        index = (index + 1) % total;
        moveSlider();
      };

    document
      .getElementById('prev')
      .onclick = () => {
        index = (index - 1 + total) % total;
        moveSlider();
      };

    setInterval(() => {
      index = (index + 1) % total;
      moveSlider();
    }, 5000);

    document
      .getElementById('menu-toggle')
      .onclick = () => {
        document
          .getElementById('mobile-menu')
          .classList.toggle('hidden');
      };
  </script>

</body>

</html>