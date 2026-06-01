<!doctype html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>PW KALTIM</title>
  <link rel="shortcut icon" href="https://pendataan.ypwkalimantantimur.my.id/image/logo.png">

  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Toastr -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

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

      <div class="flex items-center gap-3">
        <img src="https://pendataan.ypwkalimantantimur.my.id/image/logo.png" class="w-9 h-9 rounded-full">
        <span class="font-bold">PW KALTIM</span>
      </div>

      <div class="hidden md:flex gap-6 text-sm">
        <a href="#home" class="hover:text-green-300">Home</a>
        <a href="#profil" class="hover:text-green-300">Profil</a>
        <a href="#info" class="hover:text-green-300">Informasi</a>
        <a href="#link" class="hover:text-green-300">Link Publik</a>
      </div>

      <button id="menu-toggle" class="md:hidden text-2xl">☰</button>
    </div>

    <div id="mobile-menu" class="hidden md:hidden px-4 pb-4 text-white">
      <div class="flex flex-col gap-2 text-sm">
        <a href="#home">Home</a>
        <a href="#profil">Profil</a>
        <a href="#info">Informasi</a>
        <a href="#link">Link Publik</a>
      </div>
    </div>
  </nav>

  <!-- HERO -->
  <section class="mt-16 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-green-900/60 to-black/30 z-10"></div>

    <div id="slider" class="flex transition-transform duration-700 relative z-0">
      <img src="https://pendataan.ypwkalimantantimur.my.id/image/slide.png" class="w-full flex-shrink-0">
      <img src="https://pendataan.ypwkalimantantimur.my.id/image/slide2.png" class="w-full flex-shrink-0">
      <img src="https://pendataan.ypwkalimantantimur.my.id/image/slide.png" class="w-full flex-shrink-0">
    </div>

    <button id="prev" class="absolute left-3 top-1/2 z-20 bg-green-800/60 text-white px-3 py-2 rounded-full">‹</button>
    <button id="next" class="absolute right-3 top-1/2 z-20 bg-green-800/60 text-white px-3 py-2 rounded-full">›</button>
  </section>

  <!-- HOME -->
  <section id="home" class="py-16 text-center">
    <h1 class="text-4xl font-bold text-green-900">Selamat Datang di YPW KALTIM</h1>
    <p class="text-gray-500 mt-2">SINTAK - Sistem Informasi Terpadu Pengamal Kalimantan Timur</p>
  </section>

  <!-- PROFIL -->
  <section id="profil" class="py-14 bg-white">
    <div class="max-w-6xl mx-auto px-4">
      <h2 class="text-2xl font-bold text-green-900 mb-6">Profil</h2>

      <div class="grid md:grid-cols-2 gap-6 text-gray-600">
        <div class="card p-5 rounded-xl">Isi profil kiri</div>
        <div class="card p-5 rounded-xl">Isi profil kanan</div>
      </div>
    </div>
  </section>

  <!-- INFORMASI -->
  <section id="info" class="py-14 bg-gradient-to-b from-green-50 to-white">
    <div class="max-w-6xl mx-auto px-4">

      <h2 class="text-2xl font-bold text-green-900 mb-6">Informasi Terbaru</h2>

      <div class="grid md:grid-cols-3 gap-6">

        <!-- <div class="card bg-white p-5 rounded-xl">
          <h3 class="font-semibold text-green-800">Pendaftaran Dibuka</h3>
          <p class="text-sm text-gray-500 mt-2">
            Sistem pendaftaran pengamal sudah aktif.
          </p>
        </div>

        <div class="card bg-white p-5 rounded-xl">
          <h3 class="font-semibold text-green-800">Verifikasi Data</h3>
          <p class="text-sm text-gray-500 mt-2">
            Pastikan data sudah benar sebelum proses verifikasi.
          </p>
        </div>

        <div class="card bg-white p-5 rounded-xl">
          <h3 class="font-semibold text-green-800">Pengumuman Resmi</h3>
          <p class="text-sm text-gray-500 mt-2">
            Informasi hanya dari website resmi PW KALTIM.
          </p>
        </div> -->

        <!-- LINK RESERVASI -->
        <a href="/reservasi"
          class="card bg-green-50 p-5 rounded-xl hover:bg-green-100 block">
          <h3 class="font-semibold text-green-800">Reservasi</h3>
          <p class="text-sm text-gray-600 mt-2">
            Buka halaman reservasi utama
          </p>
        </a>

        <a href="/reservasi/edit"
          class="card bg-green-50 p-5 rounded-xl hover:bg-green-100 block">
          <h3 class="font-semibold text-green-800">Edit Reservasi</h3>
          <p class="text-sm text-gray-600 mt-2">
            Edit data reservasi yang sudah dibuat
          </p>
        </a>

        <!-- LINK PENGAMAL -->
        <a href="{{ route('pengamal.public.create') }}"
          class="card bg-green-50 p-5 rounded-xl hover:bg-green-100 block">
          <h3 class="font-semibold text-green-800">Daftar Pengamal</h3>
          <p class="text-sm text-gray-600 mt-2">
            Form pendaftaran pengamal baru
          </p>
        </a>

      </div>

    </div>
  </section>
  <!-- LINK PUBLIK -->
  <section id="link" class="py-14 bg-white">
    <div class="max-w-6xl mx-auto px-4">

      <h2 class="text-2xl font-bold text-green-900 mb-6">Link Publik</h2>

      <div class="grid md:grid-cols-3 gap-6">

        <a href="/dashboard" class="card p-5 rounded-xl bg-green-50 hover:bg-green-100">
          <h3 class="font-semibold text-green-800">Dashboard</h3>
          <p class="text-sm text-gray-600">Akses sistem admin</p>
        </a>

        <a href="/login" class="card p-5 rounded-xl bg-green-50 hover:bg-green-100">
          <h3 class="font-semibold text-green-800">Login</h3>
          <p class="text-sm text-gray-600">Masuk akun pengguna</p>
        </a>

        <a href="/register" class="card p-5 rounded-xl bg-green-50 hover:bg-green-100">
          <h3 class="font-semibold text-green-800">Pendaftaran</h3>
          <p class="text-sm text-gray-600">Daftar anggota baru</p>
        </a>

      </div>

    </div>
  </section>

  <!-- FOOTER -->
  <footer class="bg-green-900 text-white py-8 mt-10">
    <div class="max-w-6xl mx-auto px-4 flex justify-between">
      <p>&copy; 2026 PW KALTIM</p>
      <div class="flex gap-4 text-sm">
        <a href="#">Privacy</a>
        <a href="#">Terms</a>
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