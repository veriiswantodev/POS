@extends('template.master')

@section('title')
Edit Profil
@endsection

@section('breadcumb')
@parent
<li class="breadcrumb-item active">Edit Profil</li>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <form action="{{ route('user.update_profil') }}" class="form-profil" method="POST" data-toggle="validator" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
          <div class="alert alert-info alert-dismissible" style="display: none;">
            <button type="button" class="close" aria-hidden="true" data-dismiss="alert">&times;</button>
            <i class="icon fa fa-check"> </i> Perubahan Bersahil disimpan
          </div>

          <div class="form-group row">
            <label for="name" class="col-lg-2 col-lg-offset-1 control-label">Nama</label>
            <div class="col-lg-6">
              <input type="text" name="name" id="name" class="form-control" required autofocus value="{{ $profil->name }}">
              <span class="help-block with-errors text-danger"></span>
            </div>
          </div>

          <div class="form-group row">
            <label for="foto" class="col-lg-2 col-lg-offset-1 control-label">Profil</label>
            <div class="col-lg-6 ml-2">
              <input type="file" name="foto" id="foto" class="custom-file-input" onchange="preview('.tampil-foto', this.files[0], 200)">
              <label class="custom-file-label">Choose file</label>
              <span class="help-block with-errors text-danger"></span>
              <br>
                <div class="tampil-foto pt-3 pb-2">
                  <img src="{{ url($profil->foto ?? '/') }}" width="200">
                </div>
            </div>
          </div>  

          <div class="form-group row">
            <label for="old_password" class="col-lg-2 col-lg-offset-1 control-label">Password Lama</label>
            <div class="col-lg-6">
                <input type="password" name="old_password" id="old_password" class="form-control" min="8">
                <span class="has-error invalid-feedback"></span>
            </div>
          </div>

          <div class="form-group row">
            <label for="password" class="col-lg-2 col-lg-offset-1 control-label">Password</label>
            <div class="col-lg-6">
                <input type="password" name="password" id="password" class="form-control" min="8">
                <span class="has-error invalid-feedback"></span>
            </div>
          </div>

          <div class="form-group row">
              <label for="password_confirmation" class="col-lg-2 col-lg-offset-1 control-label">Konfirmasi Password</label>
              <div class="col-lg-6">
                  <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" data-match="#password">
                  <span class="has-error invalid-feedback"></span>
              </div>
          </div>

        </div>
        <div class="card-footer text-right">
          <button class="btn btn-primary btn-flat btn-sm"><i class="fa fa-save"></i> Simpan Perubahan</button>
        </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@push('script')
  <script>
    $(function (){
      $('#old_password').on('keyup', function(){
        if($(this).val() != ""){
          $('#password').attr('required', true)
        }else{
          $('#password').attr('required', false)
        }
      });

      $('.form-profil').validator().on('submit', function (e){
        if(! e.preventDefault()){
          $.ajax({
            url: $('.form-profil').attr('action'),
            type: $('.form-profil').attr('method'),
            data: new FormData($('.form-profil')[0]),
            async: false,
            processData: false,
            contentType: false
          })
          .done(response => {
            $('[name="name"]').val(response.name);

            $('.tampil-foto').html(`<img src="${response.foto}" width="200">`);
            $('.img-profil').attr('src', `{{ url('/')}}/${response.foto}`);

            $('.alert').fadeIn();
          })
          .fail(errors => {
            if(errors.status == 422){
              alert(errors.responseJSON);
            }else{
              alert('Tidak dapat menyimpan data');
            }
            return;
          })
        }
      })
    });
  </script>
@endpush