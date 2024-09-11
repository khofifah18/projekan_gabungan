<div class="container-fluid">
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-0">
            <h1 class="h3 mb-0 text-gray-800" style="color: black; font-weight: bold;">Laporan Barang Masuk</h1>
        </div>
        <br>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <a href="<?php echo base_url('laporan_barang_masuk/cetak?start_date=' . $this->input->get('start_date') . '&end_date=' .
                                        $this->input->get('end_date')); ?>" class="btn btn-info btn-sm">
                            <i class="fas fa-print"></i> Cetak
                        </a>
                    </h6>
                    <!-- Form Filter -->
                    <form method="get" action="<?php echo base_url('laporan_barang_masuk/filter'); ?>" class="form-inline">
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
                                <td class="bg-primary" style="color: white; font-weight: bold;" width="13%">Id Barang Masuk</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;" width="11%">No Inventori</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;">Tanggal Masuk</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;">Nama Barang</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;">Jenis Barang</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;" width="5%">Jumlah</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;" width="10%">Masa Pakai</td>
                                <td class="bg-primary" style="color: white; font-weight: bold;">Status</td>                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($laporan) && !empty($laporan)): ?>
                                <?php foreach ($laporan as $lp): ?>
                                    <tr>
                                        <td><?php echo $lp->id_barang_masuk; ?></td>
                                        <td><?php echo $lp->no_inventori; ?></td>
                                        <td><?php echo $lp->tanggal; ?></td>
                                        <td><?php echo $lp->nama_barang; ?></td>
                                        <td><?php echo $lp->jenis_barang; ?></td>
                                        <td><?php echo $lp->qty; ?></td>
                                        <td><?php echo $lp->masa_pakai; ?></td>
                                        <td><?php echo $lp->status; ?></td>                                        
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
<!-- <script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        "order": [[0, 'desc']], // Mengurutkan berdasarkan kolom pertama (index 0) dalam urutan menurun
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo site_url('laporan_barang_masuk/index'); ?>",
            "type": "POST"
        }
    });
});
</script> -->