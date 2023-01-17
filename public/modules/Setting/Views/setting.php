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
                            <?php if ($validation->hasError('setDeskripsi')) : ?>
                                <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', $validation->getError('setDeskripsi')]]); ?>
                            <?php endif; ?>
                            <?php if ($validation->hasError('jmlStation')) : ?>
                                <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', $validation->getError('jmlStation')]]); ?>
                            <?php endif; ?>
                            <?php if ($validation->hasError('tanggalMulai')) : ?>
                                <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', $validation->getError('tanggalMulai')]]); ?>
                            <?php endif; ?>
                            <?php if (!empty(session()->getFlashdata('error'))) : ?>
                                <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-check', 'Gagal!', session()->getFlashdata('error')]]); ?>
                            <?php endif; ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center" scope="col" width="5%">No.</th>
                                            <th scope="col">Nama Setting</th>
                                            <th scope="col">Lokasi</th>
                                            <th scope="col">Jumlah Station</th>
                                            <th scope="col">Waktu Mulai</th>
                                            <th width="30%" style="text-align:center" scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($setting)) : ?>
                                            <?php
                                            $no = 1 + ($numberPage * ($currentPage - 1));
                                            foreach ($setting as $lks) : ?>
                                                <tr>
                                                    <td style="text-align:center" scope="row"><?= $no++; ?></td>
                                                    <td><?= $lks->setDeskripsi; ?></td>
                                                    <td>
                                                        <span data-toggle="modal" data-target="#detail<?= $lks->setId; ?>" class="text-primary" style="cursor:pointer">Lihat Detail</span>
                                                    </td>
                                                    <td><?= $lks->setJumlahStation; ?> (<?= ($lks->setStationRest == null) ? '0' : count(json_decode($lks->setStationRest)); ?> Station Rest)</td>
                                                    <td><?= $lks->setStartDate; ?></td>
                                                    <td style="text-align:center">
                                                        <button class="btn btn-icon icon-left btn-info" data-toggle="modal" data-target="#edit<?= $lks->setId; ?>"><i class="fas fa-edit"></i></button>
                                                        <button class="btn btn-icon icon-left btn-success" data-toggle="modal" data-target="#genStation<?= $lks->setId; ?>"><i class="fas fa-cog"></i></button>
                                                        <button class="btn btn-icon icon-left btn-warning" data-toggle="modal" data-target="#genPertanyaan<?= $lks->setId; ?>"><i class="fas fa-question"></i></button>
                                                        <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#delete<?= $lks->setId; ?>"><i class="fas fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
                                        <?php else : ?>
                                            <?= view('layout/templateEmpty', ['jumlahSpan' => 6]); ?>
                                        <?php endif ?>
                                    </tbody>
                                </table>
                                <?= $pager->links('set', 'pager') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- start modal tambah  -->
<div class="modal fade" role="dialog" id="tambah">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data <?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/setting" method="post">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Setting</label>
                        <input name="setDeskripsi" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="d-block">Lokasi</label>
                        <?php foreach ($lokasi as $key => $lok) : ?>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" name="lokasi[]" id="inlineCheckbox<?= $lok->lokasiId ?>" value="<?= $lok->lokasiId ?>">
                                <label class="custom-control-label" for="inlineCheckbox<?= $lok->lokasiId ?>"><?= $lok->lokasiNama ?></label>
                            </div>
                        <?php endforeach ?>
                    </div>
                    <div class="form-group">
                        <label>Jumlah Station</label>
                        <input name="jmlStation" type="number" class="form-control">
                    </div>
                    <div class="form-group">
                        <label style="display: inline-block; padding-left: 0 !important;" class="custom-switch mt-2">
                            <input type="checkbox" name="cekRest" class="custom-switch-input" onchange="stationRest()">
                            <span class="custom-switch-indicator"></span>
                        </label>
                        <label>Station Rest</label>
                    </div>
                    <div class="form-group" id="stationRest">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Mulai</label>
                        <input type="datetime-local" class="form-control" name="tanggalMulai">
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

<!-- start modal detail  -->
<?php foreach ($setting as $detail) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="detail<?= $detail->setId ?>">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail <?= $detail->setDeskripsi ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php $data = getDetailSet($detail->setId); ?>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="text-align:center" scope="col" width="5%">No.</th>
                                    <th scope="col">Nama Lokasi</th>
                                    <th scope="col">Nama Station</th>
                                    <th scope="col">Penguji</th>
                                    <th scope="col">Peserta / Station Awal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($data) > 0) : ?>
                                    <?php
                                    $no = 1;
                                    foreach ($data as $dt) : ?>
                                        <tr>
                                            <td class="<?= ($dt->stationStatus == 'Rest') ? 'text-danger' : ''; ?>"><?= $no++ ?></td>
                                            <td class="<?= ($dt->stationStatus == 'Rest') ? 'text-danger' : ''; ?>"><?= $dt->lokasiNama; ?></td>
                                            <td class="<?= ($dt->stationStatus == 'Rest') ? 'text-danger' : ''; ?>"><?= $dt->stationNama; ?></td>
                                            <td class="<?= ($dt->penguji == null || $dt->stationStatus == 'Rest') ? 'text-danger' : ''; ?>"><?= ($dt->penguji == null) ? 'Belum disetting' : getDosenNama($dt->penguji); ?></td>
                                            <td class="<?= ($dt->mahasiswa == null || $dt->stationStatus == 'Rest') ? 'text-danger' : ''; ?>"><?= ($dt->mahasiswa == null) ? 'Belum disetting' : getMahasiswaNama($dt->mahasiswa); ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <?= view('layout/templateEmpty', ['jumlahSpan' => 5]); ?>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class=" modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- end modal detail -->

<!-- start modal edit  -->
<?php foreach ($setting as $edit) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="edit<?= $edit->setId ?>">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data <?= $title ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/setting/<?= $edit->setId ?>" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="_method" value="PUT">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Setting</label>
                            <input name="setDeskripsi" type="text" class="form-control" value="<?= $edit->setDeskripsi ?>">
                        </div>
                        <?php if ($edit->setStationRest != null) : ?>
                            <?php $jmlSt = $edit->setJumlahStation ?>
                            <?php $stRest = json_decode($edit->setStationRest) ?>
                            <div class="form-group">
                                <label class="form-label">Leokasi Station Rest</label>
                                <div class="selectgroup selectgroup-pills">
                                    <?php for ($i = 1; $i <= $jmlSt; $i++) : ?>
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="stationRest[]" value="<?= $i ?>" class="selectgroup-input" <?= (in_array($i, $stRest)) ? 'checked' : '' ?>>
                                            <span class="selectgroup-button">Station <?= $i ?></span>
                                        </label>
                                    <?php endfor ?>
                                </div>
                            </div>
                        <?php endif ?>
                        <div class="form-group">
                            <label>Waktu Mulai</label>
                            <input name="tanggalMulai" type="text" class="form-control" value="<?= $edit->setStartDate ?>">
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- end modal edit -->

<!-- start modal hapus  -->
<?php foreach ($setting as $hapus) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="delete<?= $hapus->setId; ?>">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Konfirmasi</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah kamu benar ingin menghapus data <strong><?= $hapus->setDeskripsi; ?></strong>?</p>
                    <p class="text-warning"><small>This action cannot be undone</small></p>
                </div>
                <form action="/setting/<?= $hapus->setId; ?>" method="post">
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

<!-- start modal generate station  -->
<?php foreach ($setting as $gen) : ?>
    <div class="modal fade" role="dialog" id="genStation<?= $gen->setId; ?>">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Generate <strong>Station</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah kamu benar ingin mengenerate <?= ($gen->setStation != null) ? '<strong>ulang</strong>' : '' ?> station untuk <strong><?= $gen->setDeskripsi; ?></strong>?</p>
                    <p class="text-warning"><small>This action cannot be undone</small></p>
                </div>
                <form action="/setting/genstation/<?= $gen->setId; ?>" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="_method" value="PUT">
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- end modal generate station -->

<!-- start modal generate pertanyaan  -->
<?php foreach ($setting as $genP) : ?>
    <div class="modal fade" role="dialog" id="genPertanyaan<?= $genP->setId; ?>">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Generate<strong> Pertanyaan</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah kamu benar ingin mengenerate <?= ($gen->setPertanyaan != null) ? '<strong>ulang</strong>' : '' ?> pertanyaan untuk <strong><?= $genP->setDeskripsi; ?></strong>?</p>
                    <p class="text-warning"><small>This action cannot be undone</small></p>
                </div>
                <form action="/setting/genpertanyaan/<?= $genP->setId; ?>" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="_method" value="PUT">
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- end modal generate pertanyaan -->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>