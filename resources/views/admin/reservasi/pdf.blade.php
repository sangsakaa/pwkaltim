<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Laporan Reservasi</title>
  <style>
    body {
      font-family: DejaVu Sans, sans-serif;
      font-size: 10px;
    }

    h2 {
      text-align: center;
      margin-bottom: 5px;
    }

    p {
      text-align: center;
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th,
    td {
      border: 1px solid #555;
      padding: 6px;
      text-align: left;
    }

    th {
      background-color: #e5e7eb;
    }
  </style>
</head>

<body>
  <h2>LAPORAN DATA RESERVASI</h2>
  <p>Dicetak: {{ now()->format('d-m-Y H:i') }}</p>

  <table>
    <thead>
      <tr>
        <th>No.</th>
        <th>Nama</th>
        <th>Email</th>
        <th>No. HP</th>
        <th>Status</th>
        <th>Tanggal Reservasi</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($reservations as $reservation)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $reservation->nama ?? $reservation->name ?? '-' }}</td>
        <td>{{ $reservation->email ?? '-' }}</td>
        <td>{{ $reservation->no_hp ?? $reservation->phone ?? '-' }}</td>
        <td>{{ $reservation->status ?? '-' }}</td>
        <td>
          {{ $reservation->created_at
                            ? $reservation->created_at->format('d-m-Y H:i')
                            : '-' }}
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="6">Belum ada data reservasi.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</body>

</html>