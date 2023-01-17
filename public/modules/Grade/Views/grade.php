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
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <form action="/grade/proses" method="GET">
                                        <?php csrf_field() ?>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <select class="form-control select2" name="test">
                                                    <option value="">Pilih Test</option>
                                                    <?php foreach ($setting as $row) : ?>
                                                        <option value="<?= $row->setId; ?>" <?= ($row->setId == $dataFilter[0]) ? 'selected' : ''  ?>><?= $row->setDeskripsi; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div style="display: inline-block; margin-top: 4px; margin-left: 5px;" class="buttons">
                                                <button type="submit" class="btn btn-icon icon-left btn-primary"><i class="fas fa-search"></i> Cari</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <?php if ($grade) : ?>
                                    <div class="col-md-2">
                                        <div class="buttons float-right">
                                            <button class="btn btn-icon icon-left btn-primary mt-1" data-toggle="modal" data-target="#cetak"><i class="fas fa-print"></i> Cetak</button>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php if ($validation->hasError('test')) : ?>
                                <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', $validation->getError('test')]]); ?>
                            <?php endif; ?>
                            <?php if (!empty(session()->getFlashdata('success'))) : ?>
                                <?= view('layout/templateAlertIcon', ['msg' => ['success', 'fas fa-check', 'Sukses!', session()->getFlashdata('success')]]); ?>
                            <?php endif; ?>
                            <?php if (!empty(session()->getFlashdata('danger'))) : ?>
                                <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', session()->getFlashdata('danger')]]); ?>
                            <?php endif; ?>
                            <?php if ($grade == null) : ?>
                                <div class="text-center" style="height: 700px;">
                                    <div style="width: 100%; height: 700px;">
                                        <lottie-player src="<?= base_url() ?>/assets/json/hasilPenilaian.json" background="transparent" speed="1" style="width: 100%; height: 600px;" loop autoplay></lottie-player>
                                    </div>
                                </div>
                            <?php else : ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <?php $gradeDetail = json_decode($grade[0]->gradeNilai); ?>
                                        <?php $station = [] ?>
                                        <?php foreach ($gradeDetail->data as $key => $dt) : ?>
                                            <?php array_push($station, $dt->station); ?>
                                        <?php endforeach ?>
                                        <?php $span = count($kompetensi); ?>
                                        <thead>
                                            <tr>
                                                <th class="text-center" scope="col" rowspan="2" width="20%" colspan="3"><?= $testNama; ?></th>
                                                <?php foreach ($gradeDetail->data as $key => $dtDetail) : ?>
                                                    <th class="text-center" scope="col" rowspan="2">GR</th>
                                                    <th class="text-center" scope="col" colspan="<?= $span ?>">Station
                                                        <?php sort($station) ?>
                                                        <?php $jml = count($station) ?>
                                                        <?php for ($i = 0; $i < count($station); $i++) : ?>
                                                            <?= ($i == $key) ? $station[$i] : ''; ?>
                                                        <?php endfor ?>
                                                    </th>
                                                    <th class="text-center" scope="col" rowspan="2">AM</th>
                                                    <th class="text-center" scope="col" rowspan="2"></th>
                                                <?php endforeach ?>
                                                <th class="text-center" scope="col" rowspan="2">Rerata AM</th>
                                            </tr>
                                            <tr>
                                                <?php foreach ($gradeDetail->data as $dtDetail) : ?>
                                                    <?php foreach ($kompetensi as $dtKompetensi) : ?>
                                                        <th class="text-center" scope="col"><?= $dtKompetensi->kompetensiSingkatan; ?></th>
                                                    <?php endforeach ?>
                                                <?php endforeach ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; ?>
                                            <?php foreach ($grade as $dtGrade) : ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= $dtGrade->gradeMahasiswa; ?></td>
                                                    <td class="frezz"><?= getMahasiswaNama($dtGrade->gradeMahasiswa); ?></td>
                                                    <?php $rerata = []; ?>
                                                    <?php foreach ($gradeDetail->data as $key => $dtDetail) : ?>
                                                        <td class="text-center">
                                                            <?php sort($station) ?>
                                                            <?php for ($i = 0; $i < count($station); $i++) : ?>
                                                                <?= ($i == $key) ? getGradeGr($dtGrade->gradeNilai, $station[$i]) : ''; ?>
                                                            <?php endfor ?>
                                                        </td>
                                                        <?php $akhir = []; ?>
                                                        <?php $max = []; ?>
                                                        <?php foreach ($kompetensi as $dtKompetensi) : ?>
                                                            <td class="text-center">
                                                                <?php sort($station) ?>
                                                                <?php for ($i = 0; $i < count($station); $i++) : ?>
                                                                    <?= $nilai = ($i == $key) ? getGrade($dtGrade->gradeNilai, $station[$i], $dtKompetensi->kompetensiId, 'nilai') : ''; ?>
                                                                    <?php $nilaiMax = ($i == $key) ? getGrade($dtGrade->gradeNilai, $station[$i], $dtKompetensi->kompetensiId, 'nilaiMax') : ''; ?>
                                                                    <?php $bobot = ($i == $key) ? getBobot($testPertanyaan, $station[$i], $dtKompetensi->kompetensiId) : '' ?>
                                                                    <?php $hasil = ($i == $key) ? $nilai * $bobot : ''; ?>
                                                                    <?php $nilaiT = ($i == $key) ? $nilaiMax * $bobot : ''; ?>
                                                                    <?php array_push($akhir, $hasil); ?>
                                                                    <?php array_push($max, $nilaiT); ?>
                                                                <?php endfor ?>
                                                            </td>
                                                        <?php endforeach ?>
                                                        <?php $persen = (array_sum($akhir) == 0) ? 0 : (array_sum($akhir) / array_sum($max)) * 100; ?>
                                                        <?php $am = array_sum($akhir) ?>
                                                        <?php array_push($rerata, $am); ?>
                                                        <td class="text-center"><?= $am ?></td>
                                                        <td class="text-center"><?= round($persen, 2); ?></td>
                                                    <?php endforeach ?>
                                                    <?php $rerataT = array_sum($rerata) / $jml ?>
                                                    <td class="text-center"><?= round($rerataT, 2); ?></td>
                                                </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php if ($grade) : ?>
    <!-- start modal cetak -->
    <div class="modal fade" tabindex="-1" role="dialog" id="cetak">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cetak <strong><?= $title; ?></strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah kamu benar ingin mencetak hasil test<strong> <?= $testNama; ?></strong>?</p>
                </div>
                <form action="/grade/cetak" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="test" value="<?= $dataFilter[0] ?>">
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end modal cetak -->
<?php endif ?>

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>