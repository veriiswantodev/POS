@extends('template.master')

@section('title')
Daftar Pengeluaran
@endsection

@section('breadcumb')
@parent
<li class="breadcrumb-item active">Pengeluaran</li>
@endsection

@section('content')

<!-- Main row -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
              <div class="btn-group">
                <button onclick="addForm('{{route('pengeluaran.store')}}')" class="btn btn-success btn-xs btn-flat">
                  <i class="fa fa-plus-circle"> Tambah</i>
                </button>

              </div>
                
            </div>

            <div class="box-body table-responsive p-3">
              <table class="table table-striped table-bordered" style="width: 100%;">
                <thead>
                  <th width="5%">No</th>
                  <th>Tanggal</th>
                  <th>Jenis Pengeluaran</th>
                  <th>Niminal</th>
                  <th width="15%"><i class="fa fa-cog"></i></th>
                </thead>
              </table>
            </div>
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>

@include('pengeluaran.form')
@endsection

@push('script')
    <script>

      let table;
      
      $( function() {
        table = $('.table').DataTable({
          proccesing: true,
          autowidth: false,
          ajax: {
            url: '{{route('pengeluaran.data')}}'
          }, 
          columns: [
            {data: 'DT_RowIndex', searchable: false, sortbale: false},
            {data: 'created_at'},
            {data: 'deskripsi'},
            {data: 'nominal'},
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
          })
      });
      

      function addForm(url){
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Pengeluaran');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama]').focus();
      }

      function editForm(url){
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Pengeluaran');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=deskripsi]').focus();

        $.get(url)
          .done((response) => {
            $('#modal-form [name=deskripsi]').val(response.deskripsi);
            $('#modal-form [name=nominal]').val(response.nominal);
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
        
    </script>
@endpush
