<div class="container-fluid">
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-0">
            <h3 class="h4 mb-0 text-gray-800" style="color: gray; font-weight: bold;">Edit Nama Barang</h3>
        </div>
        <br>
        <div class="card shadow mb-4">
            <div class="card-body">
                <form method="post" action="<?php echo base_url('nama_barang/update_nama'); ?>">
                    <div class="form-group">
                        <label style="color: gray; font-weight: bold;">Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control" value="<?php echo $nama->nama_barang; ?>" required>
                        <input type="hidden" name="nama_barang_lama" value="<?php echo $nama->nama_barang; ?>">
                    </div>
                    <a href="<?php echo base_url('nama_barang') ?>" type="reset" class="btn btn-danger"><i class="fas fa-arrow-left"></i>Batal</a>
                    <button type="submit" class="btn btn-primary"
                        onclick="return confirm('Apakah Anda yakin mengubah nama barang ini?')">
                        <i class="fas fa-save"></i>Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>