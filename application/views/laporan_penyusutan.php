<div class="container-fluid">
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-0">
            <h1 class="h3 mb-0 text-gray-800" style="color: black; font-weight: bold;">Laporan Penyusutan Barang</h1>
        </div>
        <br>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <a href="<?php echo base_url('laporan_penyusutan/cetak?start_date=' . $this->input->get('start_date') . '&end_date=' .
                                        $this->input->get('end_date')); ?>" class="btn btn-info btn-sm">
                            <i class="fas fa-print"></i> Cetak
                        </a>
                    </h6>
                    <!-- Form Filter -->
                    <form method="get" action="<?php echo base_url('laporan_penyusutan/filter'); ?>" class="form-inline">
                        <div class="form-group mb-0">
                            <label for="start_date" class="sr-only">Tanggal Mulai</label>
                            <input type="date" class="form-control mr-2" id="start_date" name="start_date" placeholder="Tanggal Mulai">
                        </div>
                        <div class="form-group mb-0">
                            <label for="end_date" class="sr-only">Tanggal Akhir</label>
                            <input type="date" class="form-control mr-2" id="end_date" name="end_date" placeholder="Tanggal Akhir">
                        </div>
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                            <td class="bg-primary" style="color: white; font-weight: bold;">Id</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;">No Invetori</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;">Nama Barang</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;">Jenis Barang</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;">Jumlah</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;">Tanggal</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;">Masa Pakai</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;">Status</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;">Lokasi</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($penyusutan) && !empty($penyusutan)): ?>
                                <?php foreach ($penyusutan as $item): ?>
                                    <tr>
                                        <td><?php echo isset($item['id_pemakaian']) ? $item['id_pemakaian'] : (isset($item['id_barang_masuk']) ? $item['id_barang_masuk'] : ''); ?></td>
                                        <td><?php echo isset($item['no_inventori']) ? $item['no_inventori'] : ''; ?></td>
                                        <td><?php echo isset($item['nama_barang']) ? $item['nama_barang'] : ''; ?></td>
                                        <td><?php echo isset($item['jenis_barang']) ? $item['jenis_barang'] : ''; ?></td>
                                        <td><?php echo isset($item['qty']) ? $item['qty'] : (isset($item['jumlah']) ? $item['jumlah'] : ''); ?></td>
                                        <td><?php echo isset($item['tanggal']) ? $item['tanggal'] : ''; ?></td>
                                        <td><?php echo isset($item['masa_pakai']) ? $item['masa_pakai'] : ''; ?></td>
                                        <td><?php echo isset($item['status']) ? $item['status'] : ''; ?></td>
                                        <td><?php echo isset($item['lokasi_barang']) ? $item['lokasi_barang'] : ''; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9">Tidak ada data tersedia.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>