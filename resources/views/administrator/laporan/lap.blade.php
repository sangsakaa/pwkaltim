<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Data Pengamal</title>

  <style>
    @page {
      margin: 5mm 5mm 5mm 5mm;
      /* top, right, bottom, left */
    }

    body {
      margin: 0;
      padding: 0;
    }

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
      border: none;
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

  <style>
    .kop-surat {

      /* hijau khas Wahidiyah */
      color: white;
      padding: 20px;
      display: flex;
      align-items: center;
      font-family: 'Arial', sans-serif;

    }

    .kop-surat img {
      width: 120px;
      height: 120px;
      margin-right: 20px;
    }

    .kop-surat .teks {
      flex: 1;
      text-align: center;
    }

    .kop-surat .yayasan {
      font-size: 14px;
      font-weight: bold;
      margin-bottom: 4px;
    }

    .kop-surat .departemen {
      font-size: 22px;
      font-weight: bold;
      line-height: 1.3;
    }

    .kop-surat .akta {
      font-size: 12px;
      margin-top: 5px;
    }

    .alamat {
      font-size: 12px;
      font-family: 'Arial', sans-serif;
      color: white;
      text-align: center;
      margin-top: 4px;
      border-top: 1px solid #007f3d;
      padding-top: 4px;
    }

    #container {
      display: flex;
      align-items: center;
    }

    #logo {
      margin-right: 20px;
      text-align: center;
      /* Adjust this value to control the space between logo and title */
    }

    #tittle {
      display: flex;
      flex-direction: column;
    }

    #tittle span {
      text-align: left;
    }

    .h1 {
      background-color: rgba(7, 75, 36, 255);
      color: rgba(7, 75, 36, 255);
    }

    .kop {
      width: 100%;
      margin-top: 10px;
    }

    td {
      border: 1px solid #ddd;
      text-align: left;
      /* Center text in table cell */
      vertical-align: middle;
      /* Center vertically */
    }

    .center-img {
      display: block;
      margin-left: auto;
      margin-right: auto;
    }

    .nama_cap {
      font-size: 20px;
      font-weight: bold;
      text-transform: capitalize;
    }

    table {
      width: 100%;
      border: solid 1px;
    }

    td {
      border: solid 1px;
    }

    h1 {
      text-transform: capitalize;
      text-align: center;
    }

    th {
      background-color: #f2f2f2;
      font-weight: bold;
      border: solid 1px;
    }
  </style>

  <table class=" kop">
    <tr class="h1 ">
      <td class="logo">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/image/logo.png'))) }}" height="140px" width="145px" alt="Example Image">
      </td>
      <td>
        <div class="kop-surat">
          <div class="teks">
            <div class="yayasan">YAYASAN PERJUANGAN WAHIDIYAH DAN PONDOK PESANTREN KEDUNGLO</div>
            <div class="departemen">DEPARTEMEN PEMBINA WAHIDIYAH<br>PROVINSI KALIMANTAN TIMUR</div>
            <div class="akta">AKTA NOMOR 09 TAHUN 2011 KEMENKUMHAM RI NOMOR : AHU-9371.AH.01.04 TAHUN 2011</div>
          </div>
          <div class="alamat">
            Alamat Sekretariat : Jalan Talang Sari RT. 01 Kelurahan Tanah Merah Kecamatan Samarinda Utara Kota Samarinda Kalimantan Timur
          </div>
        </div>
      </td>
    </tr>
  </table>
  <h2>DATA PENGAMAL KALIMANTAN TIMUR</h2>
  <table>
    <thead>
      <tr>
        <th>No</th>
        <!-- <th>NIK</th> -->
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
        <!-- <td>{{ $d->nik }}</td> -->
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