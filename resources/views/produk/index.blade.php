@extends('template.master')

@section('title')
Produk
@endsection

@section('breadcumb')
@parent
<li class="breadcrumb-item active">Produk</li>
@endsection

@section('content')

<!-- Main row -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
              <div class="btn-group">
                <button onclick="addForm('{{route('produk.store')}}')" class="btn btn-success btn-xs btn-flat">
                  <i class="fa fa-plus-circle"> Tambah</i>
                </button>

                <button onclick="deleteSelected('{{route ('produk.delete_selected')}}')" class="btn btn-danger btn-xs btn-flat">
                  <i class="fa fa-trash"> Hapus</i>
                </button>

                <button onclick="cetakBarcode('{{route ('produk.cetak_barcode')}}')" class="btn btn-info btn-xs btn-flat">
                  <i class="fa fa-barcode"> Cetak Barcode</i>
                </button>
              </div>
                
            </div>

            <div class="box-body table-responsive p-3">
              <form action="" method="post" class="form-produk">
                @csrf
                <table class="table table-striped table-bordered" style="width: 100%;">
                  <thead>
                    <th>
                      <input type="checkbox" name="select_all" id="select_all">
                    </th>
                    <th width="5%">No</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Merk</th>
                    <th>Harga Beli</th>
                    <th>harga Jual</th>
                    <th>Diskon</th>
                    <th>Stock</th>
                    <th width="8%"><i class="fa fa-cog"></i></th>
                  </thead>
                </table>
              </form>
            </div>
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>

@include('produk.form')
@endsection

@push('script')
    <script>

      let table;
      
      $( function() {
        table = $('.table').DataTable({
          proccesing: true,
          autowidth: false,
          ajax: {
            url: '{{route('produk.data')}}'
          }, 
          columns: [
            {data: 'select_all'},
            {data: 'DT_RowIndex', searchable: false, sortbale: false},
            {data: 'kode_produk'},
            {data: 'nama_produk'},
            {data: 'kategori'},
            {data: 'merk'},
            {data: 'harga_beli'},
            {data: 'harga_jual'},
            {data: 'diskon'},
            {data: 'stok'},
            {data: 'aksi', searchable: false, sortable: false}
          ]
        });

        
        $('#modal-form').validator().on('submit', function(e){
          if(! e.preventDefault()){
            $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
              .done((response) => {
                $('#modal-form').modal('hide');
                table.ajax.reload();
              })
              .fail((errors) => {
                alert('Tidak dapat menyimpan Data! ');
                return;
              });
            }
          });

        $('[name=select_all]').on('click', function(){
          $(':checkbox').prop('checked', this.checked);
        });
        
      });
      

      function addForm(url){
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Produk');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama_produk]').focus();
      }

      function editForm(url){
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Produk');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=nama_produk]').focus();

        $.get(url)
          .done((response) => {
            $('#modal-form [name=nama_produk]').val(response.nama_produk);
            $('#modal-form [name=kode_produk]').val(response.kode_produk);
            $('#modal-form [name=id_kategori]').val(response.id_kategori);
            $('#modal-form [name=merk]').val(response.merk);
            $('#modal-form [name=harga_beli]').val(response.harga_beli);
            $('#modal-form [name=harga_jual]').val(response.harga_jual);
            $('#modal-form [name=diskon]').val(response.diskon);
            $('#modal-form [name=stok]').val(response.stok);
          })
          .fail((errors) => {
            alert('Tidak dapat menampilkan Data!');
            return;
          })
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

    function deleteSelected(url){
      if($('input:checked').length > 1) {
        if(confirm('Yakin ingin menghapus data yang terpilih?')){
          $.post(url, $('.form-produk').serialize())
            .done((response) => {
              table.ajax.reload();
            })
            .fail((errors) => {
              alert('Silahkan pilih data yang akan di hapus!');
              return;
            });
          }
        }else{
          alert('Silahkan pilih data yang akan di hapus');
          return;
        }
      }

      function cetakBarcode(url){
        if($('input:checked').length < 1) {
          alert('Silahkan pilih data yang akan dicetak');
          return;
        }else if($('input:checked').length < 3){
          alert('Silahkan pilih minimal 3 data untuk di cetak');
          return;
        }else{
          $('.form-produk').attr('action', url).attr('target', '_blank').submit();
        }
      }
        
    </script>
@endpush
