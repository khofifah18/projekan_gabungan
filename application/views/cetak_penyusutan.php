<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url() ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url() ?>assets/css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            .print-header {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                padding: 10px;
                font-size: 14px;
                border-bottom: 1px solid #000;
            }

            @page {
                margin: 0;
                /* Sesuaikan margin jika diperlukan */
            }

            .print-only {
                display: none;
            }

            @media print {
                .print-only {
                    display: block !important;
                }
            }
        }
    </style>

</head>

<body>
    <div class="container-fluid mt-5">
        <div class="container-fluid mt-5">
            <div class="d-sm-flex align-items-center justify-content-center mb-0">
                <p id="current-date" style="position: absolute; top: 10px; left: 10px; font-size: 14px;">Tanggal: </p>
                <h1 class="h4 mb-0 text-gray-800" style="color: black; font-weight: bold; text-align: center; margin-top: 20px;">
                    Laporan Penyusutan Barang
                </h1>
            </div>
            <br>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <td style="color: black; font-weight: bold;">Id</td>
                                <td style="color: black; font-weight: bold;">No Invetori</td>
                                <td style="color: black; font-weight: bold;">Nama Barang</td>
                                <td style="color: black; font-weight: bold;">Jenis Barang</td>
                                <td style="color: black; font-weight: bold;">Jumlah</td>
                                <td style="color: black; font-weight: bold;">Tanggal</td>
                                <td style="color: black; font-weight: bold;">Masa Pakai</td>
                                <td style="color: black; font-weight: bold;">Status</td>
                                <td style="color: black; font-weight: bold;">Lokasi</td>
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
                    <div class="print-only" style="text-align: right; margin-top: 20px;">
                        <p style="font-size: 16px;">
                            Aplikasi: <strong>Inventori</strong><br>
                            Username: <strong><?= $this->session->userdata('username'); ?></strong>
                        </p>
                    </div>
                    <div class="no-print">
                        <a href="<?php echo base_url('laporan_penyusutan') ?>" class="btn btn-secondary"><i class="fas fa-chevron-left"></i> Kembali</a>
                        <button class="btn btn-primary" onclick="window.print()"><i class="fas fa-print">Print</i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo base_url() ?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url() ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url() ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url() ?>assets/js/sb-admin-2.min.js"></script>

    <!-- Print script -->
    <script type="text/javascript">
        window.onload = function() {
            // Set tanggal hari ini
            var today = new Date();
            var day = today.getDate();
            var month = today.getMonth() + 1; // Januari adalah 0
            var year = today.getFullYear();
            var formattedDate = day + '/' + month + '/' + year;

            // Menambahkan tanggal ke elemen
            document.getElementById('current-date').textContent = 'Tanggal: ' + formattedDate;

            // Melakukan print setelah tanggal ditambahkan
            window.print();
        };
    </script>
</body>

</html>