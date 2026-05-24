@php


$user = auth()->user();

$wilayah = match (true) {
$user->regency?->name !== null => Str::startsWith($user->regency->name, 'Kab.')
? 'Kabupaten ' . Str::after($user->regency->name, 'Kab. ')
: $user->regency->name,

$user->district?->name !== null => 'Kec. ' . $user->district->name,

$user->village?->name !== null => $user->village->name,

$user->province?->name !== null => $user->province->name,

default => 'Tidak diketahui',
};
@endphp

<x-app-layout>

  <x-slot name="header">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
      <h2 class="text-xl font-semibold">
        {{ __('Dashboard') }}
      </h2>
    </div>
  </x-slot>

  {{-- HEADER WILAYAH --}}
  <div class="bg-white shadow rounded-md overflow-hidden">

    <div class="flex">

      <div class="bg-green-800 flex items-center justify-center p-3">
        <img src="{{ asset('image/logo.png') }}" class="w-12 h-12 object-contain" alt="Logo">
      </div>

      <div class="bg-green-800 w-full flex items-center px-4 py-3">
        <span class="text-white uppercase font-semibold text-lg tracking-wide">
          PW {{ $wilayah }}
        </span>
      </div>

    </div>
  </div>

  {{-- FORM POST --}}
  <div class="mt-6 bg-white rounded-lg shadow p-6">

    <h2 class="text-2xl font-semibold mb-6">
      Buat Postingan
    </h2>

    <form method="POST"
      action="{{ route('post.store') }}"
      enctype="multipart/form-data"
      class="space-y-5">

      @csrf

      {{-- TITLE --}}
      <div>
        <label class="block text-sm font-medium mb-1">Judul</label>
        <input type="text"
          name="title"
          id="title"
          class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200"
          placeholder="Masukkan judul..."
          required>
      </div>

      {{-- SLUG --}}
      <div>
        <label class="block text-sm font-medium mb-1">Slug</label>
        <input type="text"
          name="slug"
          id="slug"
          class="w-full border rounded-lg p-2 bg-gray-100"
          readonly>
      </div>

      {{-- FOTO --}}
      <div>
        <label class="block text-sm font-medium mb-1">Foto</label>

        <input type="file"
          name="photo"
          id="photo"
          class="w-full border rounded-lg p-2"
          accept="image/*">

        <img id="preview"
          class="mt-3 hidden w-64 h-40 object-cover rounded-lg shadow"
          alt="Preview">
      </div>

      {{-- CATEGORY --}}
      <div>
        <label class="block text-sm font-medium mb-1">Kategori</label>

        <select name="category_id"
          class="w-full border rounded-lg p-2"
          required>

          <option value="">-- Pilih Kategori --</option>

          @foreach ($categories as $category)
          <option value="{{ $category->id }}">
            {{ $category->name }}
          </option>
          @endforeach

        </select>
      </div>

      {{-- CONTENT --}}
      <div>
        <label class="block text-sm font-medium mb-1">Isi</label>

        <textarea name="content"
          rows="6"
          class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200"
          placeholder="Tulis isi postingan..."
          required></textarea>
      </div>

      {{-- BUTTON --}}
      <div class="flex justify-end">
        <button type="submit"
          class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow">
          Kirim
        </button>
      </div>

    </form>

  </div>

  {{-- SCRIPT --}}
  <script>
    function slugify(text) {
      return text.toString().toLowerCase()
        .trim()
        .replace(/\s+/g, '-')
        .replace(/[^\w\-]+/g, '')
        .replace(/\-\-+/g, '-');
    }

    const title = document.getElementById('title');
    const slug = document.getElementById('slug');

    title.addEventListener('input', () => {
      slug.value = slugify(title.value);
    });

    const photoInput = document.getElementById('photo');
    const preview = document.getElementById('preview');

    photoInput.addEventListener('change', function() {
      const file = this.files[0];

      if (!file) {
        preview.src = '';
        preview.classList.add('hidden');
        return;
      }

      const reader = new FileReader();

      reader.onload = (e) => {
        preview.src = e.target.result;
        preview.classList.remove('hidden');
      };

      reader.readAsDataURL(file);
    });
  </script>

</x-app-layout>