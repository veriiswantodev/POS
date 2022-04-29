<div class="modal fade" id="modal-form" tabindex="-1" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('laporan.index') }}" method="get" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Periode Laporan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="tgl_awal" class="col-md-2 col-md-offset-1 control-label" data-traget="#periode" data-toggle="datetimepicker">Tanggal Awal</label>
                        <div class="col md-6">
                            <input type="text" name="tgl_awal" id="periode" class="form-control datepicker" value="{{ request('tgl_awal') }}">
                            <span class="has-error invalid-feedback"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="tgl_akhir" class="col-md-2 col-md-offset-1 control-label">Tanggal Akhir</label>
                        <div class="col md-6">
                            <input type="text" name="tgl_akhir" id="periode" class="form-control datepicker" value="{{ request('tgl_akhir') }}">
                            <span class="has-error invalid-feedback"></span>
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
