<x-app-layout>
  <x-slot name="header">
    @php
    $user = auth()->user();
    $wilayah = 'Tidak diketahui';
    if ($user->regency?->name) {
    $wilayah = Str::startsWith($user->regency->name, 'Kab.')
    ? 'Kabupaten ' . ltrim(substr($user->regency->name, 4))
    : $user->regency->name;
    } elseif ($user->district?->name) {
    $wilayah = 'Kec. ' . $user->district->name;
    } elseif ($user->village?->name) {
    $wilayah = $user->village->name;
    } elseif ($user->province?->name) {
    $wilayah = $user->province->name;
    }
    @endphp

    @section('title', 'PW ' . $wilayah)

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
      <div class="flex items-center gap-3">
        <img src="{{ asset('image/logo.png') }}" alt="Logo" class="w-12 h-12 object-contain">
        <div>
          <h2 class="text-xl font-bold text-gray-800">
            Dashboard - <span class="text-green-700">PW {{ $wilayah }}</span>
          </h2>
          <p class="text-sm text-gray-500">Selamat datang di dashboard PW {{ $wilayah }}</p>
        </div>
      </div>
      <a href="{{ route('surat-masuk.create') }}"
        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow text-sm">
        + Tambah Surat Masuk
      </a>
    </div>
  </x-slot>

  <div class="space-y-6 p-4 sm:p-6">
    <!-- Header ringkasan -->
    <div class="bg-gradient-to-r from-green-700 to-green-600 text-white rounded-xl shadow-lg p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5">
      <div class="flex items-center gap-4">
        <img src="{{ asset('image/logo.png') }}" alt="Logo" class="w-14 h-14 object-contain">
        <div>
          <h3 class="uppercase text-lg font-semibold">PW {{ $wilayah }}</h3>
          <p class="text-sm text-green-100">Ringkasan aktivitas surat & anggota</p>
        </div>
      </div>
      <div class="flex gap-8 text-sm">
        <div class="flex flex-col text-center">
          <span class="font-bold text-lg">Surat</span>
          <span class="text-green-100">Terbaru & Terkelola</span>
        </div>
        <div class="flex flex-col text-center">
          <span class="font-bold text-lg">Anggota</span>
          <span class="text-green-100">--</span>
        </div>
      </div>
    </div>

    <!-- Konten utama -->
    <div class="bg-white p-5 rounded-xl shadow-md">
      @if(session('success'))
      <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg shadow-sm">
        {{ session('success') }}
      </div>
      @endif

      <!-- Action bar -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
        <form method="GET" action="{{ route('surat-masuk.index') }}" class="flex w-full sm:w-auto gap-2">
          <input type="text" name="q" value="{{ request('q') }}"
            placeholder="Cari nomor, asal, perihal..."
            class="border border-gray-300 rounded-lg p-2 w-full sm:w-64 focus:ring-2 focus:ring-green-500 focus:outline-none">
          <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
            Cari
          </button>
        </form>
      </div>

      <!-- Table -->
      <div class="">
        <table class="min-w-full table-auto border border-gray-200 rounded-lg ">
          <thead class="bg-gray-100 text-gray-700">
            <tr>
              <th class="px-4 py-2 text-left">No</th>
              <th class="px-4 py-2 text-left">Nomor Surat</th>
              <th class="px-4 py-2 text-left">Asal Surat</th>
              <th class="px-4 py-2 text-left hidden sm:table-cell">Tanggal Surat</th>
              <th class="px-4 py-2 text-left">Perihal</th>
              <th class="px-4 py-2 text-center">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            @forelse($suratMasuk as $s)
            <tr class="hover:bg-gray-50 transition">
              <td class="px-4 py-2">{{ $loop->iteration }}</td>
              <td class="px-4 py-2 ">{{ $s->nomor_surat }}</td>
              <td class="px-4 py-2 ">{{ $s->asal_surat }}</td>
              <td class="px-4 py-2 hidden sm:table-cell ">{{ $s->tanggal_surat }}</td>
              <td class="px-4 py-2 max-w-xs truncate">{{ $s->perihal }}</td>
              <td class="px-4 py-2 text-center flex justify-center gap-2">
                <a href="{{ route('surat-masuk.show', $s->id) }}"
                  class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-xs shadow">
                  Detail
                </a>
                <a href="{{ route('surat-masuk.edit', $s->id) }}"
                  class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg text-xs shadow">
                  Edit
                </a>
                <form action="{{ route('surat-masuk.destroy', $s->id) }}" method="POST" class="inline delete-form">
                  @csrf
                  @method('DELETE')
                  <button type="button"
                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-xs shadow btn-delete">
                    Hapus
                  </button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="text-center py-4 text-gray-500">Belum ada data</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mt-5">
        <div class="text-sm text-gray-500">
          Menampilkan {{ $suratMasuk->firstItem() ?: 0 }} - {{ $suratMasuk->lastItem() ?: 0 }} dari {{ $suratMasuk->total() }} data
        </div>
        <div>
          {{ $suratMasuk->links() }}
        </div>
      </div>
    </div>
  </div>

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.querySelectorAll('.btn-delete').forEach(btn => {
      btn.addEventListener('click', function(e) {
        e.preventDefault();
        let form = this.closest('form');
        Swal.fire({
          title: 'Yakin hapus data ini?',
          text: "Tindakan ini tidak dapat dibatalkan!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#6c757d',
          confirmButtonText: 'Ya, hapus!',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit();
          }
        })
      });
    });
  </script>
</x-app-layout>