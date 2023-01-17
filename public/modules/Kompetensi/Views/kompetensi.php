<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
    <section class=" section">
        <div class="section-header">
            <h1><?= $title; ?></h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="#"><?= $breadcrumb[0]; ?></a></div>
                <div class="breadcrumb-item active"><?= $breadcrumb[1]; ?></div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <button class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus"></i> Tambah Data</button>
                            <h4></h4>
                            <div class="card-header-form">
                                <h4></h4>
                                <div class="card-header-form">
                                    <form action="">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search" name="keyword" value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : "" ?>">
                                            <div class="input-group-btn">
                                                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if (!empty(session()->getFlashdata('success'))) : ?>
                                <?= view('layout/templateAlertIcon', ['msg' => ['success', 'fas fa-check', 'Sukses!', session()->getFlashdata('success')]]); ?>
                            <?php endif; ?>
                            <?php if ($validation->hasError('kompetensiNama')) : ?>
                                <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', $validation->getError('kompetensiNama')]]); ?>
                            <?php endif; ?>
                            <?php if (!empty(session()->getFlashdata('error'))) : ?>
                                <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-check', 'Gagal!', session()->getFlashdata('error')]]); ?>
                            <?php endif; ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center" scope="col" width="5%">No.</th>
                                            <th scope="col">Nama Kompetensi</th>
                                            <th scope="col">Nama Singkat</th>
                                            <th width="20%" style="text-align:center" scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($kompetensi)) : ?>
                                            <?php
                                            $no = 1 + ($numberPage * ($currentPage - 1));
                                            foreach ($kompetensi as $lks) : ?>
                                                <tr>
                                                    <td style="text-align:center" scope="row"><?= $no++; ?></td>
                                                    <td><?= $lks->kompetensiNama; ?></td>
                                                    <td><?= $lks->kompetensiSingkatan; ?></td>
                                                    <td style="text-align:center">
                                                        <button class="btn btn-icon icon-left btn-info" data-toggle="modal" data-target="#edit<?= $lks->kompetensiId; ?>"><i class="fas fa-edit"></i></button>
                                                        <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#delete<?= $lks->kompetensiId; ?>"><i class="fas fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
                                        <?php else : ?>
                                            <?= view('layout/templateEmpty', ['jumlahSpan' => 4]); ?>
                                        <?php endif ?>
                                    </tbody>
                                </table>
                                <?= $pager->links('kompetensi', 'pager') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- start modal tambah  -->
<div class="modal fade" tabindex="-1" role="dialog" id="tambah">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data <?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/kompetensi" method="post">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Kompetensi</label>
                        <input name="kompetensiNama" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Nama Singkatan</label>
                        <input name="kompetensiSingkatan" type="text" class="form-control">
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal tambah -->


<!-- start modal edit  -->
<?php foreach ($kompetensi as $edit) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="edit<?= $edit->kompetensiId ?>">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data <?= $title ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/kompetensi/<?= $edit->kompetensiId ?>" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="_method" value="PUT">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Kompetensi</label>
                            <input name="kompetensiNama" type="text" class="form-control" value="<?= $edit->kompetensiNama ?>">
                        </div>
                        <div class="form-group">
                            <label>Nama Kompetensi</label>
                            <input name="kompetensiSingkatan" type="text" class="form-control" value="<?= $edit->kompetensiSingkatan ?>">
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- end modal edit -->

<!-- start modal hapus  -->
<?php foreach ($kompetensi as $hapus) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="delete<?= $hapus->kompetensiId; ?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Konfirmasi</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah kamu benar ingin menghapus data <strong><?= $hapus->kompetensiNama; ?></strong>?</p>
                    <p class="text-warning"><small>This action cannot be undone</small></p>
                </div>
                <form action="/kompetensi/<?= $hapus->kompetensiId; ?>" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="submit" class="btn btn-danger">Yes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- end modal hapus -->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>