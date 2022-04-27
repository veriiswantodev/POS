@extends('template.master')

@section('title')
Transaksi Penjualan
@endsection

@section('breadcumb')
@parent
<li class="breadcrumb-item active">Transaksi Penjualan</li>
@endsection

@section('content')

<!-- Main row -->
<div class="row">
    <div class="col-md-12">
        <div class="card">

            <div class="card-body">
              <div class="alert alert-success alert-dismissible">
                <i class="fa fa-check icon">
                </i>

                Data Transaksi telah selesai
              </div>

            </div>
            <div class="card-footer">
              @if ($setting->tipe_nota == 1)
              <button class="btn btn-warning btn-flat" onclick="notaKecil('{{ route('transaksi.nota_kecil') }}', 'Nota Kecil')">Cetak Ulang Nota</button>
              @else
                <button class="btn btn-warning btn-flat"><i class="fa fa-print" onclick="notaBesar({{route('transaksi.nota_besar')}}, 'Nota Besar')"></i> Cetak Ulang Nota</button>
              @endif
              <a href="{{route('transaksi.baru')}}" class="btn btn-primary btn-flat"><i class="fa fa-plus"></i> Transaksi Baru</a>
            </div>
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>

@endsection

@push('script')
    <script>
      document.cookie = "innerHeight=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";

      function notaKecil(url, title){
        popupCenter(url, title, 720, 675);
      }

      function notaBesar(url, title){
        popupCenter(url, title, 720, 675);
      } 

      function popupCenter(url, title, w, h) {
        const dualScreenLeft = window.screenLeft !==  undefined ? window.screenLeft : window.screenX;
        const dualScreenTop  = window.screenTop  !==  undefined ? window.screenTop  : window.screenY;
        const width  = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;
        const systemZoom = width / window.screen.availWidth;
        const left       = (width - w) / 2 / systemZoom + dualScreenLeft
        const top        = (height - h) / 2 / systemZoom + dualScreenTop
        const newWindow  = window.open(url, title, 
        `
            scrollbars=yes,
            width  = ${w / systemZoom}, 
            height = ${h / systemZoom}, 
            top    = ${top}, 
            left   = ${left}
        `
        );
        if (window.focus) newWindow.focus();
    }
    </script>
@endpush
