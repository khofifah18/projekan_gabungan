<!-- Notifikasi -->
<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $this->session->flashdata('success'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo $this->session->flashdata('error'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<div class="container-fluid">
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-0">
            <h1 class="h4 mb-0 text-gray-800" style="color: black; font-weight: bold;">Akun Tersimpan</h1>
        </div>
        <div class="card-header">
            <a href="<?php echo base_url('akun/tambah_akun') ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i>Tambah Akun</a>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Akun Tersimpan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <?php if (!empty($data)): ?>
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <td class="bg-primary text-center" style="color: white; font-weight: bold;">No</td>
                                    <td class="bg-primary text-center" style="color: white; font-weight: bold;">NIP</td>
                                    <td class="bg-primary text-center" style="color: white; font-weight: bold;">Nama</td>
                                    <td class="bg-primary text-center" style="color: white; font-weight: bold;">Jenis Kelamin</td>
                                    <td class="bg-primary text-center" style="color: white; font-weight: bold;">Username</td>
                                    <td class="bg-primary text-center" style="color: white; font-weight: bold;">Password</td>
                                    <td class="bg-primary text-center" style="color: white; font-weight: bold;">Level</td>
                                    <td class="bg-primary text-center" style="color: white; font-weight: bold;">Action</td>
                                </tr>
                            </thead>
                            <?php $i = 1; ?>
                            <?php foreach ($data as $key => $value): ?>
                                <tr>
                                    <td class="text-center"><?php echo $i++; ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars($value['nip']); ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars($value['nama']); ?></td>
                                    <td class="text-center"><?php echo $value['jenis_kelamin'] == 'laki-laki' ? 'Laki-laki' : 'Perempuan'; ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars($value['username']); ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars($value['password']); ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars($value['level']); ?></td>
                                    <td class="text-center">
                                        <a href="<?php echo base_url('akun/edit/' . $value['nip']); ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="<?php echo base_url('akun/delete/' . $value['nip']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus akun?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>