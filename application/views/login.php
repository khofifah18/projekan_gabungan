<body class="bg-gradient-primary">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Selamat Datang</h1>
                                    </div>
                                    <?php if ($this->session->flashdata('error')): ?>
                                        <div class="alert alert-danger">
                                            <?php echo $this->session->flashdata('error'); ?>
                                        </div>
                                    <?php endif; ?>
                                    <form class="user" method="post" action="<?php echo base_url() . 'login/login_aksi'; ?>">
                                        <div class="form-group">
                                            <label>Username</label>
                                            <input type="text" class="form-control form-control-user" id="username" name="username"
                                                value="<?= set_value('username'); ?>" placeholder="Masukan Username">
                                            <?= form_error('username', '<div class="text-small text-danger">', '</div>'); ?>
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Masukan password">
                                            <?= form_error('password', '<div class="text-small text-danger">', '</div>'); ?>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>