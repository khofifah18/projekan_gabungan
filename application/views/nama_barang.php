<?= $this->session->flashdata('pesan_tambah'); ?>
<?= $this->session->flashdata('pesan_edit'); ?>
<?= $this->session->flashdata('pesan_berhasil_hapus'); ?>
<?= $this->session->flashdata('pesan_gagal_hapus'); ?>
<?= $this->session->flashdata('berhasil_import'); ?>
<?= $this->session->flashdata('gagal_import'); ?>
<div class="container-fluid">
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-0">
            <h1 class="h4 mb-0 text-gray-800" style="color: black; font-weight: bold;">Nama Barang</h1>
        </div>
        <div class="card-header d-flex">
            <a href="<?php echo base_url('nama_barang/tambah_nama') ?>" class="btn btn-primary mr-2">
                <i class="fas fa-plus"></i>Tambah Nama</a>
            <a href="<?php echo base_url('nama_barang/import_nama') ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i>Import</a>
        </div>

        <!-- DataTales Example -->
        <!-- <div class="container-fluid"> -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Master Nama Barang</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <td class="bg-primary text-center" style="color: white; font-weight: bold;" width="5%">No</td>
                                <td class="bg-primary text-center" style="color: white; font-weight: bold;">Nama Barang</td>
                                <td class="bg-primary text-center" style="color: white; font-weight: bold;" width="20%">Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($nama as $nm) : ?>
                                <tr>
                                    <td class="text-center"><?php echo $no++ ?> </td>
                                    <td class="text-center"><?php echo $nm->nama_barang; ?> </td>
                                    <td class="text-center">
                                        <a href="<?php echo base_url('nama_barang/edit_nama/' . urlencode($nm->nama_barang)); ?>"
                                            class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                        <a href="<?php echo base_url('nama_barang/hapus_nama/' . $nm->nama_barang); ?>"
                                            class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin menghapus nama barang ini?')">
                                            <i class="fas fa-trash"></i> Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- </div> -->
    </div>
</div>