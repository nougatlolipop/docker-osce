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
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus"></i> Tambah Data</button>
                </div>
                <div class="card-body">
                    <?php if (!empty(session()->getFlashdata('success'))) : ?>
                        <?= view('layout/templateAlertIcon', ['msg' => ['success', 'fas fa-check', 'Sukses!', session()->getFlashdata('success')]]); ?>
                    <?php endif; ?>
                    <?php if (!empty(session()->getFlashdata('abort'))) : ?>
                        <?= view('layout/templateAlertIcon', ['msg' => ['success', 'fas fa-check', 'Sukses!', session()->getFlashdata('abort')]]); ?>
                    <?php endif; ?>
                    <?php if ($validation->hasError('dataMahasiswa')) : ?>
                        <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', $validation->getError('dataMahasiswa')]]); ?>
                    <?php endif; ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="2%" style="text-align:center" scope="col">No.</th>
                                    <th scope="col">NPM</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col"></th>
                                </tr>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty(session()->get('dataSession')['dtMahasiswa'])) : ?>
                                    <?php $no = 1;
                                    foreach (session()->get('dataSession')['dtMahasiswa'] as $sync) : ?>
                                        <form action="/mahasiswa/simpan" method="POST">
                                            <tr>
                                                <td style="text-align:center" scope="row"><?= $no++; ?></td>
                                                <td><input type="text" name="mahasiswaNpm[]" class="form-control" value="<?= $sync['mahasiswaNpm']; ?>" readonly></td>
                                                <td><input type="text" name="mahasiswaNama[]" class="form-control" value="<?= $sync['mahasiswaNama']; ?>" readonly></td>
                                                <td style="text-align:center"><input type="hidden" name="mahasiswaAkun[]" class="form-control" id="akun" value="<?= $sync['mahasiswaAkun']; ?>" readonly> <label for="akun" class="<?= ($sync['mahasiswaAkun'] == 'Insert New') ? 'text-success' : ''; ?>"><?= $sync['mahasiswaAkun']; ?></label></td>
                                            </tr>
                                        <?php endforeach ?>
                                    <?php else : ?>
                                        <?= view('layout/templateEmptySession', ['jumlahSpan' => 4]); ?>
                                    <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if (!empty(session()->getFlashdata('counts'))) : ?>
                    <div class="card-footer">
                        <div><span><strong>Insert New: <?= session()->get('counts')['inserted'] ?></strong></span></div>
                        <div><span><strong>No Action: <?= session()->get('counts')['noaction'] ?></strong></span></div>
                    </div>
                <?php endif ?>
                <?php if (!empty(session()->get('dataSession')['dtMahasiswa'])) : ?>
                    <div class="card-footer">
                        <a href="/mahasiswa/batal" type="button" class="btn btn-icon icon-left btn-danger mr-2"><i class="fas fa-trash"></i> Batal</a>
                        <button type="submit" class="btn btn-icon icon-left btn-success"><i class="fas fa-check"></i> Simpan</button>
                    </div>
                <?php endif ?>
                </form>
            </div>
            <div class="card">
                <div class="card-header">
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
                <div class="card-body">
                    <?php if (!empty(session()->getFlashdata('update'))) : ?>
                        <?= view('layout/templateAlertIcon', ['msg' => ['success', 'fas fa-check', 'Sukses!', session()->getFlashdata('update')]]); ?>
                    <?php endif; ?>
                    <?php if (!empty(session()->getFlashdata('danger'))) : ?>
                        <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', session()->getFlashdata('danger')]]); ?>
                    <?php endif; ?>
                    <?php if ($validation->hasError('pengujiNama')) : ?>
                        <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', $validation->getError('pengujiNama')]]); ?>
                    <?php endif; ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="2%" style="text-align:center" scope="col">No.</th>
                                    <th scope="col">NPM</th>
                                    <th scope="col">Nama</th>
                                    <th style="text-align:center" scope="col">Action</th>
                                </tr>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($mahasiswa)) : ?>
                                    <?php
                                    $no = 1 + ($numberPage * ($currentPage - 1));
                                    foreach ($mahasiswa as $data) : ?>
                                        <tr>
                                            <td style="text-align:center" scope="row"><?= $no++; ?></td>
                                            <td><?= $data->mahasiswaNpm; ?></td>
                                            <td><?= $data->mahasiswaNama; ?></td>
                                            <td style="text-align:center">
                                                <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#hapus<?= $data->mahasiswaNpm; ?>"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <?= view('layout/templateEmpty', ['jumlahSpan' => 4]); ?>
                                <?php endif ?>
                            </tbody>
                        </table>
                        <?= $pager->links('mahasiswa', 'pager') ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- start modal tambah -->
<div class="modal fade" tabindex="-1" role="dialog" id="tambah">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data<strong> <?= $title; ?></strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hin="tr-e">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="mahasiswa/tambah" method="POST">
                    <div class="table-responsive">
                        <input type="hidden" name="mahasiswa" value="internal">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="2%" style="text-align:center" scope="col"></th>
                                    <th scope="col">NPM</th>
                                    <th scope="col">Nama</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($apiMahasiswa as $data) : ?>
                                    <tr>
                                        <td style="text-align:center" scope="row">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="check<?= $data->Nim ?>" name="dataMahasiswa[]" value="<?= $data->Nim . "#"  .  $data->Nama_Lengkap   ?>">
                                                <label class="custom-control-label" for="check<?= $data->Nim ?>"></label>
                                            </div>
                                        </td>
                                        <td><?= $data->Nim; ?></td>
                                        <td><?= $data->Nama_Lengkap; ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end modal tambah -->

<!-- start modal hapus  -->
<?php foreach ($mahasiswa as $hapus) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="hapus<?= $hapus->mahasiswaNpm; ?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Konfirmasi</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah kamu benar ingin menghapus data mahasiswa <strong><?= $hapus->mahasiswaNama; ?> <?= $hapus->mahasiswaNpm; ?></strong>?</p>
                    <p class="text-warning"><small>This action cannot be undone</small></p>
                </div>
                <form action="/mahasiswa/hapus/<?= $hapus->mahasiswaNpm; ?>" method="post">
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