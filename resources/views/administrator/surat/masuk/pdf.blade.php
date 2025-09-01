<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Laporan Expedisi Surat Masuk</title>
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
      margin-top: 2px;
      margin-left: 2px;
      margin-right: 2px;
    }

    table {
      width: 100%;
      border-collapse: collapse;

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
  <div>
    <div>
      <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/image/kopdprw.png'))) }}"
        width="100%" alt="Example Image">
    </div>
  </div>
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