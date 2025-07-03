<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Data Pengamal</title>
  <style>
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
      border: 1px solid #000;
      padding: 6px;
      text-align: left;
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

  <h2>DATA PENGAMAL KALIMANTAN TIMUR</h2>

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>NIK</th>
        <th>Nama Lengkap</th>
        <th>Tempat, Tanggal Lahir</th>
        <th>Jenis Kelamin</th>
        <th>Agama</th>
        <th>Alamat Lengkap</th>
        <th>No HP</th>
        <th>Status Perkawinan</th>
        <th>Pekerjaan</th>

      </tr>
    </thead>
    <tbody>
      @foreach ($pengamal as $i => $d)
      <tr>
        <td>{{ $i + 1 }}</td>
        <td>{{ $d->nik }}</td>
        <td>{{ $d->nama_lengkap }}</td>
        <td>{{ $d->tempat_lahir }}, {{ \Carbon\Carbon::parse($d->tanggal_lahir)->format('d-m-Y') }}</td>
        <td>{{ $d->jenis_kelamin }}</td>
        <td>{{ $d->agama }}</td>

        <td>
          RT {{ $d->rt }}/RW {{ $d->rw }},
          Desa {{ $d->village->name ??'-' }},
          Kec. {{ $d->district->name }},
          Kab. {{ $d->regency->name }},
          Prov. {{ $d->province->name }}
        </td>
        <td>{{ $d->no_hp }}</td>
        <td>{{ $d->status_perkawinan }}</td>
        <td>{{ $d->pekerjaan }}</td>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

</body>

</html>