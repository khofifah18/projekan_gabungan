<!-- Begin Page Content -->
<div class="container-fluid">
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Barang Masuk Card Example -->
        <div class="col-xl-4 col-md-4 mb-4">
            <a href="<?php echo base_url('barang_masuk') ?>" style="text-decoration: none;">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1" style="font-size: 15px;">
                                    Total Barang Masuk</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 24px;">
                                    <?php echo $total_masuk; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-truck fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>


        <!-- Barang Dipakai Card Example -->
        <div class="col-xl-4 col-md-4 mb-4">
            <a href="<?php echo base_url('pemakaian') ?>" style="text-decoration: none;">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1" style="font-size: 15px;">
                                    Total Barang Dipakai</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 24px;">
                                    <?php echo $total_pemakaian; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-wrench fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

        <!-- Barang Nonaktif Card Example -->
        <div class="col-xl-4 col-md-4 mb-4">
            <a href="<?php echo base_url('penyusutan') ?>" style="text-decoration: none;">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1" style="font-size: 15px;">
                                    Total Barang Nonaktif</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 24px;">
                                    <?php echo $total_penyusutan; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar-times fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <div class="container-fluid">
            <div class="row">
                <!-- Grafik Barang Masuk 1 -->
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                <a href="<?php echo base_url('barang_masuk') ?>" style="text-decoration: none;">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" >
                            <h6 class="m-0 font-weight-bold text-primary">Barang Masuk Overview</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-area" style="height: 400px; width: 100%;">
                                <canvas id="barangChart1" style="height: 100%; width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grafik Barang Masuk 2 -->
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                <a href="<?php echo base_url('pemakaian') ?>" style="text-decoration: none;">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Barang Pemakaian Overview</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-area" style="height: 400px; width: 100%;">
                                <canvas id="barangChart2" style="height: 100%; width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grafik Barang Nonaktif -->
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">

                <a href="<?php echo base_url('penyusutan') ?>" style="text-decoration: none;">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Barang Nonaktif Overview</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-area" style="height: 400px; width: 100%;">
                                <canvas id="barangChart3" style="height: 100%; width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Grafik Barang Masuk 1
            var ctx1 = document.getElementById("barangChart1").getContext('2d');
            var myChart1 = new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: [<?php foreach ($barang_data as $data) {
                                    echo '"' . $data->nama_barang . '",';
                                } ?>],
                    datasets: [{
                        label: 'Jumlah Barang Masuk',
                        data: [<?php foreach ($barang_data as $data) {
                                    echo $data->jumlah . ',';
                                } ?>],
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Grafik Barang Masuk 2
            var ctx2 = document.getElementById("barangChart2").getContext('2d');
            var myChart2 = new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: [<?php foreach ($pemakaian_data as $data) {
                                    echo '"' . $data->nama_barang . '",';
                                } ?>],
                    datasets: [{
                        label: 'Jumlah Barang Dipakai',
                        data: [<?php foreach ($pemakaian_data as $data) {
                                    echo $data->jumlah . ',';
                                } ?>],
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Grafik Barang Nonaktif
            var ctx3 = document.getElementById('barangChart3').getContext('2d');
            var barangChart3 = new Chart(ctx3, {
                type: 'bar',
                data: {
                    labels: [<?php echo '"' . implode('","', $nonaktif_data['labels']) . '"'; ?>],
                    datasets: [{
                        label: 'Jumlah Barang Nonaktif',
                        data: [<?php echo implode(',', $nonaktif_data['data']); ?>],
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>



    </div>
</div>
</div>
