<div class="modal fade" id="modal-form" tabindex="-1" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog">
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
                        <label for="nama_kategori" class="col-md-2 col-md-offset-1 control-label">Kategori</label>
                        <div class="col md-6">
                            <input type="text" name="kategori" id="nama_kategori" class="form-control">
                            <span class="has-error invalid-feedback"></span>
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
