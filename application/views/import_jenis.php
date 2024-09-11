<div class="container-fluid ">
    <div class="d-flex justify-content-center mb-4">
        <h3 class="h4 mb-0 text-gray-800" style="color: black; font-weight: bold; text-align: center;">Import Jenis Barang</h3>
    </div>
    <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-2">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <form method="post" enctype="multipart/form-data" action="<?php echo base_url('jenis_barang/aksi_import_jenis'); ?>">
                                    <div class="form-group">
                                        <label for="upload_excel" class="font-weight-bold text-secondary">Pilih File Excel</label>
                                        <br>
                                        <input type="file" name="upload_excel" required>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="start_column" class="font-weight-bold text-secondary">Pilih Kolom Awal (Misal: A)</label>
                                            <input type="text" name="start_column" class="form-control" placeholder="Ketik Kolom Yang Dipilih" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="start_row" class="font-weight-bold text-secondary">Pilih Baris Awal (Misal: 1)</label>
                                            <input type="number" name="start_row" class="form-control" placeholder="Ketik Baris Yang Dipilih" required>
                                        </div>

                                    </div>
                                    <div>
                                        <a href="<?php echo base_url('jenis_barang') ?>" class="btn btn-secondary"><i class="fas fa-chevron-left"></i> Kembali</a>

                                        <button type="submit" class="btn btn-primary">Upload</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>