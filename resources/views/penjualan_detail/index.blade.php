@extends('template.master')

@section('title')
Transaksi Penjualan
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

        .table-penjualan tbody tr:last-child{
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
<li class="breadcrumb-item active">Transaksi Penjualan</li>
@endsection

@section('content')

<!-- Main row -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            

            <div class="box-body table-responsive p-3">
                
                <form class="form-produk">
                  @csrf
                  <div class="form-group row">
                    <label class="col-lg-2">Kode Produk</label>
                    <div class="col-lg-5">
                      <div class="input-group">
                          <input type="hidden" name="id_produk" id="id_produk">
                          <input type="hidden" name="id_penjualan" id="id_penjualan" value="{{ $id_penjualan }}">
                          <input type="text" id="kode_produk" name="kode_produk" class="form-control">
                          <div class="input-group-append">
                              <button type="button" onclick="tampilProduk()" class="btn btn-flat btn-info"><i class="fa fa-arrow-right"></i></button>
                          </div>
                      </div>
                    </div>
                  </div>
                </form>

                <table class="table table-striped table-bordered table-penjualan" style="width: 100%;">
                    <thead>
                        <th width="5%">No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th width="15%">Jumlah</th>
                        <th>Diskon</th>
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
                        <form action="{{route('transaksi.simpan')}}" class="form-pembelian" method="POST">
                            @csrf
                            <input type="hidden" name="id_penjualan" value="{{$id_penjualan}}">
                            <input type="hidden" name="total" id="total">
                            <input type="hidden" name="total_item" id="total_item">
                            <input type="hidden" name="bayar" id="bayar">
                            <input type="hidden" name="id_member" id="id_member" value="{{ $memberSelected->id_member }}">

                            <div class="form-group row">
                                <label for="totalrp" class="col-lg-4 control-label">Total</label>
                                <div class="col-lg-8">
                                    <input type="text" id="totalrp" disabled class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="kode_member" class="col-lg-4 control-label">Member</label>
                                <div class="col-lg-8">
                                    <div class="input-group">
                                        <input type="text" id="kode_member" class="form-control" value="{{$memberSelected->kode_member}}">
                                        <div class="input-group-append">
                                            <button type="button" onclick="tampilMember()" class="btn btn-flat btn-info"><i class="fa fa-arrow-right"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="diskon" class="col-lg-4 control-label">Diskon</label>
                                <div class="col-lg-8">
                                    <input type="number" name="diskon" id="diskon" class="form-control" value="{{! empty($memberSelected->id_member) ? $diskon : 0}}" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="bayar" class="col-lg-4 control-label">Bayar</label>
                                <div class="col-lg-8">
                                    <input type="text" id="bayarrp" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="diterima" class="col-lg-4 control-label">Diterima</label>
                                <div class="col-lg-8">
                                    <input type="text" id="diterima" name="diterima" class="form-control" value="{{ $penjualan->diterima ?? 0 }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="kembali" class="col-lg-4 control-label">Kembali</label>
                                <div class="col-lg-8">
                                    <input type="text" id="kembali" name="kembali" class="form-control" value="0" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-success btn-sm btn-flat float-right btn-simpan"><i class="fa fa-save"> Simpan Transaksi</i></button>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>

@include('penjualan_detail.produk')
@include('penjualan_detail.member')
@endsection

@push('script')
    <script>
        $('body').addClass('sidebar-collapse');

        let table, table2;

        $(function () {
            table = $('.table-penjualan').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                dom: 't',
                paging: false,
                ajax: {
                  url: '{{ route('transaksi.data', $id_penjualan) }}'
                }, 
                columns: [
                  {data: 'DT_RowIndex', searchable: false, sortbale: false},
                  {data: 'kode_produk'},
                  {data: 'nama_produk'},
                  {data: 'harga_jual'},
                  {data: 'jumlah'},
                  {data: 'diskon'},
                  {data: 'subtotal'},
                  {data: 'aksi', searchable: false, sortable: false}
                ]
            })
            .on('draw.dt', function(){
                loadForm($('#diskon').val());
                setTimeout(() => {
                    $('#diterima').trigger('input')
                }, 300);
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
                $.post(`{{ url('/transaksi')}}/${id}`, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'put',
                    'jumlah': jumlah
                })
                    .done(response => {
                        $(this).on('mouseout', function(){
                            table.ajax.reload(() => loadForm($('#diskon').val()));
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

            $('#diterima').on('input', function () {
                if ($(this).val() == "") {
                    $(this).val(0).select();
                }
                loadForm($('#diskon').val(), $(this).val());
            }).focus(function () {
                $(this).select();
            });

            $('.btn-simpan').on('click', function() {
                $('.form-penjualan').submit();
            })
        });

        function tampilMember(){
        $('#modal-member').modal('show');
        }

        function pilihMember(id, kode) {
            $('#id_member').val(id);
            $('#kode_member').val(kode);
            $('#diskon').val('{{ $diskon }}');
            loadForm($('#diskon').val());
            $('#diterima').val(0).focus().select();
            hideMember();
        }

        function hideMember() {
            $('#modal-member').modal('hide');
        }


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
          $.post('{{ route('transaksi.store') }}', $('.form-produk').serialize())
                .done(response => {
                  $('#kode_produk').focus();
                  table.ajax.reload(() => loadForm($('#diskon').val()));
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
                    table.ajax.reload(() => loadForm($('#diskon').val()));
                })
                .fail((errors) => {
                    alert('Anda yakin menhapus data ini?');
                    return;
                })
            }
        }

        function loadForm(diskon = 0, diterima = 0){
            $('#total').val($('.total').text());
            $('#total_item').val($('.total_item').text());
            $.get(`{{ url('/transaksi/loadform') }}/${diskon}/${$('.total').text()}/${diterima}`)
                .done(response => {
                    $('#totalrp').val('Rp. '+ response.totalrp);
                    $('#bayarrp').val('Rp. '+ response.bayarrp);
                    $('#bayar').val(response.bayar);
                    $('.tampil-bayar').text('Bayar : Rp. '+ response.bayarrp);
                    $('.tampil-terbilang').text(response.terbilang);

                    $('#kembali').val('Rp.'+ response.kembalirp);
                    if ($('#diterima').val() != 0) {
                        $('.tampil-bayar').text('Kembali: Rp. '+ response.kembalirp);
                        $('.tampil-terbilang').text(response.kembali_terbilang);
                    }
                })
                .fail(errors => {
                    alert('Tidak dapat menampilkan data');
                    return;
                })
        }

    </script>
@endpush
