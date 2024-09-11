<?= $this->session->flashdata('pesan_tambah'); ?>
<?= $this->session->flashdata('pesan_gagal'); ?>
<?= $this->session->flashdata('pesan_berhasil_nonaktif'); ?>
<?= $this->session->flashdata('pesan_gagal_nonaktif'); ?>

<div class="container-fluid">
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-0">
            <h1 class="h3 mb-0 text-gray-800" style="color: black; font-weight: bold;">Barang Masuk</h1>
        </div>
        <br>
        <form class="center" method="post" action="<?php echo base_url() . 'barang_masuk/aksi_tambah_barang'; ?>">
            <div class="form-group">
                <label>Id Barang Masuk</label>
                <input type="text" name="id_barang_masuk" class="form-control"
                    value="<?= $newKode; ?>" readonly>
            </div>
            <div class="form-group">
                <label>No Inventori</label>
                <input type="text" name="no_inventori" class="form-control"
                    value="<?= $newInv; ?>" readonly>
            </div>

            <div class="form-group">
                <label>Nama Barang</label>
                <select name="nama_barang" class="form-control select2">
                    <?php foreach ($master_nama as $mn): ?>
                        <option value="<?php echo $mn->nama_barang ?>">
                            <?php echo $mn->nama_barang ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Jenis Barang</label>
                <select name="jenis_barang" class="form-control select2">
                    <?php foreach ($master_jenis as $mj): ?>
                        <option value="<?php echo $mj->jenis_barang ?>">
                            <?php echo $mj->jenis_barang ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Qty</label>
                <input type="number" name="qty" placeholder="Masukan Qty" value="<?= set_value('qty'); ?>" class="form-control">
                <?= form_error('qty', '<div class="text-small text-danger">', '</div>'); ?>
            </div>
            <div class="form-group">
                <label>Masa Pakai</label>
                <input type="date" name="masa_pakai" value="<?= set_value('masa_pakai'); ?>" class="form-control">
                <?= form_error('masa_pakai', '<div class="text-small text-danger">', '</div>'); ?>
            </div>
            <div class="form-group">
                <label>Status</label>
                <input type="text" name="status" class="form-control" value="Aktif" readonly>
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
                onclick="return confirm('Apakah Anda yakin memasukan barang ini?')">
                <i class="fas fa-save"></i>Simpan
            </button>
        </form>
    </div>
    <br>
    <br>


    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-0">
            <h1 class="h3 mb-0 text-gray-800" style="color: black; font-weight: bold;">Daftar Barang Tersedia</h1>
        </div>
        <br>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Barang Yang Tersedia</h6>
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
                            $id_barang_masuk = $cek['id_barang_masuk'];
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
                                                <span class='font-weight-bold' style='font-size: 1.0rem;'>Id Pemakaian <a style='color:red'>" . $id_barang_masuk . "</a> masa pakai habis hari ini</span>
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
                                                <span class='font-weight-bold' style='font-size: 1.0rem;'>Id Pemakaian <a style='color:red'>" . $id_barang_masuk . "</a> melewati batas masa pakai</span>
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
                                <td class="bg-primary" style="color: white; font-weight: bold;" width="13%">Id Barang Masuk</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;" width="11%">No Inventori</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;">Tanggal Masuk</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;">Nama Barang</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;">Jenis Barang</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;" width="5%">Jumlah</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;" width="10%">Masa Pakai</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;">Status</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;">Aksi</td>

                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($barang_masuk) && !empty($barang_masuk)): ?>
                                <?php foreach ($barang_masuk as $bm): ?>
                                    <tr>
                                        <td><?php echo $bm->id_barang_masuk; ?></td>
                                        <td><?php echo $bm->no_inventori; ?></td>
                                        <td><?php echo $bm->tanggal; ?></td>
                                        <td><?php echo $bm->nama_barang; ?></td>
                                        <td><?php echo $bm->jenis_barang; ?></td>
                                        <td><?php echo $bm->qty; ?></td>
                                        <td><?php echo $bm->masa_pakai; ?></td>
                                        <td><?php echo $bm->status; ?></td>
                                        <td>
                                            <?php if ($bm->masa_pakai <= date('Y-m-d')): ?>
                                                <a href="<?= base_url('barang_masuk/aksi_penyusutan/' . $bm->id_barang_masuk); ?>" class="btn btn-primary">
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
                                    <td colspan="7">Tidak ada data tersedia.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>