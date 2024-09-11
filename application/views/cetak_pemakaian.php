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
                    Laporan Barang Terpakai
                </h1>
            </div>
            <br>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <td style="color: black; font-weight: bold;">No</td>
                                <td style="color: black; font-weight: bold;">Id Pemakaian</td>
                                <td style="color: black; font-weight: bold;">No Inventori</td>
                                <td style="color: black; font-weight: bold;">Tgl Pemakaian</td>
                                <td style="color: black; font-weight: bold;">Nama Barang</td>
                                <td style="color: black; font-weight: bold;">Jenis Barang</td>
                                <td style="color: black; font-weight: bold;">Jumlah</td>
                                <td style="color: black; font-weight: bold;">Lokasi</td>
                                <td style="color: black; font-weight: bold;">Masa Pakai</td>
                                <td style="color: black; font-weight: bold;">Status</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            if (isset($laporan) && !empty($laporan)): ?>
                                <?php foreach ($laporan as $item): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
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
                    <div class="print-only" style="text-align: right; margin-top: 20px;">
                        <p style="font-size: 16px;">
                            Aplikasi: <strong>Inventori</strong><br>
                            Username: <strong><?= $this->session->userdata('username'); ?></strong>
                        </p>
                    </div>
                    <div class="no-print">
                        <a href="<?php echo base_url('laporan_pemakaian') ?>" class="btn btn-secondary"><i class="fas fa-chevron-left"></i> Kembali</a>
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