<div class="container-fluid">
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-0">
            <h3 class="h4 mb-0 text-gray-800" style="color: gray; font-weight: bold;">Edit Lokasi Barang</h3>
        </div>
        <br>
        <div class="card shadow mb-4">
            <div class="card-body">
                <form method="post" action="<?php echo base_url('lokasi_barang/update_lokasi'); ?>">
                    <div class="form-group">
                        <label style="color: gray; font-weight: bold;">Lokasi Barang</label>
                        <input type="text" name="lokasi_barang" class="form-control" value="<?php echo $lokasi->lokasi_barang; ?>" required>
                        <input type="hidden" name="lokasi_barang_lama" value="<?php echo $lokasi->lokasi_barang; ?>">
                    </div>
                    <a href="<?php echo base_url('lokasi_barang') ?>" type="reset" class="btn btn-danger"><i class="fas fa-arrow-left"></i>Batal</a>
                    <button type="submit" class="btn btn-primary"
                        onclick="return confirm('Apakah Anda yakin mengubah nama lokasi barang ini?')">
                        <i class="fas fa-save"></i>Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>