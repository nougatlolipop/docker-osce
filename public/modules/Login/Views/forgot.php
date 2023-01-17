<?= $this->extend($config->viewLayout) ?>
<?= $this->section('main') ?>

<div id="app">
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                    <div class="login-brand mb-5">
                        <a href="/forgot"><img src="<?= base_url() ?>/assets/img/logo-fk.png" alt="logo" width="250"></a>
                    </div>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h4><?= lang('Auth.forgotPassword') ?></h4>
                        </div>

                        <div class="card-body">
                            <?= view('\Modules\Login\Views\_message_block') ?>

                            <p><?= lang('Auth.enterEmailForInstructions') ?></p>
                            <form action="<?= route_to('forgot') ?>" method="post">
                                <?= csrf_field() ?>
                                <div class="form-group">
                                    <label for="email"><?= lang('Auth.emailAddress') ?></label>
                                    <input type="email" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" name="email" aria-describedby="emailHelp" placeholder="<?= lang('Auth.email') ?>">
                                    <div class="invalid-feedback">
                                        <?= session('errors.email') ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <p><?= lang('Auth.changeMind') ?> <a href="<?= route_to('login') ?>"><?= lang('Auth.signIn') ?></a></p>
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                        <?= lang('Auth.sendInstructions') ?>
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

<?= $this->endSection() ?>