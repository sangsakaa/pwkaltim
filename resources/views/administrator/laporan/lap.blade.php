<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Data Pengamal</title>
  <meta charset="UTF-8">
  <title>View PDF</title>



  <style>
    @page {
      margin: 5mm 5mm 5mm 5mm;
      /* top, right, bottom, left */
    }

    body {
      margin: 0;
      padding: 0;
    }

    body {
      font-family: sans-serif;
      font-size: 12px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th,
    td {
      border: none;
      padding: 6px;
      text-align: left;
    }



    h2 {
      text-align: center;
    }
  </style>
</head>

<body>

  <style>
    .kop-surat {

      /* hijau khas Wahidiyah */
      color: white;
      padding: 20px;
      display: flex;
      align-items: center;
      font-family: 'Arial', sans-serif;

    }

    .kop-surat img {
      width: 120px;
      height: 120px;
      margin-right: 20px;
    }

    .kop-surat .teks {
      flex: 1;
      text-align: center;
    }

    .kop-surat .yayasan {
      font-size: 14px;
      font-weight: bold;
      margin-bottom: 4px;
    }

    .kop-surat .departemen {
      font-size: 22px;
      font-weight: bold;
      line-height: 1.3;
    }

    .kop-surat .akta {
      font-size: 12px;
      margin-top: 5px;
    }

    .alamat {
      font-size: 12px;
      font-family: 'Arial', sans-serif;
      color: white;
      text-align: center;
      margin-top: 4px;
      border-top: 1px solid #007f3d;
      padding-top: 4px;
    }

    #container {
      display: flex;
      align-items: center;
    }

    #logo {

      text-align: center;
      /* Adjust this value to control the space between logo and title */
    }

    #tittle {
      display: flex;
      flex-direction: column;
    }

    #tittle span {
      text-align: left;
    }

    .h1 {
      background-color: rgba(7, 75, 36, 255);
      color: rgba(7, 75, 36, 255);
    }

    .kop {
      width: 100%;
      margin-top: 10px;
    }

    td {
      border: 1px solid #ddd;
      text-align: left;
      /* Center text in table cell */
      vertical-align: middle;
      /* Center vertically */
    }

    .center-img {
      display: block;
      margin-left: auto;
      margin-right: auto;
    }

    .nama_cap {
      font-size: 20px;
      font-weight: bold;
      text-transform: capitalize;
    }

    table {
      width: 100%;
      border: solid 1px;
    }

    td {
      border: solid 1px;
    }

    h1 {
      text-transform: capitalize;
      text-align: center;
    }

    th {

      font-weight: bold;
      border: solid 1px;
    }

    table tr:nth-child(even) {
      background-color: #f2f2f2;
      /* abu-abu muda */
    }

    table tr:hover {
      background-color: #ddd;
      /* efek hover */
    }

    table th,
    table td {

      padding: 8px;
    }
  </style>

  @php
  use Carbon\Carbon;

  // Grup berdasarkan nama kabupaten
  $grouped = $pengamal->groupBy(fn($item) => $item->regency->name ?? 'Tanpa Kabupaten');

  // Fungsi untuk menentukan kategori
  function kategori($item) {
  $usia = Carbon::parse($item->tanggal_lahir)->age;

  if (strtolower($item->jenis_kelamin) == 'l') {
  if ($usia <= 12) {
    return 'Kanak-kanak' ;
    } elseif ($usia <=40 && strtolower($item->status_perkawinan) != 'menikah') {
    return 'Remaja';
    } else {
    return 'Bapak-bapak';
    }
    } else {
    return 'Ibu-ibu';
    }
    }
    @endphp

    <!-- HEADER -->
    <style>
      .page-break {
        page-break-after: always;
      }
    </style>
    <table class="kop">
      <tr class="h1">
        <td class="logo">
          <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/image/logo.png'))) }}" height="145px" width="145px" alt="Example Image" style="margin-left: 30px;">
        </td>
        <td>
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


          <div class="kop-surat">
            <div class="teks">
              <div class="yayasan">YAYASAN PERJUANGAN WAHIDIYAH DAN PONDOK PESANTREN KEDUNGLO</div>
              <div class="departemen">DEPARTEMEN PEMBINA WAHIDIYAH<br><span>{{ Str::upper($wilayah) }}</span>
              </div>
              <div class="akta">AKTA NOMOR 09 TAHUN 2011 KEMENKUMHAM RI NOMOR : AHU-9371.AH.01.04 TAHUN 2011</div>
            </div>
            <div class="alamat">
              <!-- Alamat Sekretariat : Jalan Talang Sari RT. 01 Kelurahan Tanah Merah Kecamatan Samarinda Utara Kota Samarinda Kalimantan Timur -->
            </div>
          </div>
        </td>
      </tr>
    </table>
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
    <h2>DATA PENGAMAL <span>{{ Str::upper($wilayah) }}</h2>
    @foreach ($grouped as $kabupaten => $items)
    <h3>Data Pengamal - {{ $kabupaten }}</h3>
    <table border="1" cellpadding="5" cellspacing="0">
      <thead>
        <tr style="background-color: #076943; color: white;">
          <th style="text-align: center;">No</th>
          <th style="text-align: center;">Nama Lengkap</th>
          <th style="text-align: center;">Tempat, <br> Tanggal Lahir</th>
          <th style="text-align: center;">Jenis Kelamin</th>
          <th style="text-align: center;">Agama</th>
          <th style="text-align: center;">Alamat Lengkap</th>
          <th style="text-align: center;">No HP</th>
          <th style="text-align: center;">Status Perkawinan</th>
          <th style="text-align: center;">Pekerjaan</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($items as $i => $d)
        <tr class="{{ $loop->even ? 'bg-gray-100' : '' }}">
          <td>{{ $i + 1 }}</td>
          <td style=" width:200px; text-transform: uppercase;">{{ $d->nama_lengkap }}</td>


          <td style=" width:150px">{{ $d->tempat_lahir }}, {{ Carbon::parse($d->tanggal_lahir)->format('d-m-Y') }}</td>
          <td style="text-align: center;">{{ $d->jenis_kelamin }}</td>
          <td style="text-align: center;">{{ $d->agama }}</td>
          <td>
            RT {{ $d->rt }}/RW {{ $d->rw }},
            Desa {{ $d->village->name ?? '-' }},
            Kec. {{ $d->district->name ?? '-' }},
            Kab. {{ $d->regency->name ?? '-' }},
            Prov. {{ $d->province->name ?? '-' }}
          </td>
          <td style=" width:100px; text-align:center">{{ $d->no_hp }}</td>
          <td>{{ $d->status_perkawinan }}</td>
          <td>{{ $d->pekerjaan }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="page-break">
      <!-- Rekapitulasi Kategori -->
      @php
      $rekap = [
      'Kanak-kanak' => 0,
      'Remaja' => 0,
      'Bapak-bapak' => 0,
      'Ibu-ibu' => 0,
      ];

      foreach ($items as $orang) {
      $kategori = kategori($orang);
      $rekap[$kategori]++;
      }
      @endphp
      @endforeach


      <!-- logic umur -->
      @php
      $kategoriGlobal = [];

      foreach ($grouped as $kabupaten => $items) {
      foreach ($items->groupBy('district.name') as $kecamatan => $kecamatanItems) {
      if (!isset($kategoriGlobal[$kabupaten])) {
      $kategoriGlobal[$kabupaten] = [];
      }

      $kategoriGlobal[$kabupaten][$kecamatan] = [
      'Kanak-kanak' => 0,
      'Remaja' => 0,
      'Bapak-bapak' => 0,
      'Ibu-ibu' => 0,
      ];

      foreach ($kecamatanItems as $item) {
      $usia = Carbon::parse($item->tanggal_lahir)->age;
      $jk = strtolower($item->jenis_kelamin);
      $status = strtolower($item->status_perkawinan);


      if ($usia <= 12) {
        $kategoriGlobal[$kabupaten][$kecamatan]['Kanak-kanak']++;
        } elseif ($usia <=40 && $status !=='kawin' ) {
        $kategoriGlobal[$kabupaten][$kecamatan]['Remaja']++;
        } else {
        if ($jk==='p' && $usia<=20 && $status==='kawin' ) {
        $kategoriGlobal[$kabupaten][$kecamatan]['Ibu-ibu']++;
        } elseif ($jk==='l' ) {
        $kategoriGlobal[$kabupaten][$kecamatan]['Bapak-bapak']++;
        } elseif ($jk==='p' ) {
        $kategoriGlobal[$kabupaten][$kecamatan]['Ibu-ibu']++;
        }
        }
        }
        }
        }
        @endphp

        </div>
        <h2>Rekap Jumlah Pengamal Berdasarkan Kategori Usia per Kabupaten dan Kecamatan</h2>
        @foreach ($kategoriGlobal as $kabupaten => $kecamatans)
        <style>
          .splite {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            /* 3 kolom sama besar */
            gap: 20px;
            /* Jarak antar item */
          }
        </style>
        <div class=" splite">
          <style>
            .page-break {
              page-break-after: always;
            }
          </style>
          <h3>
            {{ $kabupaten }}
          </h3>
          <table border="1" cellpadding="5" cellspacing="0">
            <thead>
              <tr style="background-color: #076943; color: white; border: solid 1px; border:black">
                <th rowspan="2" style="text-align: center; vertical-align: middle;">Kecamatan</th>
                <th colspan="4" style="text-align: center;">Kelompok</th>
                <th rowspan="2" style="text-align: center; vertical-align: middle;">Total</th>

              </tr>
              <tr style="background-color: #076943;   color: white;">
                <th style="text-align: center; vertical-align: middle;">Kanak-kanak</th>
                <th style="text-align: center; vertical-align: middle;">Remaja</th>
                <th style="text-align: center; vertical-align: middle;">Bapak-bapak</th>
                <th style="text-align: center; vertical-align: middle;">Ibu-ibu</th>

              </tr>
            </thead>
            <tbody>
              @foreach ($kecamatans as $kecamatan => $data)
              <tr>
                <td style=" text-transform: uppercase;">{{ $kecamatan }}</td>
                <td style="text-align: center; vertical-align: middle;">{{ $data['Kanak-kanak'] }}</td>
                <td style="text-align: center; vertical-align: middle;">{{ $data['Remaja'] }}</td>
                <td style="text-align: center; vertical-align: middle;">{{ $data['Bapak-bapak'] }}</td>
                <td style="text-align: center; vertical-align: middle;">{{ $data['Ibu-ibu'] }}</td>
                <td style="text-align: center; vertical-align: middle;">{{ array_sum($data) }}</td>
              </tr>
              @endforeach
              <tr>
                <td>Jumlah</td>
                <td style=" text-align:center">{{ collect($kecamatans)->sum('Kanak-kanak') }}</td>
                <td style=" text-align:center">{{ collect($kecamatans)->sum('Remaja') }} </td>
                <td style=" text-align:center">{{ collect($kecamatans)->sum('Bapak-bapak') }} </td>
                <td style=" text-align:center">{{ collect($kecamatans)->sum('Ibu-ibu') }} </td>
                <td style=" text-align:center">
                  {{
            collect($kecamatans)->sum('Kanak-kanak')
            + collect($kecamatans)->sum('Remaja')
            + collect($kecamatans)->sum('Bapak-bapak')
            + collect($kecamatans)->sum('Ibu-ibu')
        }}
                </td>

              </tr>
            </tbody>
          </table>
        </div>
        @endforeach
        <div class="page-break">
          <!--  -->
</body>

</html>