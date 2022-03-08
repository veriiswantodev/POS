@extends('template.master')

@section('title')
Daftar Member
@endsection

@section('breadcumb')
@parent
<li class="breadcrumb-item active">Member</li>
@endsection

@section('content')

<!-- Main row -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
              <div class="btn-group">
                <button onclick="addForm('{{route('member.store')}}')" class="btn btn-success btn-xs btn-flat">
                  <i class="fa fa-plus-circle"> Tambah</i>
                </button>

                <button onclick="cetakMember('{{route('member.cetak_member')}}')" class="btn btn-info btn-xs btn-flat">
                  <i class="fa fa-id-card"> Cetak Member</i>
                </button>
              </div>
                
            </div>

            <div class="box-body table-responsive p-3">
              <form action="" method="post" class="form-member">
                @csrf
                <table class="table table-striped table-bordered" style="width: 100%;">
                  <thead>
                    <th width="5%">
                      <input type="checkbox" name="select_all" id="select_all">
                    </th>
                    <th width="5%">No</th>
                    <th>Kode Member</th>
                    <th>Nama Member</th>
                    <th>Telepon</th>
                    <th>Alamat</th>
                    <th width="15%"><i class="fa fa-cog"></i></th>
                  </thead>
                </table>
              </form>
              
            </div>
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>

@include('member.form')
@endsection

@push('script')
    <script>

      let table;
      
      $( function() {
        table = $('.table').DataTable({
          proccesing: true,
          autowidth: false,
          ajax: {
            url: '{{route('member.data')}}'
          }, 
          columns: [
            {data: 'select_all', searchable: false, sortbale: false},
            {data: 'DT_RowIndex', searchable: false, sortbale: false},
            {data: 'kode_member'},
            {data: 'nama'},
            {data: 'telepon'},
            {data: 'alamat'},
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

          $('[name=select_all]').on('click', function(){
            $(':checkbox').prop('checked', this.checked);
          });
      });
      

      function addForm(url){
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Member');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama]').focus();
      }

      function editForm(url){
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Member');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=nama]').focus();

        $.get(url)
          .done((response) => {
            $('#modal-form [name=nama]').val(response.nama);
            $('#modal-form [name=telepon]').val(response.telepon);
            $('#modal-form [name=alamat]').val(response.alamat);
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

        function cetakMember(url){
        if($('input:checked').length < 1) {
          alert('Silahkan pilih data yang akan dicetak');
          return;
        }else{
          $('.form-member').attr('action', url).attr('target', '_blank').submit();
        }
      }
        
    </script>
@endpush
