<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Laporan Expedisi Surat Masuk</title>
  <style>
    body {
      font-family: DejaVu Sans, sans-serif;
      font-size: 12px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th,
    td {
      border: 1px solid #000;
      padding: 6px;
      text-align: left;
      font-size: 11px;
    }

    th {
      background-color: #f2f2f2;
    }

    h2 {
      text-align: center;
    }
  </style>
</head>

<body>
  <h2>Laporan Expedisi Surat Masuk</h2>

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Tanggal Terima</th>
        <th>Nomor Surat</th>
        <th>Asal Surat</th>
        <th>Perihal</th>
        <th>Keterangan</th>
      </tr>
    </thead>
    <tbody>
      @foreach($suratMasuk as $i => $surat)
      <tr>
        <td>{{ $i+1 }}</td>
        <td>{{ \Carbon\Carbon::parse($surat->tanggal_terima)->format('d-m-Y') }}</td>
        <td>{{ $surat->nomor_surat }}</td>
        <td>{{ $surat->asal_surat }}</td>
        <td>{{ $surat->perihal }}</td>
        <td>{{ $surat->keterangan }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</body>

</html>