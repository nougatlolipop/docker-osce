<?= $this->extend('layout/templatePenilaian'); ?>

<?= $this->section('content'); ?>

<!-- Main Content -->
<div class="main-content" style="padding-left:30px !important">
    <section class="section">
        <div class="section-header">
            <?php if (count($peserta) > 0) : ?>
                <h1><?= $title ?></h1>
            <?php endif ?>
        </div>
        <div class="section-body">
            <div class="card">
                <?php if (count($peserta) > 0) : ?>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#home2" role="tab" aria-controls="home" aria-selected="true">Form Penilaian</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#profile2" role="tab" aria-controls="profile" aria-selected="false">Instruksi Penilaian</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="contact-tab2" data-toggle="tab" href="#contact2" role="tab" aria-controls="contact" aria-selected="false">Rubrik Penilaian</a>
                            </li>
                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade show active" id="home2" role="tabpanel" aria-labelledby="home-tab2">
                                <div class="row">
                                    <div class="col-3 mt-0">
                                        <div class="row ">
                                            <div class="col-12">
                                                <div class="card profile-widget mt-4">
                                                    <div class="profile-widget-header">
                                                        <img alt="image" src="<?= getFullUrlFromNpm($peserta[0]->mahasiswaNpm) ?>" class="rounded-circle profile-widget-picture border myimg">
                                                    </div>
                                                    <div class="profile-widget-description pb-0">
                                                        <ul class="list-group">
                                                            <li class="list-group-item"><?= $peserta[0]->mahasiswaNama ?></li>
                                                            <li class="list-group-item"><?= $peserta[0]->mahasiswaNpm ?></li>
                                                            <li class="list-group-item"><?= $peserta[0]->lokasiNama ?> / <?= $peserta[0]->stationNama ?></li>
                                                            <li class="list-group-item <?= ($peserta[0]->kehadiran == 1) ? "text-success" : "text-danger" ?>"><?= ($peserta[0]->kehadiran == 1) ? "Mahasiswa Hadir" : "Mahasiswa Tidak Hadir" ?></li>
                                                        </ul>
                                                    </div>
                                                    <div class="card-footer text-center">
                                                        <?php if ($filePendukung != null || $filePendukung != "") : ?>
                                                            <button onclick="window.open('/filePendukung','name','width=1024,height=768')" class="btn btn-success btn-block"><i class="fas fa-share"></i> Bagikan File Pendukung</button>
                                                        <?php endif ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class=" card-header">
                                                        <h4>Data Semua Peserta</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <ul class="list-unstyled user-progress list-unstyled-border list-unstyled-noborder">
                                                            <?php $no = 1;
                                                            foreach ($pesertaAll as $key => $mhs) : ?>
                                                                <li class="media">
                                                                    <label class="m-3"><?= $no++ ?>.</label>
                                                                    <img alt="image" class="mr-3 rounded-circle myimg2 border" width="50" src="<?= getFullUrlFromNpm($mhs->mahasiswaNpm) ?>">
                                                                    <div class="media-body">
                                                                        <div class="media-title"><?= $mhs->mahasiswaNama ?></div>
                                                                        <div class="text-job text-muted"><?= $mhs->mahasiswaNpm ?></div>
                                                                    </div>
                                                                </li>
                                                            <?php endforeach ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-9 mt-4">
                                        <div class="card">
                                            <form action="/penilaian/save" id="penilaianSave" method="post">
                                                <?= csrf_field(); ?>
                                                <input type="hidden" name="mahasiswaNpm" value="<?= $peserta[0]->mahasiswaNpm ?>">
                                                <div class=" card-header">
                                                    <h4>Skenario</h4>
                                                </div>
                                                <div class="card-body">
                                                    <?= $skenario[0]->skenario ?>
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th style="text-align:center" scope="col" width="5%">No.</th>
                                                                    <th scope="col" rowspan="2">Kompetensi</th>
                                                                    <th width="70%" style="text-align:center" scope="col" colspan="4">Nilai</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php if (!empty($skenario)) : ?>
                                                                    <?php
                                                                    $no = 1;
                                                                    foreach ($skenario as $scane) : ?>
                                                                        <?php if ($scane->pertanyaan != null) : ?>
                                                                            <tr class='rowNilai'>
                                                                                <td style="text-align:center" scope="row"><?= $no++; ?></td>
                                                                                <td><?= $scane->kompetensiNama; ?></td>
                                                                                <?php for ($i = 0; $i <= 3; $i++) : ?>
                                                                                    <td style="text-align:center">
                                                                                        <div class="selectgroup selectgroup-pills">
                                                                                            <label class="selectgroup-item">
                                                                                                <input type="radio" name="nilai,<?= $scane->kompetensiId ?>" value="<?= $i ?>" class="selectgroup-input nilai" <?= ($peserta[0]->kehadiran == 1) ? "" : "disabled" ?>>
                                                                                                <span class="selectgroup-button" style="padding:0 0rem !important; height: 2.4rem !important"><?= $i ?></span>
                                                                                            </label>
                                                                                        </div>
                                                                                    </td>
                                                                                <?php endfor ?>
                                                                            </tr>
                                                                        <?php endif ?>
                                                                    <?php endforeach ?>
                                                                <?php else : ?>
                                                                    <?= view('layout/templateEmpty', ['jumlahSpan' => 4]); ?>
                                                                <?php endif ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th width="70%" style="text-align:center" scope="col">Global Ratting Scale</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td width="70%" style="text-align:center" scope="col">
                                                                        <div class="selectgroup w-100">
                                                                            <?php foreach ($globalrate as $idx => $gr) : ?>
                                                                                <label class="selectgroup-item">
                                                                                    <input type="radio" name="gr" value="<?= $gr['nilai'] ?>" class="selectgroup-input nilai-gr">
                                                                                    <span class="selectgroup-button"><?= $gr['title'] ?></span>
                                                                                </label>
                                                                            <?php endforeach ?>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="card-footer text-right">
                                                    <label style="display: inline-block; padding-left: 0 !important;" class="custom-switch mr-5">
                                                        <input type="hidden" name="kehadiran" value="<?= ($peserta[0]->kehadiran == 1) ? "" : "absen" ?>">
                                                        <input type="checkbox" name="setKehadiran" value="absen" onchange="peringatan()" <?= ($peserta[0]->kehadiran == 1) ? "" : "checked disabled" ?> class="custom-switch-input ">
                                                        <span class="custom-switch-indicator mb-1"></span>
                                                        Tidak Hadir
                                                    </label>
                                                    <button type="button" name="konfirmasi" class="btn btn-primary" onclick="konfirmasiSimpan()" value="<?= ($peserta[0]->kehadiran == 1) ? "save" : "next" ?>"><?= ($peserta[0]->kehadiran == 1) ? "Kirim Nilai" : "Peserta Selanjutnya" ?></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile2" role="tabpanel" aria-labelledby="profile-tab2">
                                <?php if ($instruksi !== null) : ?>
                                    <embed type="application/pdf" src="<?= base_url($instruksi) ?>" width="100%" height="768"></embed>
                                <?php else : ?>
                                    <lottie-player src="https://assets7.lottiefiles.com/packages/lf20_cemdwswi.json" background="transparent" speed="1" style="width: 100%; height: 500px;" loop autoplay></lottie-player>
                                <?php endif ?>
                            </div>
                            <div class="tab-pane fade" id="contact2" role="tabpanel" aria-labelledby="contact-tab2">
                                <?php if ($rubrik !== null) : ?>
                                    <embed type="application/pdf" src="<?= base_url($rubrik) ?>" width="100%" height="768"></embed>
                                <?php else : ?>
                                    <lottie-player src="https://assets7.lottiefiles.com/packages/lf20_cemdwswi.json" background="transparent" speed="1" style="width: 100%; height: 500px;" loop autoplay></lottie-player>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
            </div>
        <?php else : ?>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <?php $gradeDetail = json_decode($grade[0]->gradeNilai); ?>
                        <?php $span = count($kompetensi); ?>
                        <thead>
                            <tr>
                                <th class="text-center" scope="col" rowspan="2" width="20%" colspan="3"><?= $testNama; ?></th>
                                <th class="text-center" scope="col" rowspan="2">GR</th>
                                <th class="text-center" scope="col" colspan="<?= $span ?>">Station <?= $station ?></th>
                                <th class="text-center" scope="col" rowspan="2">AM</th>
                                <th class="text-center" scope="col" rowspan="2"></th>
                            </tr>
                            <tr>
                                <?php foreach ($kompetensi as $dtKompetensi) : ?>
                                    <th class="text-center" scope="col"><?= $dtKompetensi->kompetensiSingkatan; ?></th>
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
                                    <td class="text-center">
                                        <?= getGradeGr($dtGrade->gradeNilai, $station) ?>
                                    </td>
                                    <?php $akhir = []; ?>
                                    <?php $max = []; ?>
                                    <?php foreach ($kompetensi as $dtKompetensi) : ?>
                                        <td class="text-center">
                                            <?= $nilai = getGrade($dtGrade->gradeNilai, $station, $dtKompetensi->kompetensiId, 'nilai'); ?>
                                            <?php $nilaiMax = getGrade($dtGrade->gradeNilai, $station, $dtKompetensi->kompetensiId, 'nilaiMax'); ?>
                                            <?php $bobot = getBobot($testPertanyaan, $station, $dtKompetensi->kompetensiId) ?>
                                            <?php $hasil = $nilai * $bobot; ?>
                                            <?php $nilaiT = $nilaiMax * $bobot; ?>
                                            <?php array_push($akhir, $hasil); ?>
                                            <?php array_push($max, $nilaiT); ?>
                                        </td>
                                    <?php endforeach ?>
                                    <?php $persen = (array_sum($akhir) == 0) ? 0 : (array_sum($akhir) / array_sum($max)) * 100; ?>
                                    <?php $am = array_sum($akhir) ?>
                                    <td class="text-center"><?= $am ?></td>
                                    <td class="text-center"><?= round($persen, 2); ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif ?>
        </div>
    </section>
</div>

<div class="modal fade" role="dialog" id="peringatan">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong>Peringatan</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Mengaktifkan <strong>Tidak Hadir</strong> akan menghapus semua penilaian</p>
                <p class="text-warning"><small>Aksi ini tidak bisa dikembalikan lagi</small></p>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" onclick="batalAbsen()" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="setujuiAbsen()" data-dismiss="modal">Setujui</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="konfirmasi">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong>Konfirmasi</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah anda yakin untuk menyimpan nilai ini?</p>
                <p class="text-warning"><small>Aksi ini tidak bisa dikembalikan lagi</small></p>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="setujuiSimpan()" data-dismiss="modal">Setujui</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="reminder">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong>Peringatan</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Masih ada form penilaian yang belum diisi</p>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?= view('layout/templateFooterPenilaian'); ?>

<?= $this->endSection(); ?>