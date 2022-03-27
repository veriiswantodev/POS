<div class="modal fade" id="modal-produk" tabindex="-1" aria-labelledby="modal-supplier" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <table class="table table-striped table-bordered table-produk">
                    <thead>
                        <th width="5%">No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Harga Beli</th>
                        <th>
                            <i class="fa fa-cog"></i>
                        </th>
                    </thead>
                    <tbody>
                        @foreach ($produk as $key => $item)
                            <tr>
                                <td width="5%">{{ $key+1 }}</td>
                                <td width="15%"><span class="bg-lime color-pallete">{{ $item->kode_produk }}</span></td>
                                <td>{{ $item->nama_produk }}</td>
                                <td width="15%">{{ format_uang($item->harga_beli) }}</td>
                                <td width="15%">
                                    <a href="#" class="btn btn-primary btn-xs btn-flat" onclick="pilihProduk('{{$item->id_produk}}', '{{$item->kode_produk}}')">
                                        <i class="fa fa-check-circle"></i> 
                                        Pilih
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
               </table>
            </div>
        </div>

    </div>
</div>
