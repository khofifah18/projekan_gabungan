<div class="container-fluid">
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-0">
            <h3 class="h4 mb-0 text-gray-800" style="color: gray; font-weight: bold;">Form Edit Akun</h3>
        </div>
        <div class="card-header">
            <!-- </div> -->
            <a href="<?php echo base_url('akun') ?>">
                <button class="btn btn-primary">Data Akun</button>
            </a>

        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="<?php echo base_url('akun/action_edit/' . ($data['nip'] ?? '')); ?>" method="post" onsubmit="return confirmEdit();">
                    <div class="form-group mb-3">
                        <label for="nip">NIP</label>
                        <input readonly type="text" id="nip" name="nip" class="form-control" value="<?php echo htmlspecialchars($data['nip'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="nama">Nama</label>
                        <input type="text" id="nama" name="nama" class="form-control" value="<?php echo htmlspecialchars($data['nama'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" class="form-control">
                            <option value="laki-laki" <?php echo (isset($data['jenis_kelamin']) && $data['jenis_kelamin'] === 'laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                            <option value="perempuan" <?php echo (isset($data['jenis_kelamin']) && $data['jenis_kelamin'] === 'perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-control" value="<?php echo htmlspecialchars($data['username'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" value="<?php echo htmlspecialchars($data['password'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="level">Level</label>
                        <select id="level" name="level" class="form-control" required>
                            <!-- <option value="">Pilih Level</option> -->
                            <option value="Koordinator" <?php echo (isset($data['level']) && $data['level'] === 'Koordinator') ? 'selected' : ''; ?>>Koordinator</option>
                            <option value="Operator" <?php echo (isset($data['level']) && $data['level'] === 'Operator') ? 'selected' : ''; ?>>Operator</option>
                        </select>
                    </div>

                    <div class="no-print mt-3">
                        <a href="<?php echo base_url('akun') ?>" class="btn btn-danger">
                            <i class="fas fa-arrow-left"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>