<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <x-button target="_blank" href="https://github.com/kamona-wd/kui-laravel-breeze" variant="black"
                class="justify-center max-w-xs gap-2">
                <x-icons.github class="w-6 h-6" aria-hidden="true" />
                <span>Detail Pengamal</span>
            </x-button>
        </div>
    </x-slot>

    <div class=" gap-2 grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1">
        <div class="  p-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
            <div class="  flex ">
                <div>
                    <img src="{{ asset('image/logofont.jpg') }}" width="200" alt="Logo">
                </div>
                <div class=" w-full flex items-center justify-center">
                    <marquee behavior="scroll" direction="left">
                        Selamat datang di website kami!
                    </marquee>
                </div>
            </div>
        </div>
    </div>
    <div class="p-4 bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Foto Pengamal -->
            <div class=" w-1/4 flex items-center justify-center">
                @if ($pengamal->foto)
                <img src="{{ asset('storage/' . $pengamal->foto) }}" alt="Foto Pengamal" class=" object-cover rounded">
                @else
                <p>Tidak ada foto.</p>
                @endif
            </div>

            <!-- Detail Informasi -->
            <div class="w-full ">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white ">Detail Data Pengamal </h2>
                <div class=" grid grid-cols-1 sm:grid-cols-2 w-full">
                    <div>
                        <div class="grid grid-cols-2">
                            <div><strong>NIK</strong></div>
                            <div>: {{ $pengamal->nik }}</div>
                        </div>
                        <div class="grid grid-cols-2">
                            <div><strong>Nama Lengkap</strong></div>
                            <div>: {{ $pengamal->nama_lengkap }}</div>
                        </div>
                        <div class="grid grid-cols-2">
                            <div><strong>Agama</strong></div>
                            <div>: {{ $pengamal->agama }}</div>
                        </div>
                        <div class="grid grid-cols-2">
                            <div><strong>Tempat Lahir</strong></div>
                            <div>: {{ $pengamal->tempat_lahir }}
                            </div>
                        </div>
                        <div class="grid grid-cols-2">
                            <div><strong>Tanggal Lahir</strong></div>
                            <div>: {{ $pengamal->tanggal_lahir }}</div>
                        </div>
                        <div class="grid grid-cols-2">
                            <div><strong>Jenis Kelamin</strong></div>
                            <div>: {{ $pengamal->jenis_kelamin }}</div>
                        </div>


                    </div>
                    <div class=" ">

                        <div class="flex grid-cols-2">
                            <div class=" w-1/4"><strong>Provinsi</strong></div>
                            <div>: <span>
                                    {{$pengamal->province->name??''}}
                                </span>
                            </div>
                        </div>
                        <div class="flex grid-cols-2">
                            <div class=" w-1/4"><strong>Kabupaten</strong></div>
                            <div>: <span>
                                    {{$pengamal->regency->name??''}}
                                </span>
                            </div>
                        </div>
                        <div class="flex grid-cols-2">
                            <div class=" w-1/4"><strong>Kecamatan</strong></div>
                            <div>: <span>
                                    {{$pengamal->district->name??''}}
                                </span>
                            </div>
                        </div>

                        <div class="flex grid-cols-2">
                            <div class=" w-1/4"><strong>Desa</strong></div>
                            <div>: <span>
                                    {{$pengamal->village->name??''}}
                                </span>
                            </div>
                        </div>
                        <div class="flex grid-cols-2">
                            <div class=" w-1/4"><strong>Alamat</strong></div>
                            <div>: <span>
                                    {{$pengamal->alamat}}, RT {{$pengamal->rt??'-'}} , RW {{$pengamal->rw??'-'}}
                                </span>
                            </div>
                        </div>
                        <div class="flex grid-cols-2">
                            <div class=" w-1/4"><strong>Usia</strong></div>
                            <div>: {{ \Carbon\Carbon::parse($pengamal->tanggal_lahir)->age }} tahun
                            </div>
                        </div>
                    </div>


                    <!-- Tombol Aksi -->
                    <div class="mt-5 flex gap-3">
                        <a href="/pengamal/edit/{{ $pengamal->id }}">
                            <button class="px-4 py-1 text-white bg-blue-500 rounded hover:bg-blue-600">
                                Edit
                            </button>
                        </a>
                        <a href="/pengamal">
                            <button class="px-4 py-1 text-white bg-blue-500 rounded hover:bg-blue-600">
                                Kembali
                            </button>
                        </a>
                        <form action="/pengamal/show/{{ $pengamal->id }}" method="post" class="form-delete">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-1 text-white bg-red-500 rounded hover:bg-red-600">
                                Hapus
                            </button>
                        </form>
                        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

                        <!-- SweetAlert2 -->
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




                        <a href="https://wa.me/{{$pengamal->no_hp}}?text=Halo%20saya%20tertarik%20dengan%20layanan%20Anda"
                            target="_blank"
                            style="display:inline-block; background-color:#25D366; color:white; padding:5px 20px; border-radius:5px; text-decoration:none; font-weight:bold;">
                            WhatsApp
                        </a>


                    </div>
                </div>
            </div>
        </div>

</x-app-layout>