@extends('template.master')

@section('title')
Transaksi Pembelian
@endsection

@section('breadcumb')
@parent
<li class="breadcrumb-item active">Transaksi Pembelian</li>
@endsection

@section('content')

<!-- Main row -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <table>
                    <tr>
                        <td>Supplier</td>
                        <td>: {{ $supplier->nama }}</td>
                    </tr>
                    <tr>
                        <td>Telepon</td>
                        <td>: {{ $supplier->telepon }}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>: {{ $supplier->alamat }}</td>
                    </tr>
                </table>
            </div>

            <div class="box-body table-responsive p-3">
                
                <form class="form-produk">
                  @csrf
                  <div class="form-group row">
                    <label class="col-lg-2">Kode Produk</label>
                    <div class="col-lg-5">
                      <div class="input-group">
                          <input type="hidden" name="id_produk" id="id_produk">
                          <input type="hidden" name="id_pembelian" id="id_pembelian" value="{{ $id_pembelian }}">
                          <input type="text" id="kode_produk" name="kode_produk" class="form-control">
                          <div class="input-group-append">
                              <button type="button" onclick="tampilProduk()" class="btn btn-flat btn-info"><i class="fa fa-arrow-right"></i></button>
                          </div>
                      </div>
                    </div>
                  </div>
                </form>

                <table class="table table-striped table-bordered" style="width: 100%;">
                    <thead>
                        <th width="5%">No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>
            </div>
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>

@include('pembelian_detail.produk')
@endsection

@push('script')
    <script>
        let table;

        $(function () {
            table = $('.table').DataTable({
                proccesing: true,
                autowidth: false,
                // ajax: {
                //   url: '{{ route('supplier.data') }}'
                // }, 
                // columns: [
                //   {data: 'DT_RowIndex', searchable: false, sortbale: false},
                //   {data: 'nama'},
                //   {data: 'telepon'},
                //   {data: 'alamat'},
                //   {data: 'aksi', searchable: false, sortable: false}
                // ]
            });
        });


        function tampilProduk() {
            $('#modal-produk').modal('show');
        }

        
        function pilihProduk(id, kode) {
          $('#id_produk').val(id);
          $('#kode_produk').val(kode);
           hideProduk();
          tambahProduk();
        }
        
        function hideProduk() {
            $('#modal-produk').modal('hide');
        }
        
        function tambahProduk(){
          $.post('{{ route('pembelian_detail.store') }}', $('.form-produk').serialize())
                .done(response => {
                  $('#kode_produk').focus();
                })
                .fail(errors =>{
                  alert('Tidak dapat menyimpan data');
                  return;
                })
        }

        function deleteData(url) {
            if (confirm('Yakin ingin manghapus data terpilih?')) {
                $.post(url, {
                        '_token': $('[name=csrf-token]').attr('content'),
                        '_method': 'delete'
                    })
                    .done((response) => {
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
