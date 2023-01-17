<?= $this->extend($config->viewLayout) ?>
<?= $this->section('main') ?>

<div id="app">
	<section class="section">
		<div class="container mt-5">
			<div class="row">
				<div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
					<div class="login-brand mb-5">
						<img src="<?= base_url() ?>/assets/img/logo-fk.png" alt="logo" width="250">
					</div>

					<div class="card card-primary">
						<div class="card-header">
							<h4><?= lang('Auth.loginTitle') ?></h4>
						</div>

						<div class="card-body">
							<?= view('\Modules\Login\Views\_message_block') ?>
							<p class="text-muted">Before you get started, you must login or register if you don't already have an account.</p>
							<form action="<?= route_to('login') ?>" method="post">
								<?= csrf_field() ?>
								<?php if ($config->validFields === ['email']) : ?>
									<div class="form-group">
										<label for="email"><?= lang('Auth.email') ?></label>
										<input id="email" type="email" class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" name="login" placeholder="<?= lang('Auth.email') ?>" name="email" tabindex="1">
										<div class="invalid-feedback">
											<?= session('errors.login') ?>
										</div>
									</div>
								<?php else : ?>
									<div class="form-group">
										<label for="email">Email</label>
										<input id="email" type="text" class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" name="login" placeholder="<?= lang('Auth.emailOrUsername') ?>" name="email" tabindex="1">
										<div class="invalid-feedback">
											<?= session('errors.login') ?>
										</div>
									</div>
								<?php endif; ?>

								<div class="form-group">
									<div class="d-block">
										<label for="password" class="control-label"><?= lang('Auth.password') ?></label>
										<?php if ($config->activeResetter) : ?>
											<div class="float-right">
												<a href="<?= route_to('forgot') ?>" class="text-small">
													<?= lang('Auth.forgotYourPassword') ?>
												</a>
											</div>
										<?php endif; ?>
									</div>
									<input id="password" type="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" name="password" tabindex="2" placeholder="<?= lang('Auth.password') ?>">
									<div class="invalid-feedback">
										<?= session('errors.password') ?>
									</div>
								</div>

								<?php if ($config->allowRemembering) : ?>
									<div class="form-group">
										<div class="custom-control custom-checkbox">
											<input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me" <?php if (old('remember')) : ?> checked <?php endif ?>>
											<label class="custom-control-label" for="remember-me"><?= lang('Auth.rememberMe') ?></label>
										</div>
									</div>
								<?php endif; ?>

								<!-- <div class="form-group">
									<label class="custom-switch pl-0">
										<input type="checkbox" name="typecredential" class="custom-switch-input">
										<span class="custom-switch-indicator"></span>
										<span class="custom-switch-description">Login as Penguji</span>
									</label>
								</div> -->
								<div class="form-group">
									<button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
										<?= lang('Auth.loginAction') ?>
									</button>
								</div>
							</form>
							<div class="form-group">
								<a href="/pengawas" type="button" class="btn btn-danger btn-lg btn-block" tabindex="4">
									Halaman pengawas
								</a>
							</div>
						</div>
					</div>
					<?php if ($config->allowRegistration) : ?>
						<div class="mt-5 text-muted text-center">
							Don't have an account? <a href="<?= route_to('register') ?>">Create One</a>
						</div>
					<?php endif; ?>
					<div class="simple-footer">
						Copyright &copy; 2022 UMSU
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<?= $this->endSection() ?>