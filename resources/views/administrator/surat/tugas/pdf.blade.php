<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Surat Tugas - {{ $surat->nomor }}</title>
  <style>
    @page {
      margin-top: 0.5cm;
      margin-bottom: 0.5cm;
      margin-left: 1.5cm;
      margin-right: 1.5cm;
      size: 210mm 330mm;
      /* F4 size */

    }

    body {
      font-size: 12pt;
      font-family: "Times New Roman", Times, serif;
      font-size: 12pt;
      line-height: 1.5;
    }

    .center {
      text-align: center;
    }

    .bold {
      font-weight: bold;
    }
  </style>
</head>

<body>
  <div>
    <div>
      <div>
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/image/kopdprw.png'))) }}"
          width="100%" alt="Example Image">
      </div>
    </div>
    <div class="center bold">S U R A T &nbsp; T U G A S</div>
    <div class="center">Nomor : {{ $surat->nomor }}</div>


    <br>
    <center>
      <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/image/bismillah.png'))) }}"
        alt="Example Image"
        style="display: block; margin: 0 auto; width: 30%;">
    </center>
    <p style="text-align: justify; line-height: 1.2;">
      Dengan taufiq hidayah Alloh SWT, syafaat tarbiyah Rosululloh SAW, barokah nadhroh
      Ghoutsu Hadzaz Zaman, RA., dan do’a restu Hadrotul Mukarrom Kanjeng Romo Kyai
      Abdul Majid Ali Fikri, RA - Pengasuh Perjuangan Wahidiyah dan Pondok Pesantren
      Kedunglo, kami memberikan tugas kepada:
    </p>
    <table style="border-collapse: collapse; width: 100%;">
      <tr>
        <td style="width: 100px; text-align: left; vertical-align: top;">Nama</td>
        <td style="width: 10px; text-align: left; vertical-align: top;">:</td>
        <td style="text-align: left; vertical-align: top;">{{ $surat->nama }}</td>
      </tr>
      <tr>
        <td style="text-align: left; vertical-align: top;">Hari</td>
        <td style="text-align: left; vertical-align: top;">:</td>
        <td style="text-align: left; vertical-align: top;">{{ $surat->hari }}</td>
      </tr>
      <tr>
        <td style="text-align: left; vertical-align: top;">Tanggal</td>
        <td style="text-align: left; vertical-align: top;">:</td>
        <td style="text-align: left; vertical-align: top;">{{ $surat->tanggal_hijriyah }} / {{ $surat->tanggal_masehi }}</td>
      </tr>
      <tr>
        <td style="text-align: left; vertical-align: top;">Pukul</td>
        <td style="text-align: left; vertical-align: top;">:</td>
        <td style="text-align: left; vertical-align: top;">{{ $surat->pukul }}</td>
      </tr>
      <tr>
        <td style="text-align: left; vertical-align: top;">Tempat</td>
        <td style="text-align: left; vertical-align: top;">:</td>
        <td style="text-align: left; vertical-align: top;">{{ $surat->tempat }}</td>
      </tr>
      <tr>
        <td style="text-align: left; vertical-align: top;">Keperluan</td>
        <td style="text-align: left; vertical-align: top;">:</td>
        <td style="text-align: left; vertical-align: top;">{{ $surat->keperluan }}</td>
      </tr>
      <tr>
        <td style="text-align: left; vertical-align: top;">Keperluan</td>
        <td style="text-align: left; vertical-align: top;">:</td>
        <td style="text-align: left; vertical-align: top;">
          <ol style="margin: 0; padding-left: 18px;">
            <li>Dalam melaksanakan tugas supaya senantiasa dijiwai dengan Ajaran Wahidiyah</li>
            <li>Sebelum bertugas melaksanakan Mujahadah Penyongsongan dengan Aurod Mujahadah Peningkatan Fafirru 5.000 x</li>
            <li style="text-align: justify;">Sebelum bertugas supaya sowan memohon Do’a Restu kepangkuan Hadrotul Mukarrom Kanjeng Romo Kyai Abdul Majid Ali Fikri RA secara Batiniyah</li>
            <li>Supaya menyetorkan laporan tugas da’i dan penunaian SP paling lambat 5 hari setelah bertugas</li>
          </ol>
        </td>
    </table>
    <center>
      <p>SELAMAT BERJUANG FAFIRRUU ILALLOH WAROSULIHI SAW</p>
    </center>


    <div style="text-align: right; line-height: 1.5;">
      <table style="border-collapse: collapse; margin-left: auto; text-align: left;">
        <tr>
          <td style="padding-right: 15px; vertical-align: top; ">
            <!-- {{ $surat->kota }}, -->
            Kota Samarinda,
          </td>
          <td style="text-align: left;">
            <span style="text-decoration: underline;">
              {{ $surat->tanggal_surat_hijriyah }}
            </span> <br>
            <span>
              {{ \Carbon\Carbon::parse($surat->tanggal_surat_masehi)->translatedFormat('d F Y') }} M
            </span>


          </td>
        </tr>
      </table>

      <div style="text-align: left; line-height: 1.5; margin-top: 5px; margin-left: 350px;">
        <b style="text-transform: uppercase; display: inline-block; text-align: center;">
          Ketua DPRW,<br>

          <!-- tanda tangan rata tengah -->
          <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/image/ttd.png'))) }}"
            style="display: block; margin: 0 auto;" width="270" alt="TTD"><br>

          {{ $surat->penandatangan }}
        </b>
      </div>


    </div>


    <p style="margin-bottom: 4px;">Tembusan disampaikan kepada Yth.:</p>
    <ol style="margin: 0; padding-left: 20px;  font-size: 12pt; line-height: 1.5;">
      <li>Ketua Perjuangan Wahidiyah Prov. Kalimantan Timur</li>
      <li>Ketua DPPW Prov. Kalimantan Timur</li>
      <li>Ketua DPRW Kota {{$surat->kota }}</li>
      <li>Arsip</li>
    </ol>
  </div>
</body>

</html>