@extends('template.master')

@section('title')
Daftar User
@endsection

@section('breadcumb')
@parent
<li class="breadcrumb-item active">User</li>
@endsection

@section('content')

<!-- Main row -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
              <div class="btn-group">
                <button onclick="addForm('{{route('user.store')}}')" class="btn btn-success btn-xs btn-flat">
                  <i class="fa fa-plus-circle"> Tambah</i>
                </button>

              </div>
                
            </div>

            <div class="box-body table-responsive p-3">
              <table class="table table-striped table-bordered" style="width: 100%;">
                <thead>
                  <th width="5%">No</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th width="15%"><i class="fa fa-cog"></i></th>
                </thead>
              </table>
            </div>
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>

@include('user.form')
@endsection

@push('script')
    <script>

      let table;
      
      $( function() {
        table = $('.table').DataTable({
          proccesing: true,
          autowidth: false,
          ajax: {
            url: '{{route('user.data')}}'
          }, 
          columns: [
            {data: 'DT_RowIndex', searchable: false, sortbale: false},
            {data: 'name'},
            {data: 'email'},
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
        $('#modal-form .modal-title').text('Tambah User');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=name]').focus();

        $('#password', '#password_confirmation').attr('required', true);
      }

      function editForm(url){
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit User');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=name]').focus();
        $('#password', '#password_confirmation').attr('required', false);

        $.get(url)
          .done((response) => {
            $('#modal-form [name=name]').val(response.name);
            $('#modal-form [name=email]').val(response.email);
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
