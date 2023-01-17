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
                                        <?php if (!empty($penguji)) : ?>
                                            <?php
                                            $no = 1 + ($numberPage * ($currentPage - 1));
                                            foreach ($penguji as $lks) : ?>
                                                <tr>
                                                    <td style="text-align:center" scope="row"><?= $no++; ?></td>
                                                    <td><?= $lks->setDeskripsi; ?></td>
                                                    <td>
                                                        <span data-toggle="modal" data-target="#detail<?= $lks->setId; ?>" class="text-primary" style="cursor:pointer">Lihat Detail</span>
                                                    </td>
                                                    <td><?= $lks->setJumlahStation; ?> (<?= ($lks->setStationRest == null) ? '0' : count(json_decode($lks->setStationRest)); ?> Station Rest)</td>
                                                    <td><?= $lks->setStartDate; ?></td>
                                                    <td style="text-align:center">
                                                        <button class="btn btn-icon icon-left btn-info" onclick="<?= 'getPenguji(' . $lks->setId . ')' ?>"><i class="fas fa-users"></i> Set Penguji</button>
                                                        <button class="btn btn-icon icon-left btn-success" onclick="<?= 'cetakPenguji(' . $lks->setId . ')' ?>"><i class="fas fa-print"></i> Cetak Penguji</button>
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

<!-- start modal edit  -->
<div class="modal fade" role="dialog" id="editPenguji">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data <?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="simpanstation" action="" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="_method" value="PUT">
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
                            <tbody class='datastation'></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br" id="btnFooter">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal edit -->

<!-- start modal cetak  -->
<div class="modal fade" role="dialog" id="cetakPenguji">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cetak Data <?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="dataCetakPenguji">
            </div>
            <form id="formCetakPenguji" action="" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="_method" value="PUT">
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Print</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal cetak -->

<!-- start modal detail  -->
<?php foreach ($penguji as $detail) : ?>
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
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- end modal detail -->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>