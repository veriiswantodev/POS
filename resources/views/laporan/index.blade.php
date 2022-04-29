@extends('template.master')

@section('title')
Laporan Pendapatan {{ tgl_ID($tgl_awal, false) }} s/d {{ tgl_ID($tgl_akhir, false) }}
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('/datepicker/bootstrap-datepicker.min.css') }}">
@endpush

@section('breadcumb')
@parent
<li class="breadcrumb-item active">Laporan</li>
@endsection

@section('content')

<!-- Main row -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
              <div class="btn-group">
                <button onclick="updatePeriode()" class="btn btn-warning btn-xs btn-flat">
                  <i class="fa fa-edit"> Ubah Periode</i>
                </button>
                <a href="{{ route('laporan.export_pdf', [$tgl_awal, $tgl_akhir]) }}" target="_blank" class="btn btn-success btn-xs btn-flat">
                  <i class="fa fa-file-pdf"> Print PDF</i>
                </a>

              </div>
                
            </div>

            <div class="box-body table-responsive p-3">
              <table class="table table-striped table-bordered" style="width: 100%;">
                <thead>
                  <th width="5%">No</th>
                  <th>Tanggal</th>
                  <th>Penjualan</th>
                  <th>Pembelian</th>
                  <th>Pengeluran</th>
                  <th>Pendapatan</th>
                </thead>
              </table>
            </div>
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>

@include('laporan.form')
@endsection

@push('script')
  <script src="{{ asset('/datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script>

      let table;
      
      $( function() {
        table = $('.table').DataTable({
          proccesing: true,
          autowidth: false,
          ajax: {
            url: '{{route('laporan.data', [$tgl_awal, $tgl_akhir]) }}'
          }, 
          columns: [
            {data: 'DT_RowIndex', searchable: false, sortbale: false},
            {data: 'tanggal'},
            {data: 'penjualan'},
            {data: 'pembelian'},
            {data: 'pengeluaran'},
            {data: 'pendapatan'},
          ],
          dom: 't',
          paging: false,
          sorting: false
        });

        //Date picker
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
      });
      

      function updatePeriode(url){
        $('#modal-form').modal('show');
      }   
        
    </script>
@endpush
