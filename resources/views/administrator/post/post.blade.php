<x-app-layout>
  <x-slot name="header">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
      <h2 class="text-xl font-semibold leading-tight">
        {{ __('Dashboard') }}
      </h2>
      <x-button target="_blank" href="https://github.com/kamona-wd/kui-laravel-breeze" variant="black"
        class="justify-center max-w-xs gap-2">
        <x-icons.github class="w-6 h-6" aria-hidden="true" />
        <span>Data Pengamal</span>
      </x-button>
    </div>
  </x-slot>

  <div class=" gap-2 grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1">
    <div class="   overflow-hidden bg-white rounded-md shadow-md">
      <div class="  flex ">

        <div class="bg-green-800 flex flex-col items-center justify-center p-1">
          <img src="{{ asset('image/logo.png') }}" width="50" alt="Logo">
        </div>

        <div class="bg-green-800 w-full sm:grid sm:grid-cols-1 flex flex-col items-center text-white fw-semibold p-4">
          @php
          $user = auth()->user();

          if ($user->regency?->name) {
          if (Str::startsWith($user->regency->name, 'Kab.')) {
          $wilayah = 'Kabupaten ' . ltrim(substr($user->regency->name, 4));
          } else {
          $wilayah = $user->regency->name; // Biarkan 'Kota ...' atau lainnya
          }
          } elseif ($user->district?->name) {
          $wilayah = 'Kec. ' . $user->district->name;
          } elseif ($user->village?->name) {
          $wilayah = $user->village->name;
          } elseif ($user->province?->name) {
          $wilayah = $user->province->name;
          } else {
          $wilayah = 'Tidak diketahui';
          }
          @endphp
          <span class="uppercase text-lg fw-semibold">PW {{ $wilayah }}</span>
        </div>

      </div>
    </div>
  </div>
  <div class="mt-2 p-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-gray-800 dark:text-white">
    <div class="p-6">
      <h2 class="text-2xl font-semibold mb-4">Buat Postingan</h2>
      <form method="POST" action="/post/store" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Judul -->
        <div>
          <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Judul</label>
          <input type="text" name="title" id="title" class="mt-1 w-full border p-2 rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
        </div>

        <!-- Slug -->
        <div>
          <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Slug</label>
          <input type="text" name="slug" id="slug" class="mt-1 w-full border p-2 rounded bg-gray-100 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400" readonly>
        </div>

        <!-- Foto -->
        <div>
          <label for="photo" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Foto</label>
          <input type="file" name="photo" id="photo" class="mt-1 w-full border p-2 rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white" accept="image/*">
          <img id="preview" src="#" alt="Preview Gambar" style="display:none;" width="500px">
        </div>

        <!-- Kategori -->
        <div>
          <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Kategori</label>
          <select name="category_id" id="category_id" class="mt-1 w-full border p-2 rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
          </select>
        </div>

        <!-- Isi -->
        <div>
          <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Isi</label>
          <textarea name="content" id="content" rows="5" class="mt-1 w-full border p-2 rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white" required></textarea>
        </div>

        <!-- Submit -->
        <div>
          <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded">
            Kirim
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function slugify(text) {
      return text.toString().toLowerCase()
        .replace(/\s+/g, '-') // Ganti spasi dengan -
        .replace(/[^\w\-]+/g, '') // Hapus karakter non-word
        .replace(/\-\-+/g, '-') // Ganti dua - dengan satu
        .replace(/^-+/, '') // Hapus - di awal
        .replace(/-+$/, ''); // Hapus - di akhir
    }

    document.getElementById('title').addEventListener('input', function() {
      const title = this.value;
      const slug = slugify(title);
      document.getElementById('slug').value = slug;
    });
  </script>
  <script>
    const imageUpload = document.getElementById('photo');
    const preview = document.getElementById('preview');

    photo.addEventListener('change', function() {
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
          preview.src = e.target.result;
          preview.style.display = 'block';
        }

        reader.readAsDataURL(file);
      }
    });
  </script>

</x-app-layout>