@extends('template.master')

@section('title')
Transaksi Pembelian
@endsection

@push('css')
    <style>
        .tampil-bayar{
            font-size: 5em;
            text-align: center;
        }

        .tampil-terbilang{
            padding: 10px;
            background: #f0f0f0;
        }

        .hide{
            visibility: hidden;
        }

        .table-pembelian tbody tr:last-child{
            display: none;
        }

        @media(max-width: 786px){
            .tampil-bayar{
                font-size: 3em;
                height: 70px;
                padding-top:0px;
            }
        }
    </style>
@endpush

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

                <table class="table table-striped table-bordered table-pembelian" style="width: 100%;">
                    <thead>
                        <th width="5%">No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th width="15%">Jumlah</th>
                        <th>Subtotal</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="tampil-bayar bg-primary">
                            
                        </div>
                        <div class="tampil-terbilang">
                         
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <form action="{{route('pembelian.store')}}" class="form-pembelian" method="POST">
                            @csrf
                            <input type="hidden" name="id_pembelian" value="{{$id_pembelian}}">
                            <input type="hidden" name="total" id="total">
                            <input type="hidden" name="total_item" id="total-item">
                            <input type="hidden" name="bayar" id="bayar">

                            <div class="form-group row">
                                <label for="totalrp" class="col-lg-4 control-label">Total</label>
                                <div class="col-lg-8">
                                    <input type="text" id="totalrp" disabled class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="diskon" class="col-lg-4 control-label">Diskon</label>
                                <div class="col-lg-8">
                                    <input type="number" name="diskon" id="diskon" class="form-control" value="0">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="bayar" class="col-lg-4 control-label">Bayar</label>
                                <div class="col-lg-8">
                                    <input type="text" id="bayarrp" class="form-control">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-sm btn-flat pull-right btn-simpan"><i class="fa fa-floppy-o"> Simpan Transaksi</i></button>
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
        let table, table2;

        $(function () {
            table = $('.table-pembelian').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                dom: 't',
                paging: false,
                ajax: {
                  url: '{{ route('pembelian_detail.data', $id_pembelian) }}'
                }, 
                columns: [
                  {data: 'DT_RowIndex', searchable: false, sortbale: false},
                  {data: 'kode_produk'},
                  {data: 'nama_produk'},
                  {data: 'harga_beli'},
                  {data: 'jumlah'},
                  {data: 'subtotal'},
                  {data: 'aksi', searchable: false, sortable: false}
                ]
            })
            .on('draw.dt', function(){
                loadForm($('#diskon').val());
            });

            table2 = $('.table-produk').DataTable();

            $(document).on('input', '.quantity', function () {
                let id = $(this).data('id');
                let jumlah = parseInt($(this).val());

                if(jumlah < 1){
                    alert('Jumlah tidak boleh kurang dari 1!');
                    $(this).val(1);
                    return;
                }

                if(jumlah > 10000){
                    alert('Jumlah tidak boleh lebih dari 10.000!');
                    $(this).val(10000);
                    return;
                }
                $.post(`{{ url('/pembelian_detail')}}/${id}`, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'put',
                    'jumlah': jumlah
                })
                    .done(response => {
                        $(this).on('mouseout', function(){
                            table.ajax.reload();
                        })
                    })
                    .fail(errors => {
                        alert('Tidak dapat menyimpan data');
                        return;
                    })
            });

            $(document).on('input', '#diskon', function() {
                if ($(this).val() == "") {
                    $(this).val(0).select();
                }
                loadForm($(this).val());
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
                  table.ajax.reload();
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

        function loadForm(diskon = 0){
            $('#total').val($('.total').text());
            $('#total_item').val($('.total_item').text());
            $.get(`{{ url('/pembelian_detail/loadform') }}/${diskon}/${$('.total').text()}`)
                .done(response => {
                    $('#totalrp').val('Rp. '+ response.totalrp);
                    $('#bayarrp').val('Rp. '+ response.bayarrp);
                    $('#bayar').val(response.bayar);
                    $('.tampil-bayar').text('Rp. '+ response.bayarrp);
                    $('.tampil-terbilang').text(response.terbilang);
                })
                .fail(errors => {
                    alert('Tidak dapat menampilkan data');
                    return;
                })
        }

    </script>
@endpush
