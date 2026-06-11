<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Laporan Realisasi Program Kerja</title>

  <style>
    @page {
      margin: 10mm;
    }

    body {
      font-family: DejaVu Sans, sans-serif;
      font-size: 11px;
      color: #222;
      margin: 0;
      padding: 0;
    }

    /* =========================
           KOP SURAT
        ========================= */
    .kop {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 15px;
    }

    .kop td {
      border: none;
    }

    .kop-box {
      background: #076943;
      color: #fff;
    }

    .kop-left {
      width: 110px;
      text-align: center;
      padding: 12px;
    }

    .kop-right {
      text-align: center;
      padding: 12px;
    }

    .yayasan {
      font-size: 12px;
      font-weight: bold;
      text-transform: uppercase;
    }

    .departemen {
      font-size: 18px;
      font-weight: bold;
      margin-top: none;
      line-height: 1.4;
    }

    .akta {
      font-size: 10px;
      margin-top: none;
    }

    /* =========================
           JUDUL
        ========================= */
    .judul {
      text-align: center;
      margin-top: 10px;
      margin-bottom: 4px;
      font-size: 18px;
      font-weight: bold;
      color: #076943;
    }

    .subjudul {
      text-align: center;
      margin-bottom: 15px;
      font-size: 11px;
    }

    /* =========================
           TABEL
        ========================= */
    .data {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    .data th {
      background: #076943;
      color: #fff;
      border: 1px solid #055437;
      padding: 8px;
      text-align: center;
      font-size: 10px;
    }

    .data td {
      border: 1px solid #cfd8d3;
      padding: 6px;
      vertical-align: top;
    }

    .data tbody tr:nth-child(even) {
      background: #f1f8f4;
    }

    .center {
      text-align: center;
    }

    /* =========================
           FOOTER
        ========================= */
    .footer-info {
      margin-top: 15px;
      border-top: 1px solid #ccc;
      padding-top: 8px;
      font-size: 10px;
    }

    .footer-info table {
      width: 100%;
      border-collapse: collapse;
    }

    .footer-info td {
      border: none;
      padding: 2px 0;
    }
  </style>
</head>

<body>

  @php
  use Illuminate\Support\Str;
  use Carbon\Carbon;

  $user = auth()->user();

  $downloadedBy = $user->name ?? 'Tidak diketahui';
  $downloadedAt = Carbon::now()->format('d-m-Y H:i:s');

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
  $wilayah = 'Tidak Diketahui';
  }
  @endphp

  {{-- KOP SURAT --}}
  <table class="kop">
    <tr class="kop-box">

      <td class="kop-left">
        <img
          src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('image/logo.png'))) }}"
          width="90">
      </td>

      <td class="kop-right">

        <div class="yayasan">
          YAYASAN PERJUANGAN WAHIDIYAH DAN PONDOK PESANTREN KEDUNGLO
        </div>

        <div class="departemen">
          DEPARTEMEN PEMBINA REMAJA WAHIDIYAH
          <br>
          {{ strtoupper($wilayah) }}
        </div>

        <div class="akta">
          AKTA NOMOR 09 TAHUN 2011 - AHU-9371.AH.01.04 TAHUN 2011
        </div>

      </td>

    </tr>
  </table>

  {{-- JUDUL --}}
  <div class="judul">
    LAPORAN REALISASI PROGRAM KERJA
  </div>

  <div class="subjudul">
    {{ strtoupper($wilayah) }}

    @if ($periode)
    <br>
    Periode : {{ $periode->nama_periode }}
    @endif
  </div>

  {{-- TABEL --}}
  <table class="data">

    <thead>
      <tr>
        <th width="40">No</th>
        <th>Program Kerja</th>
        <th width="70">Waktu</th>
        <th>Target</th>
        <th>Realisasi Kegiatan</th>
        <th>Realisasi Target</th>
        <th width="100">Anggaran Realisasi</th>
        <th width="60">Progress</th>
        <th width="70">Status</th>
      </tr>
    </thead>

    <tbody>

      @forelse($data as $item)
      <tr>

        <td class="center">
          {{ $item->nomor }}
        </td>

        <td>
          {{ $item->uraian_kegiatan }}
        </td>

        <td class="center">
          {{ ucfirst($item->waktu_pelaksanaan) }}
        </td>

        <td>
          {{ $item->target }}
        </td>

        <td>
          {{ $item->realisasi_kegiatan ?: '-' }}
        </td>

        <td>
          {{ $item->realisasi_target ?: '-' }}
        </td>

        <td>
          Rp {{ number_format($item->anggaran_realisasi ?? 0, 0, ',', '.') }}
        </td>

        <td class="center">
          {{ $item->progress }}%
        </td>

        <td class="center">
          {{ strtoupper($item->status_realisasi) }}
        </td>

      </tr>
      @empty

      <tr>
        <td colspan="9" class="center">
          Tidak ada data realisasi program kerja
        </td>
      </tr>

      @endforelse

    </tbody>

  </table>

  {{-- FOOTER --}}
  <div class="footer-info">
    <table>
      <tr>
        <td>
          <strong>Diunduh oleh:</strong>
          {{ $downloadedBy }}
        </td>

        <td style="text-align:right;">
          <strong>Tanggal Download:</strong>
          {{ $downloadedAt }}
        </td>
      </tr>
    </table>
  </div>

</body>

</html>