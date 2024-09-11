<script>
    function validateNip(event) {
        const nipInput = document.getElementById('nip');
        const nipValue = nipInput.value;
        if (nipValue.length !== 18 || isNaN(nipValue)) {
            alert('NIP harus terdiri dari 18 angka.');
            event.preventDefault(); // Mencegah pengiriman form jika validasi gagal
        }
    }

    function confirmSubmission(event) {
        if (!confirm('Apakah Anda yakin ingin menambahkan akun ini?')) {
            event.preventDefault();
        }
    }

    // Gabungkan validasi NIP dan konfirmasi pengiriman form
    function handleFormSubmission(event) {
        validateNip(event);
        if (!event.defaultPrevented) { // Hanya konfirmasi jika validasi NIP berhasil
            confirmSubmission(event);
        }
    }
</script>



<div class="container-fluid">
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-0">
            <h3 class="h4 mb-0 text-gray-800" style="color: gray; font-weight: bold;">Form Tambah Akun</h3>
        </div>
        <div class="card-header">
            <!-- </div> -->
            <a href="<?php echo base_url('akun') ?>">
                <button class="btn btn-primary">Data Akun</button>
            </a>

        </div>

        <!-- Notifikasi Sukses -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $this->session->flashdata('success'); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <!-- Notifikasi Error -->
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $this->session->flashdata('error'); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="<?php echo base_url('akun/action_tambah') ?>" method="post" onsubmit="handleFormSubmission(event)">
                    <div class="form-group mb-3">
                        <label for="nip">NIP</label>
                        <input type="number" id="nip" name="nip" class="form-control" value="<?php echo set_value('nip'); ?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="nama">Nama</label>
                        <input type="text" id="nama" name="nama" class="form-control" value="<?php echo set_value('nama'); ?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" class="form-control">
                            <option value="laki-laki" <?php echo set_select('jenis_kelamin', 'laki-laki'); ?>>Laki-laki</option>
                            <option value="perempuan" <?php echo set_select('jenis_kelamin', 'perempuan'); ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-control" value="<?php echo set_value('username'); ?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" value="<?php echo set_value('password'); ?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="level">Level</label>
                        <select id="level" name="level" class="form-control" required>
                            <option value="">Pilih Level</option>
                            <option value="Operator" <?php echo set_select('level', 'Operator'); ?>>Operator</option>
                            <option value="Koordinator" <?php echo set_select('level', 'Koordinator'); ?>>Koordinator</option>
                        </select>
                    </div>
                    <div class="no-print mt-3">
                        <button type="reset" class="btn btn-danger"><i class="fas fa-trash"></i>Reset</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>