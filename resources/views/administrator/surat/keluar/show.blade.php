<x-app-layout>
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

  @section('title', 'Detail Surat')

  <x-slot name="header">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
      <div>
        <h2 class="text-2xl font-bold text-gray-800">
          Detail Surat
        </h2>
        <p class="text-sm text-gray-500">
          PW {{ $wilayah }}
        </p>
      </div>

      <a href="{{ route('surat.index') }}"
        class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-xl text-gray-700">
        ← Kembali
      </a>
    </div>
  </x-slot>

  <div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

      {{-- Hero Card --}}
      <div
        class="bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 rounded-3xl shadow-xl overflow-hidden">
        <div class="p-8 text-white">

          <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">

            <div class="flex items-center gap-4">
              <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-sm">
                <img src="{{ asset('image/logo.png') }}"
                  alt="Logo"
                  class="w-14 h-14">
              </div>

              <div>
                <h3 class="text-2xl font-bold">
                  {{ $surat->nomor_surat }}
                </h3>

                <p class="text-green-100">
                  {{ $surat->perihal }}
                </p>
              </div>
            </div>

            <div class="bg-white/10 px-5 py-4 rounded-2xl backdrop-blur-sm">
              <div class="text-sm text-green-100">
                Kepada
              </div>

              <div class="font-semibold">
                {{ $surat->kepada }}
              </div>
            </div>

          </div>

        </div>
      </div>

      {{-- Detail Surat --}}
      <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden">

        <div class="px-6 py-5 border-b bg-gray-50">
          <h3 class="text-lg font-semibold text-gray-800">
            Informasi Surat
          </h3>
        </div>

        <div class="p-6">

          <div class="grid lg:grid-cols-2 gap-6">

            <div class="space-y-4">

              <div class="bg-gray-50 rounded-xl p-4">
                <div class="text-sm text-gray-500">Nomor Surat</div>
                <div class="font-semibold">{{ $surat->nomor_surat }}</div>
              </div>

              <div class="bg-gray-50 rounded-xl p-4">
                <div class="text-sm text-gray-500">Lampiran</div>
                <div class="font-semibold">{{ $surat->lampiran ?: '-' }}</div>
              </div>

              <div class="bg-gray-50 rounded-xl p-4">
                <div class="text-sm text-gray-500">Perihal</div>
                <div class="font-semibold">{{ $surat->perihal }}</div>
              </div>

              <div class="bg-gray-50 rounded-xl p-4">
                <div class="text-sm text-gray-500">Kepada</div>
                <div class="font-semibold">{{ $surat->kepada }}</div>
              </div>

            </div>

            <div class="space-y-4">

              <div class="bg-gray-50 rounded-xl p-4">
                <div class="text-sm text-gray-500">Tempat</div>
                <div class="font-semibold">{{ $surat->tempat }}</div>
              </div>

              <div class="bg-gray-50 rounded-xl p-4">
                <div class="text-sm text-gray-500">Tanggal Hijriah</div>
                <div class="font-semibold">{{ $surat->tanggal_hijriah }}</div>
              </div>

              <div class="bg-gray-50 rounded-xl p-4">
                <div class="text-sm text-gray-500">Tanggal Masehi</div>
                <div class="font-semibold">
                  {{ \Carbon\Carbon::parse($surat->tanggal_masehi)->format('d F Y') }}
                </div>
              </div>

              <div class="bg-gray-50 rounded-xl p-4">
                <div class="text-sm text-gray-500">Penandatangan</div>
                <div class="font-semibold">{{ $surat->penandatangan }}</div>
              </div>

            </div>

          </div>

          <div class="mt-6">
            <div class="bg-gray-50 rounded-xl p-5">
              <h4 class="font-semibold mb-3 text-gray-700">
                Isi Surat
              </h4>

              <div class="leading-relaxed whitespace-pre-line text-gray-700">
                {!! e($surat->isi_surat) !!}
              </div>
            </div>
          </div>

        </div>

      </div>

      {{-- Upload File --}}
      <div class="bg-white rounded-3xl shadow-sm border border-gray-200">

        <div class="px-6 py-5 border-b bg-gray-50">
          <h3 class="text-lg font-semibold">
            Upload File Surat
          </h3>
        </div>

        <div class="p-6">

          <form action="{{ route('surat.upload', $surat->id) }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf

            <div class="space-y-4">

              <input type="file"
                name="file_surat"
                accept=".pdf,.jpg,.jpeg,.png"
                class="block w-full border border-gray-300 rounded-xl p-3">

              <button type="submit"
                class="px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow">
                Upload File
              </button>

            </div>

          </form>

        </div>

      </div>

      {{-- Daftar File --}}
      @if($surat->files && $surat->files->count())

      <div class="bg-white rounded-3xl shadow-sm border border-gray-200">

        <div class="px-6 py-5 border-b bg-gray-50">
          <h3 class="text-lg font-semibold">
            Daftar File Surat
          </h3>
        </div>

        <div class="divide-y">

          @foreach($surat->files as $file)

          <div class="p-5 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

            <div>

              <div class="font-medium text-gray-800">
                📎 {{ $file->nama_file }}
              </div>

              <div class="mt-1">
                <span
                  class="inline-flex px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">
                  {{ strtoupper($file->tipe_file) }}
                </span>
              </div>

            </div>

            <div class="flex flex-wrap gap-2">

              <a href="{{ asset('storage/' . $file->path_file) }}"
                target="_blank"
                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm">
                View
              </a>

              <a href="{{ route('surat.file.download', $file->id) }}"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm">
                Download
              </a>

              <form action="{{ route('surat.file.delete', $file->id) }}"
                method="POST"
                class="delete-file-form">

                @csrf
                @method('DELETE')

                <button type="submit"
                  class="btn-delete-file px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm">
                  Hapus
                </button>

              </form>

            </div>

          </div>

          @endforeach

        </div>

      </div>

      @endif

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    document.querySelectorAll('.btn-delete-file').forEach(btn => {

      btn.addEventListener('click', function(e) {

        e.preventDefault();

        let form = this.closest('form');

        Swal.fire({
          title: 'Hapus file?',
          text: 'File yang dihapus tidak dapat dikembalikan.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#dc2626',
          cancelButtonColor: '#6b7280',
          confirmButtonText: 'Ya, Hapus',
          cancelButtonText: 'Batal'
        }).then((result) => {

          if (result.isConfirmed) {
            form.submit();
          }

        });

      });

    });
  </script>

</x-app-layout>