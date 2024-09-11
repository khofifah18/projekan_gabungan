<div class="container-fluid">
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-0">
            <h1 class="h4 mb-0 text-gray-800" style="color: gray; font-weight: bold;">Edit Jenis Barang</h1>
        </div>
        <br>
        <div class="card shadow mb-4">
            <div class="card-body">
                <form method="post" action="<?php echo base_url('jenis_barang/update_jenis'); ?>">
                    <div class="form-group">
                        <label style="color: gray; font-weight: bold;">Jenis Barang</label>
                        <input type="text" name="jenis_barang" class="form-control" value="<?php echo $jenis->jenis_barang; ?>" required>
                        <input type="hidden" name="jenis_barang_lama" value="<?php echo $jenis->jenis_barang; ?>">
                    </div>
                    <a href="<?php echo base_url('jenis_barang') ?>" class="btn btn-danger">
                        <i class="fas fa-arrow-left"></i>Batal</a>
                    <button type="submit" class="btn btn-primary"
                        onclick="return confirm('Apakah Anda yakin mengubah jenis barang ini?')">
                        <i class="fas fa-save"></i>Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>