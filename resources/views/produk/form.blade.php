<div class="modal fade" id="modal-form" tabindex="-1" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="" method="post" class="form-horizontal">
            @csrf
            @method('post')

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="produk" class="col-md-2 col-md-offset-1 control-label">Nama</label>
                        <div class="col md-6">
                            <input type="text" name="nama_produk" id="produk" class="form-control" autofocus>
                            <span class="error invalid-feedback"></span>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="Kategori" class="col-md-2 col-md-offset-1 control-label">Kategori</label>
                        <div class="col md-6">
                            <select name="id_kategori" id="id_kategori" class="form-control">
                                <option value="">Pilih Kategori</option>
                                @foreach($kategori as $key => $item)
                                    <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            </select>
                            <span class="error invalid-feedback"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="merk" class="col-md-2 col-md-offset-1 control-label">Merk</label>
                        <div class="col md-6">
                            <input type="text" name="merk" id="merk" class="form-control" autofocus>
                            <span class="error invalid-feedback"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="harg_beli" class="col-md-2 col-md-offset-1 control-label">Harga Beli</label>
                        <div class="col md-6">
                            <input type="number" name="harga_beli" id="harga_beli" class="form-control" autofocus>
                            <span class="error invalid-feedback"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="harga_jual" class="col-md-2 col-md-offset-1 control-label">Harga Jual</label>
                        <div class="col md-6">
                            <input type="number" name="harga_jual" id="harga_jual" class="form-control" autofocus>
                            <span class="error invalid-feedback"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="diskon" class="col-md-2 col-md-offset-1 control-label">Diskon</label>
                        <div class="col md-6">
                            <input type="number" name="diskon" id="diskon" class="form-control" autofocus value="0">
                            <span class="error invalid-feedback"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                      <label for="stok" class="col-md-2 col-md-offset-1 control-label">Stock</label>
                      <div class="col md-6">
                          <input type="number" name="stok" id="stok" class="form-control" autofocus value="0">
                          <span class="error invalid-feedback"></span>
                      </div>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-xs btn-flat btn-info">Simpan</button>
                    <button type="button" class="btn btn-xs btn-flat btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
