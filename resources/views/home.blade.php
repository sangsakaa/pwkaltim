<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>PW KALTIM - SINTAK</title>

  <meta name="description"
    content="SINTAK - Sistem Informasi Terpadu Pengamal Kalimantan Timur">

  <meta property="og:title" content="PW KALTIM - SINTAK">
  <meta property="og:description"
    content="Sistem Informasi Terpadu Pengamal Kalimantan Timur">

  <meta property="og:image"
    content="{{ asset('image/logo.png') }}">

  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    html {
      scroll-behavior: smooth;
    }

    body {
      overflow-x: hidden;
    }

    .glass {
      backdrop-filter: blur(20px);
      background: rgba(6, 78, 59, .88);
    }

    .card-hover {
      transition: all .35s ease;
    }

    .card-hover:hover {
      transform: translateY(-6px);
      box-shadow: 0 20px 40px rgba(22, 101, 52, .12);
    }
  </style>
</head>

<body class="bg-green-50 text-slate-700">

  <!-- NAVBAR -->
  <nav
    class="fixed top-0 z-50 w-full glass border-b border-green-700/20 text-white">

    <div
      class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between">

      <!-- Logo -->
      <div class="flex items-center gap-3">

        <img src="{{ asset('image/logo.png') }}"
          alt="Logo PW KALTIM"
          class="w-10 h-10 sm:w-12 sm:h-12 rounded-full ring-2 ring-green-400/30">

        <div>
          <h1 class="font-bold tracking-wide text-sm sm:text-base">
            PW KALTIM
          </h1>

          <p class="text-[11px] sm:text-xs text-green-200">
            SINTAK
          </p>
        </div>
      </div>

      <!-- Menu -->
      <div
        class="flex items-center gap-3 sm:gap-6 text-xs sm:text-sm md:text-base font-medium">

        <a href="#home"
          class="hover:text-green-300 transition">
          Home
        </a>

        <a href="#profil"
          class="hover:text-green-300 transition">
          Profil
        </a>

        <a href="#informasi"
          class="hover:text-green-300 transition">
          Informasi
        </a>

        <a href="#publik"
          class="hover:text-green-300 transition">
          Publik
        </a>
      </div>
    </div>
  </nav>

  <!-- HERO -->
  <section id="home"
    class="relative min-h-screen overflow-hidden flex items-center">

    <!-- Background -->
    <div
      class="absolute inset-0 bg-gradient-to-br from-green-950 via-green-900 to-emerald-700">
    </div>

    <!-- Glow -->
    <div
      class="absolute top-[-120px] left-[-80px] w-[320px] h-[320px] bg-green-400/10 rounded-full blur-3xl">
    </div>

    <div
      class="absolute bottom-[-140px] right-[-100px] w-[380px] h-[380px] bg-emerald-300/10 rounded-full blur-3xl">
    </div>

    <!-- Overlay -->
    <div
      class="absolute inset-0 bg-gradient-to-r from-green-950/90 via-green-900/60 to-transparent">
    </div>

    <!-- Content -->
    <div
      class="relative z-10 max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 pt-28 sm:pt-32 pb-20 w-full">

      <div class="max-w-3xl text-white">

        <span
          class="inline-flex items-center px-4 py-2 rounded-full border border-green-300/20 bg-green-500/10 text-xs sm:text-sm backdrop-blur-md">

          Sistem Informasi Terintegrasi
        </span>

        <h1
          class="text-4xl sm:text-5xl lg:text-7xl font-extrabold mt-6 leading-tight">

          Selamat Datang di

          <span class="text-green-400">
            YPW KALTIM
          </span>
        </h1>

        <p
          class="mt-6 text-sm sm:text-lg text-green-50/90 leading-7 sm:leading-8 max-w-2xl">

          Platform digital untuk pengelolaan informasi,
          reservasi, dan layanan pengamal Kalimantan Timur
          secara terpadu, cepat, modern, dan profesional.
        </p>

        <!-- Button -->
        <div
          class="flex flex-col sm:flex-row gap-4 mt-10">

          <a href="{{ url('/reservasi') }}"
            class="bg-green-600 hover:bg-green-700 text-center px-6 py-4 rounded-2xl font-semibold transition shadow-lg shadow-green-900/20">

            Reservasi Sekarang
          </a>

          <a href="#profil"
            class="border border-white/20 hover:bg-white/10 text-center px-6 py-4 rounded-2xl transition">

            Pelajari Lebih Lanjut
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- PROFIL -->
  <section id="profil"
    class="py-16 sm:py-24 bg-green-50">

    <div
      class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8">

      <div class="text-center mb-12 sm:mb-16">

        <h2
          class="text-3xl sm:text-4xl font-bold text-green-950">
          Profil Organisasi
        </h2>

        <p
          class="text-slate-500 mt-4 text-sm sm:text-base">
          Informasi umum mengenai PW KALTIM
        </p>
      </div>

      <div class="grid md:grid-cols-2 gap-6 sm:gap-8">

        <div
          class="bg-white rounded-[28px] p-6 sm:p-8 border border-green-100 shadow-sm card-hover">

          <h3
            class="text-xl sm:text-2xl font-semibold mb-4 text-green-800">

            Tentang Kami
          </h3>

          <p
            class="leading-7 sm:leading-8 text-slate-600">
            Isi sejarah, visi, misi, tujuan,
            dan informasi umum organisasi.
          </p>
        </div>

        <div
          class="bg-white rounded-[28px] p-6 sm:p-8 border border-green-100 shadow-sm card-hover">

          <h3
            class="text-xl sm:text-2xl font-semibold mb-4 text-green-800">

            Struktur & Program
          </h3>

          <p
            class="leading-7 sm:leading-8 text-slate-600">
            Jelaskan struktur, program kerja,
            layanan, dan agenda organisasi.
          </p>
        </div>

      </div>
    </div>
  </section>

  <!-- INFORMASI -->
  <section id="informasi"
    class="py-16 sm:py-24 bg-gradient-to-b from-green-50 to-white">

    <div
      class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8">

      <div class="text-center mb-12 sm:mb-14">

        <h2
          class="text-3xl sm:text-4xl font-bold text-green-950">

          Informasi & Layanan
        </h2>
      </div>

      <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">

        <a href="{{ url('/reservasi') }}"
          class="bg-white rounded-[28px] p-6 sm:p-8 border border-green-100 shadow-sm card-hover">

          <h3
            class="font-bold text-lg sm:text-xl text-green-700">
            Reservasi
          </h3>

          <p class="text-slate-500 mt-3">
            Akses layanan reservasi secara online.
          </p>
        </a>

        <a href="{{ url('/reservasi/edit') }}"
          class="bg-white rounded-[28px] p-6 sm:p-8 border border-green-100 shadow-sm card-hover">

          <h3
            class="font-bold text-lg sm:text-xl text-green-700">
            Edit Reservasi
          </h3>

          <p class="text-slate-500 mt-3">
            Kelola data reservasi yang telah dibuat.
          </p>
        </a>

        <a href="{{ url('/daftar-pengamal') }}"
          class="bg-white rounded-[28px] p-6 sm:p-8 border border-green-100 shadow-sm card-hover">

          <h3
            class="font-bold text-lg sm:text-xl text-green-700">
            Daftar Pengamal
          </h3>

          <p class="text-slate-500 mt-3">
            Registrasi pengamal baru secara online.
          </p>
        </a>

      </div>
    </div>
  </section>

  <!-- LINK PUBLIK -->
  <section id="publik"
    class="py-16 sm:py-24 bg-white">

    <div
      class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8">

      <div class="text-center mb-12">

        <h2
          class="text-3xl sm:text-4xl font-bold text-green-950">

          Link Publik
        </h2>

        <p class="text-slate-500 mt-4">
          Akses layanan publik organisasi
        </p>
      </div>

      <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">

        <a href="#"
          class="bg-green-50 border border-green-100 rounded-3xl p-6 card-hover">
          Website Resmi
        </a>

        <a href="#"
          class="bg-green-50 border border-green-100 rounded-3xl p-6 card-hover">
          Informasi Kegiatan
        </a>

        <a href="#"
          class="bg-green-50 border border-green-100 rounded-3xl p-6 card-hover">
          Kontak Pengurus
        </a>

      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer
    class="bg-green-950 text-green-100 py-8">

    <div
      class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-5 text-center md:text-left">

      <div>
        <h3 class="font-bold text-white">
          PW KALTIM
        </h3>

        <p class="text-sm mt-2 text-green-300">
          SINTAK - Sistem Informasi Terpadu
        </p>
      </div>

      <p class="text-sm text-green-300">
        © {{ date('Y') }} PW KALTIM. All Rights Reserved.
      </p>
    </div>
  </footer>

</body>

</html>