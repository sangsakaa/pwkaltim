<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Laporan Reservasi</title>

  <style>
    @page {
      margin: 20px;
    }

    body {
      font-family: sans-serif;
      font-size: 10px;
      color: #222;
    }

    h1 {
      text-align: center;
      font-size: 18px;
      margin-bottom: 5px;
    }

    .subtitle {
      text-align: center;
      margin-bottom: 20px;
      color: #555;
    }

    h2 {
      font-size: 14px;
      background: #e5e7eb;
      padding: 8px;
      margin-top: 20px;
      margin-bottom: 8px;
    }

    h3 {
      font-size: 12px;
      margin-top: 12px;
      margin-bottom: 5px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 12px;
    }

    th,
    td {
      border: 1px solid #999;
      padding: 5px;
    }

    th {
      background: #f3f4f6;
      text-align: center;
    }

    .number {
      text-align: center;
    }

    .subtotal {
      font-weight: bold;
      background: #f3f4f6;
    }

    .grand-total {
      font-weight: bold;
      background: #dbeafe;
    }

    .page-break {
      page-break-after: always;
    }
  </style>
</head>

<body>

  <h1>LAPORAN PENDAFTARAN ROMBONGAN</h1>
  <div class="subtitle">
    Rekapitulasi peserta berdasarkan provinsi dan kabupaten/kota
  </div>

  @foreach ($grouped as $namaProvinsi => $kabupatenGroups)
  <h2>PROVINSI: {{ strtoupper($namaProvinsi) }}</h2>

  @php
  $provBapak = 0;
  $provIbu = 0;
  $provRemaja = 0;
  $provAnak = 0;
  $provPeserta = 0;
  @endphp

  @foreach ($kabupatenGroups as $namaKabupaten => $items)
  <h3>Kabupaten/Kota: {{ $namaKabupaten }}</h3>

  <table>
    <thead>
      <tr>
        <th>No.</th>
        <th>Ketua Rombongan</th>
        <!-- <th>No. Reservasi</th> -->
        <th>Bapak</th>
        <th>Ibu</th>
        <th>Remaja</th>
        <th>Anak</th>
        <th>Total Peserta</th>
      </tr>
    </thead>

    <tbody>
      @foreach ($items as $index => $reservation)
      <tr>
        <td class="number">{{ $loop->iteration }}</td>
        <td>{{ $reservation->ketua_rombongan }}</td>
        <!-- <td>{{ $reservation->reservation_number }}</td> -->
        <td class="number">{{ $reservation->total_father }}</td>
        <td class="number">{{ $reservation->total_mother }}</td>
        <td class="number">{{ $reservation->total_teenager }}</td>
        <td class="number">{{ $reservation->total_child }}</td>
        <td class="number">{{ $reservation->total_participant }}</td>
      </tr>
      @endforeach

      <tr class="subtotal">
        <td colspan="2">Subtotal {{ $namaKabupaten }}</td>
        <td class="number">{{ $items->sum('total_father') }}</td>
        <td class="number">{{ $items->sum('total_mother') }}</td>
        <td class="number">{{ $items->sum('total_teenager') }}</td>
        <td class="number">{{ $items->sum('total_child') }}</td>
        <td class="number">{{ $items->sum('total_participant') }}</td>
      </tr>
    </tbody>
  </table>

  @php
  $provBapak += $items->sum('total_father');
  $provIbu += $items->sum('total_mother');
  $provRemaja += $items->sum('total_teenager');
  $provAnak += $items->sum('total_child');
  $provPeserta += $items->sum('total_participant');
  @endphp
  @endforeach

  <table>
    <tr class="subtotal">
      <td>Total Provinsi {{ $namaProvinsi }}</td>
      <td>Bapak: {{ $provBapak }}</td>
      <td>Ibu: {{ $provIbu }}</td>
      <td>Remaja: {{ $provRemaja }}</td>
      <td>Anak: {{ $provAnak }}</td>
      <td>Total Peserta: {{ $provPeserta }}</td>
    </tr>
  </table>
  @endforeach

  <h2>REKAPITULASI SELURUH PROVINSI</h2>

  <table>
    <thead>
      <tr>
        <th>Total Bapak</th>
        <th>Total Ibu</th>
        <th>Total Remaja</th>
        <th>Total Anak</th>
        <th>Total Peserta</th>
      </tr>
    </thead>
    <tbody>
      <tr class="grand-total">
        <td class="number">{{ $totalBapak }}</td>
        <td class="number">{{ $totalIbu }}</td>
        <td class="number">{{ $totalRemaja }}</td>
        <td class="number">{{ $totalAnak }}</td>
        <td class="number">{{ $totalPeserta }}</td>
      </tr>
    </tbody>
  </table>

</body>

</html>