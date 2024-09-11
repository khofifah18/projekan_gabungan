<div class="container-fluid">
    <div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-0">
            <h1 class="h3 mb-0 text-gray-800" style="color: black; font-weight: bold;">Daftar Penyusutan Barang</h1>
        </div>
        <br>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Barang Yang Sudah Habis Masa Pakai</h6>
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
                                        <td><?php echo $item['no_inventori']; ?></td>
                                        <td><?php echo $item['nama_barang']; ?></td>
                                        <td><?php echo $item['jenis_barang']; ?></td>
                                        <td><?php echo isset($item['qty']) ? $item['qty'] : (isset($item['jumlah']) ? $item['jumlah'] : ''); ?></td>
                                        <td><?php echo $item['tanggal']; ?></td>
                                        <td><?php echo $item['masa_pakai']; ?></td>
                                        <td><?php echo $item['status']; ?></td>
                                        <td><?php echo $item['lokasi_barang']; ?></td>
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
</div>