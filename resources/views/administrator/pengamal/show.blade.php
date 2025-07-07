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
                {{ __('Detail Pengamal') }}
            </h2>
        </div>
    </x-slot>

    <div class=" gap-2 grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1">
        <div class="  p-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
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
    <div class="p-4 bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class="flex flex-col md:flex-row gap-2">
            <!-- Foto Pengamal -->
            <div class=" sm:w-1/4 w-full flex items-center justify-center">
                @if ($pengamal->foto)
                <img src="{{ asset('storage/' . $pengamal->foto) }}" width="200" alt="Foto Pengamal" class=" object-cover rounded">
                @else
                <p>Tidak ada foto.</p>
                @endif
            </div>
            <!-- Detail Informasi -->
            <div class="w-full ">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white ">Detail Data Pengamal </h2>
                <div class=" grid grid-cols-1 sm:grid-cols-2 w-full">
                    <div class=" text-xm sm:text-sm">
                        <div class="flex grid-cols-2">
                            <div class="  w-1/3 ">NIK</div>
                            <div>: {{ $pengamal->nik }}</div>
                        </div>
                        <div class="flex grid-cols-2">
                            <div class="  w-1/3 ">Nama</div>
                            <div>: {{ $pengamal->nama_lengkap }}</div>
                        </div>
                        <div class="flex grid-cols-2">
                            <div class="  w-1/3 ">Agama</div>
                            <div>: {{ $pengamal->agama }}</div>
                        </div>
                        <div class="flex grid-cols-2">
                            <div class="  w-1/3 ">Tempat Lahir</div>
                            <div>: {{ $pengamal->tempat_lahir }}
                            </div>
                        </div>
                        <div class="flex grid-cols-2">
                            <div class="  w-1/3 ">Tanggal Lahir</div>
                            <div>: {{ $pengamal->tanggal_lahir }}</div>
                        </div>
                        <div class="flex grid-cols-2">
                            <div class="  w-1/3 ">Jenis Kelamin</div>
                            <div>: {{ $pengamal->jenis_kelamin }}</div>
                        </div>
                        <div class="flex grid-cols-2">
                            <div class="  w-1/3 ">Pekerjaan</div>
                            <div>: {{ $pengamal->pekerjaan }}</div>
                        </div>
                        <div class="flex grid-cols-2">
                            <div class="  w-1/3 ">Status</div>
                            <div>: {{ $pengamal->status_perkawinan }}</div>
                        </div>


                    </div>
                    <div class=" ">
                        <div class="flex grid-cols-2">
                            <div class="  w-1/3 ">Provinsi</div>
                            <div>: <span>
                                    {{$pengamal->province->name??''}}
                                </span>
                            </div>
                        </div>
                        <div class="flex grid-cols-2">
                            <div class="  w-1/3 ">Kabupaten</div>
                            <div>: <span>
                                    {{$pengamal->regency->name??''}}
                                </span>
                            </div>
                        </div>
                        <div class="flex grid-cols-2">
                            <div class="  w-1/3 ">Kecamatan</div>
                            <div>: <span>
                                    {{$pengamal->district->name??''}}
                                </span>
                            </div>
                        </div>

                        <div class="flex grid-cols-2">
                            <div class="  w-1/3 ">Desa</div>
                            <div>: <span>
                                    {{$pengamal->village->name??''}}
                                </span>
                            </div>
                        </div>
                        <div class="flex grid-cols-2">
                            <div class="  w-1/3 ">Alamat</div>
                            <div>: <span>
                                    {{$pengamal->alamat}}
                                </span>
                            </div>
                        </div>
                        <div class="flex grid-cols-2">
                            <div class="  w-1/3 ">RT / RW</div>
                            <div>: <span>
                                    RT {{$pengamal->rt??'-'}} , RW {{$pengamal->rw??'-'}}
                                </span>
                            </div>
                        </div>
                        <div class="flex grid-cols-2">
                            <div class="  w-1/3 ">Usia</div>
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
                            WA
                        </a>


                    </div>
                </div>
            </div>
        </div>

</x-app-layout>