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
                    <?php if ($validation->hasError('dataDosen')) : ?>
                        <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', $validation->getError('dataDosen')]]); ?>
                    <?php endif; ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="2%" style="text-align:center" scope="col">No.</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Status</th>
                                    <th scope="col"></th>
                                </tr>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty(session()->get('dataSession')['dtDosen'])) : ?>
                                    <?php $no = 1;
                                    foreach (session()->get('dataSession')['dtDosen'] as $sync) : ?>
                                        <form action="/dosen/simpan" method="POST">
                                            <input type="hidden" name="pengujiPegawaiId[]" value="<?= $sync['pengujiPegawaiId']; ?>">
                                            <input type="hidden" name="pengujiId[]" value="<?= $sync['pengujiId']; ?>">
                                            <tr>
                                                <td style="text-align:center" scope="row"><?= $no++; ?></td>
                                                <td><input type="text" name="pengujiNama[]" class="form-control" value="<?= $sync['pengujiNama']; ?>" readonly></td>
                                                <td><input type="text" name="pengujiStatus[]" class="form-control" value="<?= ($sync['pengujiStatus'] == 1) ? 'Internal' : 'Eksternal'; ?>" readonly></td>
                                                <td style="text-align:center"><input type="hidden" name="pengujiAkun[]" class="form-control" id="akun" value="<?= $sync['pengujiAkun']; ?>" readonly> <label for="akun" class="<?= ($sync['pengujiAkun'] == 'Insert New') ? 'text-success' : ''; ?>"><?= $sync['pengujiAkun']; ?></label></td>
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
                <?php if (!empty(session()->get('dataSession')['dtDosen'])) : ?>
                    <div class="card-footer">
                        <a href="/dosen/batal" type="button" class="btn btn-icon icon-left btn-danger mr-2"><i class="fas fa-trash"></i> Batal</a>
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
                                    <th scope="col">Nama</th>
                                    <th scope="col">Status</th>
                                    <th style="text-align:center" scope="col">Action</th>
                                </tr>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($dosen)) : ?>
                                    <?php
                                    $no = 1 + ($numberPage * ($currentPage - 1));
                                    foreach ($dosen as $data) : ?>
                                        <tr>
                                            <td style="text-align:center" scope="row"><?= $no++; ?></td>
                                            <td><?= $data->pengujiNama; ?></td>
                                            <td><?= ($data->pengujiStatus == '1') ? 'Internal' : 'Eksternal'; ?></td>
                                            <td style="text-align:center">
                                                <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#hapus<?= $data->pengujiId; ?>"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <?= view('layout/templateEmpty', ['jumlahSpan' => 4]); ?>
                                <?php endif ?>
                            </tbody>
                        </table>
                        <?= $pager->links('dosen', 'pager') ?>
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
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="dosen-umsu" data-toggle="tab" href="#dosenUmsu" role="tab" aria-controls="dosenUmsu" aria-selected="true">Dosen Internal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="dosen-luar" data-toggle="tab" href="#dosenLuar" role="tab" aria-controls="dosenLuar" aria-selected="false">Dosen Eksternal</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="dosenUmsu" role="tabpanel" aria-labelledby="dosen-umsu">
                        <form action="dosen/tambah/internal" method="POST">
                            <div class="table-responsive">
                                <input type="hidden" name="dosen" value="internal">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="2%" style="text-align:center" scope="col"></th>
                                            <th scope="col">Nama</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($apiDosen as $data) : ?>
                                            <tr>
                                                <td style="text-align:center" scope="row">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="check<?= $data->Employee_Id ?>" name="dataDosen[]" value="<?= $data->Full_Name . "#"  .  $data->Employee_Id   ?>">
                                                        <label class="custom-control-label" for="check<?= $data->Employee_Id ?>"></label>
                                                    </div>
                                                </td>
                                                <td><?= $data->Full_Name; ?></td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <div class="modal-footer bg-whitesmoke br">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="dosenLuar" role="tabpanel" aria-labelledby="dosen-luar">
                        <form action="dosen/tambah/eksternal" method="POST">
                            <input type="hidden" name="dosen" value="eksternal">
                            <div id="dosen">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input name="pengujiNama[]" type="text" class="form-control" required>
                                </div>
                            </div>
                            <button id="tambahPenguji" class="btn btn-block btn-icon icon-left btn-primary mb-3"><i class="fas fa-plus"></i>Tambah Baris</button>
                            <div class="modal-footer bg-whitesmoke br">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end modal tambah -->

<!-- start modal hapus  -->
<?php foreach ($dosen as $hapus) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="hapus<?= $hapus->pengujiId; ?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Konfirmasi</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah kamu benar ingin menghapus data dosen <strong><?= $hapus->pengujiNama; ?></strong>?</p>
                    <p class="text-warning"><small>This action cannot be undone</small></p>
                </div>
                <form action="/dosen/hapus/<?= $hapus->pengujiId; ?>" method="post">
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