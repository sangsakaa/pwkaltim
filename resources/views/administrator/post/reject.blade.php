<x-app-layout>
  <x-slot name="header">
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
    @section('title', 'PW '. $wilayah )
    <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between ">
      <h2 class="text-xl font-semibold leading-tight">
        {{ __('Management Pengamal') }}
      </h2>
    </div>
  </x-slot>

  <div class=" gap-2 grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1">
    <div class="  p-2 overflow-hidden bg-white rounded-md shadow-md">
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
  <div class="  p-2 overflow-hidden bg-white rounded-md shadow-md">

    <div class=" bg-white p-6 ">
      <h2 class="text-2xl font-semibold mb-4">Postingan Pernah Di-Approve Tapi Ditolak</h2>
      @forelse ($posts as $post)
      <div class="border p-4 mb-4 rounded">
        <h3 class="text-xl font-bold">{{ $post->title }}</h3>
        <p class="text-sm text-gray-600">
          Oleh: {{ $post->creator->name }} |
          Disetujui oleh: {{ optional($post->approver)->name }} |
          Ditolak: {{ optional($post->approved_at)->format('d M Y') }}
        </p>
        <p class="mt-2">{{ Str::limit($post->content, 200) }}</p>
        <div class=" flex gap-2">
          <div>
            <form method="POST" action="/post/{{ $post->id}}/approve" class="flex gap-2">
              @csrf
              @method('PUT')

              <button type="submit" name="action" value="approve"
                class=" bg-green-700 text-white px-2 py-1">
                Approve
              </button>

              <button type="submit" name="action" value="reject"
                class=" bg-red-600 text-white px-2 py-1">
                Reject
              </button>
            </form>
          </div>
          <div>
            <form action="{{ route('post.destroy', $post->id) }}" method="POST" class="inline">
              @csrf
              @method('DELETE')
              @php
              $canDelete = auth()->user()->hasAnyRole(['superAdmin', 'admin-provinsi', 'admin-kabupaten']);
              @endphp
              <button
                type="submit"
                class="px-4 py-1 text-white rounded 
               {{ $canDelete ? 'bg-red-500 hover:bg-red-600' : 'bg-gray-400 cursor-not-allowed' }}"
                {{ $canDelete ? '' : 'disabled' }}>
                Hapus
              </button>
            </form>
          </div>
        </div>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
          $(document).ready(function() {
            $('.form-delete').on('submit', function(e) {
              e.preventDefault(); // Cegah langsung submit form

              const form = this;

              Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Data yang dihapus tidak bisa dikembalikan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
              }).then((result) => {
                if (result.isConfirmed) {
                  form.submit();
                } else {
                  toastr.info('Penghapusan dibatalkan.');
                }
              });
            });
          });
        </script>

      </div>
      @empty
      <p>Tidak ada postingan yang pernah disetujui lalu ditolak.</p>
      @endforelse
    </div>
  </div>

</x-app-layout>