<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>PW KALTIM - SINTAK</title>

  <meta name="description"
    content="SINTAK - Sistem Informasi Terpadu Pengamal Kalimantan Timur">

  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <style>
    html {
      scroll-behavior: smooth;
    }

    body {
      background: #f8fafc;
    }

    .card-hover {
      transition: .3s;
    }

    .card-hover:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, .08);
    }
  </style>
</head>

<body class="text-slate-700">

  <!-- NAVBAR -->
  <nav x-data="{open:false}"
    class="bg-gradient-to-r from-green-900 via-green-800 to-green-700 border-b border-green-950 shadow-lg sticky top-0 z-50">

    <div
      class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">

      <div class="flex items-center gap-3">

        <img src="{{ asset('image/logo.png') }}"
          class="w-14 h-14"
          alt="Logo">

        <div>
          <h1 class="font-bold text-2xl text-white">
            PW KALTIM
          </h1>

          <p class="text-green-400 font-semibold">
            SINTAK
          </p>
        </div>

      </div>

      <div class="hidden md:flex items-center gap-8">

        <a href="#home"
          class="font-medium hover:text-white">
          Home
        </a>

        <a href="#profil"
          class="font-medium hover:text-white">
          Profil
        </a>

        <a href="#informasi"
          class="font-medium hover:text-white">
          Informasi
        </a>

        <a href="#publik"
          class="font-medium hover:text-white">
          Publik
        </a>

        @guest
        <a href="{{ route('login') }}"
          class="bg-green-600 text-white px-5 py-2 rounded-xl hover:bg-green-700">
          Login
        </a>
        @endguest

        @auth
        <a href="/dashboard"
          class="bg-green-600 text-white px-5 py-2 rounded-xl">
          Dashboard
        </a>
        @endauth

      </div>

    </div>
  </nav>

  <!-- HERO -->
  <section id="home" class="py-10">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

      <div
        class="bg-white rounded-[32px] overflow-hidden shadow-xl grid lg:grid-cols-2">

        <div class="p-8 lg:p-14">

          <span
            class="inline-flex bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-medium">
            Sistem Informasi Terintegrasi
          </span>

          <h1
            class="text-4xl lg:text-6xl font-extrabold mt-6 leading-tight">

            Selamat Datang di

            <span class="text-green-700">
              YPW KALTIM
            </span>

          </h1>

          <p class="mt-6 text-slate-600 text-lg leading-8">

            Platform digital untuk pengelolaan informasi,
            reservasi, dan layanan pengamal Kalimantan Timur
            secara terpadu, cepat, modern, dan profesional.

          </p>

          <div class="flex flex-wrap gap-4 mt-8">

            <a href="{{ url('/reservasi') }}"
              class="bg-green-600 text-white px-6 py-4 rounded-xl font-semibold hover:bg-green-700">

              Reservasi Sekarang

            </a>

            <a href="#profil"
              class="border border-green-600 text-green-600 px-6 py-4 rounded-xl font-semibold">

              Pelajari Lebih Lanjut

            </a>

          </div>

        </div>

        <div>

          <img src="{{ asset('image/kaltim.png') }}"
            alt="Kalimantan Timur"
            class="w-full h-full object-cover">

        </div>

      </div>

    </div>

  </section>

  <!-- CONTENT -->
  <section class="pb-14">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

      <div class="grid lg:grid-cols-3 gap-8">

        <!-- PROFIL -->
        <div id="profil">

          <h2
            class="text-2xl font-bold text-slate-900 mb-5">
            Profil Organisasi
          </h2>

          <div
            class="bg-white rounded-3xl shadow-sm border p-6 card-hover">

            <h3
              class="text-xl font-bold text-green-700 mb-3">
              Tentang Kami
            </h3>

            <p class="text-slate-600">
              Isi sejarah, visi, misi, tujuan,
              dan informasi umum organisasi.
            </p>

          </div>

          <div
            class="bg-white rounded-3xl shadow-sm border p-6 mt-5 card-hover">

            <h3
              class="text-xl font-bold text-green-700 mb-3">
              Struktur & Program
            </h3>

            <p class="text-slate-600">
              Jelaskan struktur organisasi,
              program kerja, layanan dan agenda.
            </p>

          </div>

        </div>

        <!-- INFORMASI -->
        <div id="informasi">

          <h2
            class="text-2xl font-bold text-slate-900 mb-5">
            Informasi & Layanan
          </h2>

          <div
            class="bg-white rounded-3xl shadow-sm border divide-y">

            <a href="{{ url('/reservasi') }}"
              class="block p-5 hover:bg-green-50">
              Reservasi
            </a>

            <a href="{{ url('/reservasi/edit') }}"
              class="block p-5 hover:bg-green-50">
              Cek Reservasi
            </a>

            <a href="{{ url('/daftar-pengamal') }}"
              class="block p-5 hover:bg-green-50">
              Daftar Pengamal
            </a>

            <a href="#"
              class="block p-5 hover:bg-green-50">
              Link Publik
            </a>

          </div>

        </div>

        <!-- PUBLIK -->
        <div id="publik">

          <h2
            class="text-2xl font-bold text-slate-900 mb-5">
            Link Publik
          </h2>

          <div
            class="bg-white rounded-3xl shadow-sm border divide-y">

            <a href="#"
              class="block p-5 hover:bg-green-50">
              Website Resmi
            </a>

            <a href="#"
              class="block p-5 hover:bg-green-50">
              Informasi Kegiatan
            </a>

            <a href="#"
              class="block p-5 hover:bg-green-50">
              Kontak Pengurus
            </a>

          </div>

        </div>

      </div>

    </div>

  </section>

  <!-- FOOTER -->
  <footer
    class="bg-green-950 text-white py-8">

    <div
      class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center">

      <div class="flex items-center gap-3">

        <img src="{{ asset('image/logo.png') }}"
          class="w-12 h-12">

        <div>

          <h3 class="font-bold">
            PW KALTIM
          </h3>

          <p class="text-green-300 text-sm">
            SINTAK - Sistem Informasi Terpadu
          </p>

        </div>

      </div>

      <p class="text-green-300 mt-4 md:mt-0">
        © {{ date('Y') }} PW KALTIM. All Rights Reserved.
      </p>

    </div>

  </footer>

</body>

</html>