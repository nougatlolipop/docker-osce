<?= $this->extend('layout/templatePenilaian'); ?>

<?= $this->section('content'); ?>

<!-- Main Content -->
<div class="main-content" style="padding-left:30px !important">
    <section class="section">
        <div class="section-header">
            <h1><?= $title ?></h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <embed type="application/pdf" src="<?= base_url($file) ?>" width="100%" height="768"></embed>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?= view('layout/templateFooterPenilaian'); ?>

<?= $this->endSection(); ?>