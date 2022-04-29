<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
  
  <title>Laporan Pendapatan</title>

</head>
<body>
  <h3 class="text-center">Laporan Pendapatan</h3>

  <h4 class="text-center">
    Tanggal {{ tgl_ID($awal, false) }}
    s/d
    Tanggal {{ tgl_ID($akhir, false) }}
  </h4>

  <table class="table table-sm table-striped">
    <thead>
      <tr>
        <th width="5%">No</th>
        <th width="25%">Tanggal</th>
        <th>Penjualan</th>
        <th>Pembelian</th>
        <th>Pengeluaran</th>
        <th>Pendapatan</th>
      </tr>
    </thead>

    <tbody>
      @foreach ($data as $row)
          <tr>
            @foreach ($row as $col)
                <td>{{ $col }}</td>
            @endforeach
          </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>