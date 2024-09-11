<div class="container-fluid">
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-0">
            <h1 class="h3 mb-0 text-gray-800" style="color: black; font-weight: bold;">Laporan Barang Terpakai</h1>
        </div>
        <br>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <a href="<?php echo base_url('laporan_pemakaian/cetak?start_date=' . $this->input->get('start_date') . '&end_date=' .
                                        $this->input->get('end_date')); ?>" class="btn btn-info btn-sm">
                            <i class="fas fa-print"></i> Cetak
                        </a>
                    </h6>
                    <!-- Form Filter -->
                    <form method="get" action="<?php echo base_url('laporan_pemakaian/filter'); ?>" class="form-inline">
                        <div class="form-group mb-0">
                            <h6 class="h8 mb-0 text-gray-800" style="padding-left: 10px; padding-right: 10px;">Mulai :</h6>
                            <label for="start_date" class="sr-only">Tanggal Mulai</label>
                            <input type="date" class="form-control mr-2" id="start_date" name="start_date" placeholder="Tanggal Mulai">
                        </div>
                        <div class="form-group mb-0">
                            <h6 class="h8 mb-0 text-gray-800" style="padding-left: 10px; padding-right: 10px;">Sampai :</h6>
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
                                <td class="bg-primary" style="color: white; font-weight: bold;">Id Pemakaian</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;">No Invetori</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;">Tgl Pemakaian</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;">Nama Barang</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;">Jenis Barang</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;">Jumlah</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;">Lokasi</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;">Masa Pakai</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;">Status</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($laporan) && !empty($laporan)): ?>
                                <?php foreach ($laporan as $item): ?>
                                    <tr>
                                        <td><?php echo $item->id_pemakaian; ?></td>
                                        <td><?php echo $item->no_inventori; ?></td>
                                        <td><?php echo $item->tanggal; ?></td>
                                        <td><?php echo $item->nama_barang; ?></td>
                                        <td><?php echo $item->jenis_barang; ?></td>
                                        <td><?php echo $item->jumlah; ?></td>
                                        <td><?php echo $item->lokasi_barang; ?></td>
                                        <td><?php echo $item->masa_pakai; ?></td>
                                        <td><?php echo $item->status; ?></td>
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