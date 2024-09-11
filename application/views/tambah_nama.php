<div class="container-fluid">
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-0">
            <h3 class="h4 mb-0 text-gray-800" style="color: gray; font-weight: bold;">Tambah Nama Barang</h3>
        </div>
        <div class="card-header">
            <a href="<?php echo base_url('nama_barang') ?>">
                <button class="btn btn-primary">Data Nama Barang</button>
            </a>
        </div>
        <div class="card shadow mb-4">
            <div class="card-body">
                <form class="center" method="post" action="<?php echo base_url() . 'nama_barang/aksi_nama'; ?>">
                    <div class="form-group">
                        <label style="color: gray; font-weight: bold;">Nama Barang</label>
                        <input type="text" name="nama_barang" placeholder="Masukan Nama Barang" class="form-control">
                        <?= form_error('nama_barang', '<div class="text-small text-danger">', '</div>'); ?>
                    </div>
                    <button type="reset" class="btn btn-danger"><i class="fas fa-trash"></i>Reset</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>