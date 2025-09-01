<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Program Kerja - {{ $waktu }}</title>
  <style>
    @page {
      margin-top: 0.5cm;
      margin-bottom: 0.5cm;
      margin-left: 0.5cm;
      margin-right: 0.5cm;
    }

    body {
      font-family: DejaVu Sans, sans-serif;
      font-size: 12px;
      margin: 0;
      /* biar tidak dobel dengan @page */
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
      margin: 15px 0;
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
  <div>
    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/image/kopdprw.png'))) }}"
      width="100%" alt="Example Image">
  </div>

  <h2>Program Kerja - {{ ucfirst($waktu) }}</h2>

  <table>
    <thead>
      <tr>
        <th>Nomor</th>
        <th>Uraian Kegiatan</th>
        <th>Waktu</th>
        <th>Tujuan</th>
        <th>Sasaran</th>
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
        <td>{{ $row->target }}</td>
        <td>{{ $row->sasaran }}</td>
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