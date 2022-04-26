@extends('template.master')

@section('title')
Daftar Penjualan
@endsection

@section('breadcumb')
@parent
<li class="breadcrumb-item active">Daftar Penjualan</li>
@endsection

@section('content')

<!-- Main row -->
<div class="row">
    <div class="col-md-12">
        <div class="card">

            <div class="box-body table-responsive p-3">
              <table class="table table-penjualan table-striped table-bordered" style="width: 100%;">
                <thead>
                  <th width="5%">No</th>
                  <th>Tanggal</th>
                  <th>Kode Member</th>
                  <th>Total Item</th>
                  <th>Total Harga</th>
                  <th>Diskon</th>
                  <th>Total Bayar</th>
                  <th>Diterima</th>
                  <th>Kasir</th>
                  <th width="10%"><i class="fa fa-cog"></i></th>
                </thead>
              </table>
            </div>
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>

@include('penjualan.detail')
@endsection

@push('script')
    <script>

      let table, table1;
      
      $( function() {
        table = $('.table-penjualan').DataTable({
          proccesing: true,
          autowidth: false,
          ajax: {
            url: '{{route('penjualan.data')}}'
          }, 
          columns: [
            {data: 'DT_RowIndex', searchable: false, sortbale: false},
            {data: 'tanggal'},
            {data: 'kode_member'},
            {data: 'total_item'},
            {data: 'total_harga'},
            {data: 'diskon'},
            {data: 'bayar'},
            {data: 'diterima'},
            {data: 'kasir'},
            {data: 'aksi', searchable: false, sortable: false}
          ]
        });

        table1 = $('.table-detail').DataTable({
          proccesing: true,
          columns: [
            {data: 'DT_RowIndex', searchable: false, sortbale: false},
            {data: 'kode_produk'},
            {data: 'nama_produk'},
            {data: 'harga_jual'},
            {data: 'jumlah'},
            {data: 'subtotal'},
          ]
        });
      });
    
      function showDetail(url){
        $('#modal-detail').modal('show');
        table1.ajax.url(url);
        table1.ajax.reload();
      }

      function deleteData(url){
        if(confirm('Yakin ingin manghapus data terpilih?')){
          $.post(url, {
              '_token': $('[name=csrf-token]').attr('content'),
              '_method': 'delete'
            })
            .done((response) =>{
              table.ajax.reload();
            })
            .fail((errors) => {
              alert('Anda yakin menhapus data ini?');
              return;
            })
          }
        }
        
    </script>
@endpush
