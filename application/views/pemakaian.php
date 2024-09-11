<?= $this->session->flashdata('pesan_tambah'); ?>
<?= $this->session->flashdata('pesan_gagal'); ?>
<?= $this->session->flashdata('pesan_berhasil_nonaktif'); ?>
<?= $this->session->flashdata('pesan_gagal_nonaktif'); ?>

<div class="container-fluid">
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-0">
            <h1 class="h3 mb-0 text-gray-800" style="color: black; font-weight: bold;">Pemakaian Barang</h1>
        </div>
        <br>
        <form class="center" method="post" action="<?php echo base_url() . 'pemakaian/aksi_tambah_pakai'; ?>">
            <div class="form-group">
                <label>Id Pemakaian</label>
                <input type="text" name="id_pemakaian" class="form-control"
                    value="<?= $newKode; ?>" readonly>
            </div>

            <div class="form-group">
                <label>Nama Barang</label>
                <select name="no_inventori" class="form-control select2">
                    <?php foreach ($datanama as $dn): ?>
                        <option value="<?php echo $dn->no_inventori ?>">
                            <?php echo $dn->no_inventori . " - " . $dn->nama_barang . " (" . $dn->qty . ")" . " - Aktif Sampai " . "(" . $dn->masa_pakai . ")" ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Jumlah</label>
                <input type="number" name="jumlah" value="<?= set_value('jumlah'); ?>"
                    placeholder="Masukan Jumlah" class="form-control">
                <?= form_error('jumlah', '<div class="text-small text-danger">', '</div>'); ?>
            </div>
            <div class="form-group">
                <label>Lokasi</label>
                <select name="lokasi_barang" class="form-control select2">
                    <?php foreach ($datalokasi as $dl): ?>
                        <option value="<?php echo $dl->lokasi_barang ?>">
                            <?php echo $dl->lokasi_barang?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <!-- <label>Tanggal</label> -->
                <input type="hidden" name="tanggal" class="form-control"
                    value="<?= date('Y-m-d'); ?>"
                    min="<?= date('Y-m-d'); ?>"
                    max="<?= date('Y-m-d'); ?>">
            </div>
            <button type="reset" class="btn btn-danger"><i class="fas fa-trash"></i>Reset</button>
            <button type="submit" class="btn btn-primary"
                onclick="return confirm('Apakah Anda yakin memakai barang ini?')">
                <i class="fas fa-save"></i>Simpan
            </button>
        </form>
    </div>
    <br>
    <br>


    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-0">
            <h1 class="h3 mb-0 text-gray-800" style="color: black; font-weight: bold;">Daftar Barang Terpakai</h1>
        </div>
        <br>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Barang Yang Sudah Dipakai</h6>
                <div class="dropdown">
                    <a href="#" data-toggle="dropdown">
                        <i class="fas fa-bell"></i>
                        <span class="badge badge-danger"><?php echo $jumlah_notifikasi; ?></span>
                    </a>
                    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                        <h6 class="dropdown-header text-danger text-center font-weight-bold" style="font-size: 1.0em;">
                            Barang Dengan Masa Pakai Habis
                        </h6>
                        <?php
                        $has_notifikasi = false; //untuk memeriksa apakah ada notifikasi atau tidak
                        foreach ($notifikasi as $cek) {
                            $id_pemakaian = $cek['id_pemakaian'];
                            if ($cek['interval_tanggal'] == 0) {
                                echo "<div class='dropdown-item border rounded mb-2 p-3'>
                                        <div class='d-flex align-items-center'>
                                            <div class='mr-3'>
                                                <div class='icon-circle bg-warning'>
                                                    <i class='fas fa-exclamation-triangle text-white'></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class='small text-gray-1000' style='font-size: 0.9rem;'>Hari ini</div>
                                                <span class='font-weight-bold' style='font-size: 1.0rem;'>Id Pemakaian <a style='color:red'>" . $id_pemakaian . "</a> masa pakai habis hari ini</span>
                                            </div>
                                        </div>
                                    </div>";
                                $has_notifikasi = true;
                            } elseif ($cek['interval_tanggal'] < 0) {
                                echo "<div class='dropdown-item border rounded mb-2 p-3'>
                                        <div class='d-flex align-items-center'>
                                            <div class='mr-3'>
                                                <div class='icon-circle bg-danger'>
                                                    <i class='fas fa-info-circle text-white'></i>
                                                </div>
                                                
                                            </div>
                                            <div>
                                                <div class='small text-gray-1000' style='font-size: 0.9rem;'>Melewati batas</div>
                                                <span class='font-weight-bold' style='font-size: 1.0rem;'>Id Pemakaian <a style='color:red'>" . $id_pemakaian . "</a> melewati batas masa pakai</span>
                                            </div>
                                        </div>
                                    </div>";
                                $has_notifikasi = true;
                            }
                        }
                        if (!$has_notifikasi) {
                            echo "<div class='dropdown-item border rounded mb-2 p-3'>
                                    <div class='d-flex align-items-center'>
                                        <div class='mr-3'>
                                            <div class='icon-circle bg-danger'>
                                                <i class='fas fa-times text-white'></i>
                                            </div>                                                
                                        </div>
                                        <div>
                                            <span class='font-weight-bold' style='font-size: 1.0rem;'>Belum ada data yang masa pakainya habis</span>
                                        </div>
                                    </div>
                                </div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <td class="bg-primary" style="color: white; font-weight: bold;">Id Pemakaian</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;">No Invetori</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;">Tgl Pemakaian</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;">Nama Barang</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;">Jenis Barang</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;">Jumlah</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;">Lokasi</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;">Masa Pakai</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;">Status</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;">Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($pemakaian) && !empty($pemakaian)): ?>
                                <?php foreach ($pemakaian as $pk): ?>
                                    <tr>
                                        <td><?php echo $pk->id_pemakaian; ?></td>
                                        <td><?php echo $pk->no_inventori; ?></td>
                                        <td><?php echo $pk->tanggal; ?></td>

                                        <td><?php echo $pk->nama_barang; ?></td>
                                        <td><?php echo $pk->jenis_barang; ?></td>

                                        <td><?php echo $pk->jumlah; ?></td>
                                        <td><?php echo $pk->lokasi_barang; ?></td>

                                        <td><?php echo $pk->masa_pakai; ?></td>
                                        <td><?php echo $pk->status; ?></td>
                                        <td>
                                            <?php if ($pk->masa_pakai <= date('Y-m-d')): ?>
                                                <a href="<?= base_url('pemakaian/aksi_penyusutan/' . $pk->id_pemakaian); ?>" class="btn btn-primary">
                                                    <i class="fas fa-paper-plane"></i> Penyusutan
                                                </a>
                                            <?php else: ?>
                                                <a href="#" class="btn btn-secondary" disabled>
                                                    <i class="fas fa-paper-plane"></i> Penyusutan
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8">Tidak ada data tersedia.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>