<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
    <section class=" section">
        <div class="section-header">
            <h1>Selamat Datang di Aplikasi <?= getNamaApp() ?></h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="#"><?= $breadcrumb[0]; ?></a></div>
                <div class="breadcrumb-item active"><?= $breadcrumb[1]; ?></div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center" style="height: 700px;">
                                <div style="width: 100%; height: 700px; margin-top:100px">
                                    <lottie-player src="<?= base_url() ?>/assets/json/dashboard.json" background="transparent" speed="1" style="width: 100%; height: 500px;" loop autoplay></lottie-player>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>