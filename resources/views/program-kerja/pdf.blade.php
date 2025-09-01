<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Program Kerja - {{ ucfirst($waktu) }}</title>
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

    h4 {
      text-align: center;
      margin: 15px 0;
    }

    h3 {
      margin-top: 20px;
      margin-bottom: 5px;
    }

    tfoot td {
      font-weight: bold;
      background: #f9f9f9;
    }
  </style>
</head>

<body>
  <div>
    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/image/kopdprw.png'))) }}"
      width="100%" alt="Example Image">
  </div>

  <h4>PROGRAM KERJA <br> DEPATEMEN PEMBINA REMAJA WAHIDIYAH <br>TAHUN {{ date('Y') }}</h4>


  @php $totalBiayaSemua = 0; @endphp

  @if ($waktu == 'semua')
  {{-- Loop berdasarkan kelompok waktu --}}
  @foreach ($data->groupBy('waktu_pelaksanaan') as $kelompokWaktu => $items)
  <h3>Waktu Pelaksanaan: {{ ucfirst($kelompokWaktu) }}</h3>

  <table>
    <thead>
      <tr>
        <th>Nomor</th>
        <th>Uraian Kegiatan</th>
        <th>Tujuan</th>
        <th>Sasaran</th>
        <th>Biaya</th>
        <th>Penanggung Jawab</th>
      </tr>
    </thead>
    <tbody>
      @php $totalBiaya = 0; @endphp
      @foreach ($items as $row)
      @php $totalBiaya += $row->biaya; $totalBiayaSemua += $row->biaya; @endphp
      <tr>
        <td>{{ $row->nomor }}</td>
        <td>{{ $row->uraian_kegiatan }}</td>
        <td>{{ $row->target }}</td>
        <td>{{ $row->sasaran }}</td>
        <td>Rp {{ number_format($row->biaya, 0, ',', '.') }}</td>
        <td>{{ $row->penanggung_jawab }}</td>
      </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <td colspan="4" style="text-align:right">Total Biaya {{ ucfirst($kelompokWaktu) }}</td>
        <td colspan="2">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</td>
      </tr>
    </tfoot>
  </table>
  @endforeach

  <h3 style="margin-top:20px;">Total Biaya Semua Waktu: Rp {{ number_format($totalBiayaSemua, 0, ',', '.') }}</h3>

  @else
  {{-- Jika hanya 1 waktu --}}
  <p><strong>Waktu Pelaksanaan:</strong> {{ ucfirst($waktu) }}</p>

  <table border="1" cellspacing="0" cellpadding="6" style="width:100%">
    <thead>
      <tr>
        <th>Nomor</th>
        <th>Uraian Kegiatan</th>
        <th>Tujuan</th>
        <th>Sasaran</th>
        <th>Biaya</th>
        <th>Penanggung Jawab</th>
      </tr>
    </thead>
    <tbody>
      @php
      $grandTotal = 0;
      @endphp

      @forelse ($data->groupBy('waktu_pelaksanaan') as $waktu => $group)
      {{-- Judul per Waktu --}}
      <tr style="background:#f0f0f0; font-weight:bold;">
        <td colspan="6">{{ ucfirst($waktu) }}</td>
      </tr>

      @php $subtotal = 0; @endphp
      @foreach ($group as $row)
      @php $subtotal += $row->biaya; $grandTotal += $row->biaya; @endphp
      <tr>
        <td>{{ $row->nomor }}</td>
        <td>{{ $row->uraian_kegiatan }}</td>
        <td>{{ $row->target }}</td>
        <td>{{ $row->sasaran }}</td>
        <td>Rp {{ number_format($row->biaya, 0, ',', '.') }}</td>
        <td>{{ $row->penanggung_jawab }}</td>
      </tr>
      @endforeach

      {{-- Subtotal per Waktu --}}
      <tr style="font-weight:bold; background:#e8f5e9;">
        <td colspan="4" style="text-align:right">Subtotal {{ ucfirst($waktu) }}</td>
        <td colspan="2">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
      </tr>
      @empty
      <tr>
        <td colspan="6" style="text-align:center">Tidak ada data</td>
      </tr>
      @endforelse
    </tbody>

    {{-- Total Keseluruhan --}}
    @if(count($data) > 0)
    <tfoot>
      <tr style="background:#c8e6c9; font-weight:bold;">
        <td colspan="4" style="text-align:right">Total Biaya Keseluruhan</td>
        <td colspan="2">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
      </tr>
    </tfoot>
    @endif
  </table>

  @endif
</body>

</html>