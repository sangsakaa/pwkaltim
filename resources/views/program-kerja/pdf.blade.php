<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Program Kerja - {{ $waktu }}</title>
  <style>
    body {
      font-family: DejaVu Sans, sans-serif;
      font-size: 12px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    th,
    td {
      border: 1px solid #333;
      padding: 6px;
      text-align: left;
    }

    th {
      background: #f2f2f2;
    }

    h2 {
      text-align: center;
      margin-bottom: 15px;
    }

    tfoot td {
      font-weight: bold;
      background: #f9f9f9;
    }

    /* Kop styling */
    table.kop {
      width: 100%;
      border: none;
      background-color: #1b5e20;
      /* Hijau gelap */
      color: white;
      padding: 10px;
    }

    table.kop td {
      border: none;
      vertical-align: middle;
    }

    .kop-surat {
      text-align: center;
    }

    .kop-surat .yayasan {
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 4px;
    }

    .kop-surat .departemen {
      font-size: 14px;
      font-weight: bold;
      margin-bottom: 4px;
    }

    .kop-surat .departemen span {
      display: block;
      font-size: 20px;
      /* Lebih besar untuk wilayah */
      font-weight: bold;
      margin-top: 2px;
    }

    .kop-surat .akta {
      font-size: 11px;
    }
  </style>
</head>

<body>
  <table class="kop">
    <tr class="h1">
      <td class="logo" style="width: 150px;">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/image/logo.png'))) }}"
          height="120px" width="120px" alt="Example Image" style="margin-left: 20px;">
      </td>
      <td>
        @php
        $user = auth()->user();

        if ($user->regency?->name) {
        if (Str::startsWith($user->regency->name, 'Kab.')) {
        $wilayah = 'Kabupaten ' . ltrim(substr($user->regency->name, 4));
        } else {
        $wilayah = $user->regency->name;
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
          <div class="yayasan">YAYASAN PERJUANGAN WAHIDIYAH DAN PONDOK PESANTREN KEDUNGLO</div>
          <div class="departemen">
            DEPARTEMEN PEMBINA REMAJA WAHIDIYAH
            <span>{{ Str::upper($wilayah) }}</span>
          </div>
          <div class="akta">
            AKTA NOMOR 09 TAHUN 2011 KEMENKUMHAM RI NOMOR : AHU-9371.AH.01.04 TAHUN 2011
          </div>
        </div>
      </td>
    </tr>
  </table>

  <h2>Program Kerja - {{ ucfirst($waktu) }}</h2>

  <table>
    <thead>
      <tr>
        <th>Nomor</th>
        <th>Uraian Kegiatan</th>
        <th>Waktu</th>
        <th>Sasaran</th>
        <th>Target</th>
        <th>Biaya</th>
        <th>Penanggung Jawab</th>
      </tr>
    </thead>
    <tbody>
      @php $totalBiaya = 0; @endphp
      @forelse ($data as $row)
      @php $totalBiaya += $row->biaya; @endphp
      <tr>
        <td>{{ $row->nomor }}</td>
        <td>{{ $row->uraian_kegiatan }}</td>
        <td>{{ ucfirst($row->waktu_pelaksanaan) }}</td>
        <td>{{ $row->sasaran }}</td>
        <td>{{ $row->target }}</td>
        <td>Rp {{ number_format($row->biaya, 0, ',', '.') }}</td>
        <td>{{ $row->penanggung_jawab }}</td>
      </tr>
      @empty
      <tr>
        <td colspan="7" style="text-align: center">Tidak ada data</td>
      </tr>
      @endforelse
    </tbody>
    @if(count($data) > 0)
    <tfoot>
      <tr>
        <td colspan="5" style="text-align: right">Total Biaya</td>
        <td colspan="2">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</td>
      </tr>
    </tfoot>
    @endif
  </table>
</body>

</html>