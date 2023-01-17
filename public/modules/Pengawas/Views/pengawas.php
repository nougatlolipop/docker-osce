<?= $this->extend('\Modules\Login\Views\layout') ?>
<?= $this->section('main') ?>

<div id="app">
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                    <div class="login-brand mb-5">
                        <img src="<?= base_url() ?>/assets/img/<?= getGambarApp() ?>" alt="logo" width="250">
                    </div>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h4><?= (session('stationNama')) ? session('stationNama') : lang('Auth.loginTitle') ?></h4>
                            <div class="card-header-form">
                                <a href="<?= (session('statusStation')) ? site_url('/penilaianLogout')  : "#!" ?>" class="btn btn-icon btn-ouline icon-left btn-outline-<?= (session('statusStation')) ? "primary" : "danger" ?>"><i class="fas fa-<?= (session('statusStation')) ? "unlock" : "lock" ?>"></i> <?= (session('statusStation')) ? "Unlocked" : "Locked" ?></a>
                            </div>
                        </div>

                        <div class="card-body">
                            <?= view('\Modules\Login\Views\_message_block') ?>
                            <p class="text-muted">Before you get started, you must login or register if you don't already have an account.</p>
                            <form action="/pengawas" id="frmPengawas" method="post">
                                <?= csrf_field() ?>
                                <div class="form-group">
                                    <input type="hidden" name="kondisiStation" value="<?= (session('statusStation')) ? "aktif" : "non-aktif" ?>">
                                    <input id="password" type="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" name="password" tabindex="2" placeholder="<?= lang('Auth.password') ?>">
                                    <div class="invalid-feedback">
                                        <?= session('errors.password') ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="button" onclick="showQrcode()" class="<?= (session('statusStation')) ? "btn btn-primary" : "btn btn-danger" ?> btn-lg btn-block" tabindex="4">
                                        <i class="fas fa-qrcode"></i> Scan Barcode
                                    </button>
                                </div>
                                <!-- <div class="form-group">
									<label class="custom-switch pl-0">
										<input type="checkbox" name="typecredential" class="custom-switch-input">
										<span class="custom-switch-indicator"></span>
										<span class="custom-switch-description">Login as Penguji</span>
									</label>
								</div> -->
                                <!-- Back -->
                                <div class="form-group">
                                    <p><?= lang('Auth.changeMind') ?> <a href="<?= route_to('login') ?>"><?= lang('Auth.backToLogin') ?></a></p>
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                        <?= (session('statusStation')) ? lang('Auth.loginAction') : "Aktikkan Station" ?>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="simple-footer">
                        Copyright &copy; 2022 UMSU
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" role="dialog" id="qr">
    <div class="modal-dialog modal-dialog-centered modal-m" role="document">
        <div class="modal-content">
            <div class="modal-header">QR Pengawas</div>
            <div class="modal-body">
                <div id="qr-reader"></div>
                <div id="qr-reader-results"></div>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>