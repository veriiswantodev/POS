@extends('template.master')

@section('title')
Daftar Pembelian
@endsection

@section('breadcumb')
@parent
<li class="breadcrumb-item active">DaftarPembelian</li>
@endsection

@section('content')

<!-- Main row -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
              <div class="btn-group">
                <button onclick="addForm()" class="btn btn-success btn-xs btn-flat">
                  <i class="fa fa-plus-circle"> Transaksi Baru</i>
                </button>

                @empty(! session('id_pembelian'))
                  <a href="{{route('pembelian_detail.index')}}" class="btn btn-primary btn-xs btn-flat">
                    <i class="fa fa-edit"> Transaksi Aktif</i>
                  </a>              
                @endempty

              </div>
                
            </div>

            <div class="box-body table-responsive p-3">
              <table class="table table-pembelian table-striped table-bordered" style="width: 100%;">
                <thead>
                  <th width="5%">No</th>
                  <th>Tanggal</th>
                  <th>Supplier</th>
                  <th>Total Item</th>
                  <th>Total Harga</th>
                  <th>Diskon</th>
                  <th>Total Bayar</th>
                  <th width="15%"><i class="fa fa-cog"></i></th>
                </thead>
              </table>
            </div>
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>

@include('pembelian.supplier')
@include('pembelian.detail')
@endsection

@push('script')
    <script>

      let table, table1;
      
      $( function() {
        table = $('.table-pembelian').DataTable({
          proccesing: true,
          autowidth: false,
          ajax: {
            url: '{{route('pembelian.data')}}'
          }, 
          columns: [
            {data: 'DT_RowIndex', searchable: false, sortbale: false},
            {data: 'tanggal'},
            {data: 'suplier'},
            {data: 'total_item'},
            {data: 'total_harga'},
            {data: 'diskon'},
            {data: 'bayar'},
            {data: 'aksi', searchable: false, sortable: false}
          ]
        });

        $('.table-supplier').DataTable();

        table1 = $('.table-detail').DataTable({
          proccesing: true, 
          columns: [
            {data: 'DT_RowIndex', searchable: false, sortbale: false},
            {data: 'kode_produk'},
            {data: 'nama_produk'},
            {data: 'harga_beli'},
            {data: 'jumlah'},
            {data: 'subtotal'},
          ]
        });
      });
      

      function addForm(){
        $('#modal-supplier').modal('show');

      }

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
