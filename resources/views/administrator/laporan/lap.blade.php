<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Data Pengamal</title>

  <style>
    @page {
      margin: 8mm;
    }

    body {
      margin: 0;
      padding: 0;
      font-family: DejaVu Sans, sans-serif;
      font-size: 11px;
      color: #222;
    }

    h2 {
      text-align: center;
      margin: 12px 0;
      font-size: 16px;
      letter-spacing: 0.5px;
    }

    h3 {
      margin: 20px 0 8px;
      font-size: 13px;
      border-left: 4px solid #076943;
      padding-left: 8px;
    }

    .kop {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 10px;
    }

    .kop td {
      border: none;
    }

    .kop-box {
      background: #076943;
      color: #fff;
      padding: 10px;
      border-radius: 6px;
    }

    .kop-left {
      width: 140px;
      text-align: center;
    }

    .kop-right {
      text-align: center;
    }

    .yayasan {
      font-size: 12px;
      font-weight: bold;
      text-transform: uppercase;
    }

    .departemen {
      font-size: 18px;
      font-weight: bold;
      margin-top: 5px;
      line-height: 1.3;
    }

    .akta {
      font-size: 10px;
      margin-top: 6px;
      opacity: 0.95;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 8px;
    }

    th {
      background: #076943;
      color: #fff;
      padding: 8px;
      font-size: 11px;
      text-align: center;
    }

    td {
      padding: 7px;
      border-bottom: 1px solid #e5e5e5;
      vertical-align: top;
    }

    tr:nth-child(even) td {
      background: #f7f9f8;
    }

    .center {
      text-align: center;
    }

    .uppercase {
      text-transform: uppercase;
    }

    .page-break {
      page-break-after: always;
    }
  </style>
</head>

<body>

  @php
  use Carbon\Carbon;
  use Illuminate\Support\Str;

  $user = auth()->user();

  if ($user->regency?->name) {
  $wilayah = Str::startsWith($user->regency->name, 'Kab.')
  ? 'Kabupaten ' . ltrim(substr($user->regency->name, 4))
  : $user->regency->name;
  } elseif ($user->district?->name) {
  $wilayah = 'Kecamatan ' . $user->district->name;
  } elseif ($user->village?->name) {
  $wilayah = $user->village->name;
  } elseif ($user->province?->name) {
  $wilayah = $user->province->name;
  } else {
  $wilayah = 'Tidak diketahui';
  }
  @endphp

  <!-- HEADER -->
  <table class="kop">
    <tr class="kop-box">
      <td class="kop-left">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/image/logo.png'))) }}" width="100">
      </td>

      <td class="kop-right">
        <div class="yayasan">
          YAYASAN PERJUANGAN WAHIDIYAH DAN PONDOK PESANTREN KEDUNGLO
        </div>

        <div class="departemen">
          DEPARTEMEN PEMBINA WAHIDIYAH<br>
          {{ Str::upper($wilayah) }}
        </div>

        <div class="akta">
          AKTA NOMOR 09 TAHUN 2011 - AHU-9371.AH.01.04 TAHUN 2011
        </div>
      </td>
    </tr>
  </table>

  <h2>DATA PENGAMAL {{ Str::upper($wilayah) }}</h2>

  @foreach ($grouped as $kabupaten => $items)

  <h3>Data Pengamal - {{ $kabupaten }}</h3>

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Tempat, Tanggal Lahir</th>
        <th>JK</th>
        <th>Agama</th>
        <th>Alamat</th>
        <th>HP</th>
      </tr>
    </thead>

    <tbody>
      @foreach ($items as $i => $d)
      <tr>
        <td class="center">{{ $i + 1 }}</td>
        <td class="uppercase">{{ $d->nama_lengkap }}</td>
        <td>
          {{ $d->tempat_lahir ?? '-' }},
          {{ $d->tanggal_lahir ? Carbon::parse($d->tanggal_lahir)->format('d-m-Y') : '-' }}
        </td>
        <td class="center">{{ $d->jenis_kelamin ?? '-' }}</td>
        <td class="center">{{ $d->agama ?? '-' }}</td>
        <td>
          {{ $d->village->name ?? '-' }},
          {{ $d->district->name ?? '-' }},
          {{ $d->regency->name ?? '-' }}
        </td>
        <td class="center">{{ $d->no_hp ?? '-' }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <h3>Rekap Usia - {{ $kabupaten }}</h3>

  <table>
    <thead>
      <tr>
        <th>Kecamatan</th>
        <th>Kanak-kanak</th>
        <th>Remaja</th>
        <th>Bapak-bapak</th>
        <th>Ibu-ibu</th>
        <th>Total</th>
      </tr>
    </thead>

    <tbody>

      @php
      $sumK = 0;
      $sumR = 0;
      $sumB = 0;
      $sumI = 0;
      @endphp

      @foreach ($kategoriGlobal[$kabupaten] ?? [] as $kecamatan => $data)

      @php
      $total = $data['Kanak-kanak'] + $data['Remaja'] + $data['Bapak-bapak'] + $data['Ibu-ibu'] + $data['Tidak diketahui'];

      $sumK += $data['Kanak-kanak'];
      $sumR += $data['Remaja'];
      $sumB += $data['Bapak-bapak'];
      $sumI += $data['Ibu-ibu'];
      @endphp

      <tr>
        <td class="uppercase">{{ $kecamatan }}</td>
        <td class="center">{{ $data['Kanak-kanak'] }}</td>
        <td class="center">{{ $data['Remaja'] }}</td>
        <td class="center">{{ $data['Bapak-bapak'] }}</td>
        <td class="center">{{ $data['Ibu-ibu'] }}</td>
        <td class="center">{{ $total }}</td>
      </tr>

      @endforeach

      <tr style="font-weight:bold;">
        <td>Total</td>
        <td class="center">{{ $sumK }}</td>
        <td class="center">{{ $sumR }}</td>
        <td class="center">{{ $sumB }}</td>
        <td class="center">{{ $sumI }}</td>
        <td class="center">{{ $sumK + $sumR + $sumB + $sumI }}</td>
      </tr>

    </tbody>
  </table>

  @if (!$loop->last)
  <div class="page-break"></div>
  @endif

  @endforeach

</body>

</html>