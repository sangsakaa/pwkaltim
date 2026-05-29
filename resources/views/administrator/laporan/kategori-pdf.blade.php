```blade
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Laporan Pengamal {{ $kategori }}</title>

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
      margin: 14px 0;
      font-size: 16px;
      letter-spacing: .5px;
    }

    h3 {
      margin: 18px 0 8px;
      font-size: 14px;
      border-left: 5px solid #076943;
      padding-left: 8px;
      color: #076943;
    }

    h4 {
      margin: 14px 0 8px;
      font-size: 12px;
      color: #333;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 18px;
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
      font-size: 11px;
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

    .kop {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 14px;
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
    }

    .badge {
      display: inline-block;
      padding: 4px 12px;
      border-radius: 999px;
      background: #ecfdf5;
      color: #065f46;
      font-size: 10px;
      font-weight: bold;
    }
  </style>
</head>

<body>

  @php
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

  /*
  |--------------------------------------------------------------------------
  | GROUPING
  |--------------------------------------------------------------------------
  */
  $grouped = $pengamal
  ->groupBy(fn($item) => $item->regency->name ?? 'Tanpa Kabupaten')
  ->map(function ($items) {
  return $items->groupBy(fn($item) => $item->district->name ?? 'Tanpa Kecamatan');
  });
  @endphp

  {{-- HEADER --}}
  <table class="kop">
    <tr class="kop-box">

      <td class="kop-left">
        <img
          src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/image/logo.png'))) }}"
          width="100">
      </td>

      <td class="kop-right">

        <div class="yayasan">
          YAYASAN PERJUANGAN WAHIDIYAH DAN PONDOK PESANTREN KEDUNGLO
        </div>

        <div class="departemen">
          DEPARTEMEN PEMBINA WAHIDIYAH <br>
          {{ Str::upper($wilayah) }}
        </div>

        <div class="akta">
          AKTA NOMOR 09 TAHUN 2011 - AHU-9371.AH.01.04 TAHUN 2011
        </div>

      </td>
    </tr>
  </table>

  <h2>
    LAPORAN PENGAMAL {{ Str::upper($kategori) }}
  </h2>

  <div style="text-align:center; margin-bottom:20px;">
    <span class="badge">
      WILAYAH: {{ Str::upper($wilayah) }}
    </span>
  </div>

  {{-- LOOP KABUPATEN --}}
  @foreach ($grouped as $kabupaten => $kecamatans)

  <h3>
    Kabupaten: {{ $kabupaten }}
  </h3>

  {{-- LOOP KECAMATAN --}}
  @foreach ($kecamatans as $kecamatan => $items)

  <h4>
    Kecamatan: {{ $kecamatan }}
  </h4>

  <table>
    <thead>
      <tr>
        <th width="40">No</th>
        <th>Nama</th>
        <th width="50">JK</th>
        <th>Desa</th>
      </tr>
    </thead>

    <tbody>

      @foreach ($items as $item)

      <tr>
        <td class="center">
          {{ $loop->iteration }}
        </td>

        <td class="uppercase">
          {{ $item->nama_lengkap }}
        </td>

        <td class="center">
          {{ $item->jenis_kelamin }}
        </td>

        <td>
          {{ $item->village->name ?? '-' }}
        </td>
      </tr>

      @endforeach

    </tbody>
  </table>
  @endforeach
  @endforeach
</body>
</html>
