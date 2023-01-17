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
                            <?php if (!empty(session()->getFlashdata('success'))) : ?>
                                <?= view('layout/templateAlertIcon', ['msg' => ['success', 'fas fa-check', 'Sukses!', session()->getFlashdata('success')]]); ?>
                            <?php endif; ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <form action="configSet/<?= getConfigSet($configSet, 'getNamaApp')['configId']; ?>" method="POST">
                                        <div class="card card-primary">
                                            <input type="hidden" name="_method" value="PUT">
                                            <input type="hidden" name="configTipe" value="<?= getConfigSet($configSet, 'getNamaApp')['configTipe']; ?>">
                                            <div class="card-header">
                                                <h4><?= getConfigSet($configSet, 'getNamaApp')['configDeskripsi']; ?></h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <input name="configValue" value="<?= getConfigSet($configSet, 'getNamaApp')['configValue']; ?>" type="text" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-primary float-right">Save Changes</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-6">
                                    <form action="configSet/<?= getConfigSet($configSet, 'getGambarApp')['configId']; ?>" method="POST" enctype="multipart/form-data">
                                        <div class="card card-primary">
                                            <input type="hidden" name="_method" value="PUT">
                                            <input type="hidden" name="configTipe" value="<?= getConfigSet($configSet, 'getGambarApp')['configTipe']; ?>">
                                            <input type="hidden" name="gambarLama" value="<?= getConfigSet($configSet, 'getGambarApp')['configValue']; ?>">
                                            <div class="card-header">
                                                <h4><?= getConfigSet($configSet, 'getGambarApp')['configDeskripsi']; ?></h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <div class="custom-file">
                                                        <input name="getGambar" type="file" accept="image/*" class="custom-file-input" value="<?= getConfigSet($configSet, 'getGambarApp')['configValue']; ?>" id="gambarApp" onchange="labelGambarApp()">
                                                        <label class="custom-file-label gambarAppLabel" for="customFile"><?= getConfigSet($configSet, 'getGambarApp')['configValue']; ?></label>
                                                    </div>
                                                </div>
                                                <div style="text-align:center">
                                                    <img src="<?= base_url() ?>/assets/img/<?= getConfigSet($configSet, 'getGambarApp')['configValue'] ?>" alt="gambarApp" id="previewGambarApp" height="70%" width="70%">
                                                </div>
                                            </div>
                                            <div class="card-footer" id="dimGambarApp">
                                                <p><strong>Dimension: 498px X 125px</strong></p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <form action="configSet/<?= getConfigSet($configSet, 'getDosen')['configId']; ?>" method="POST">
                                        <div class="card card-primary">
                                            <input type="hidden" name="_method" value="PUT">
                                            <input type="hidden" name="configTipe" value="<?= getConfigSet($configSet, 'getDosen')['configTipe']; ?>">
                                            <div class="card-header">
                                                <h4><?= getConfigSet($configSet, 'getDosen')['configDeskripsi']; ?></h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <input name="configValue" value="<?= getConfigSet($configSet, 'getDosen')['configValue']; ?>" type="text" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-primary float-right">Save Changes</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-6">
                                    <form action="configSet/<?= getConfigSet($configSet, 'getMahasiswa')['configId']; ?>" method="POST">
                                        <div class="card card-primary">
                                            <input type="hidden" name="_method" value="PUT">
                                            <input type="hidden" name="configTipe" value="<?= getConfigSet($configSet, 'getMahasiswa')['configTipe']; ?>">
                                            <div class="card-header">
                                                <h4><?= getConfigSet($configSet, 'getMahasiswa')['configDeskripsi']; ?></h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <input name="configValue" value="<?= getConfigSet($configSet, 'getMahasiswa')['configValue']; ?>" type="text" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-primary float-right">Save Changes</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <form action="configSet/<?= getConfigSet($configSet, 'getDefaultDosen')['configId']; ?>" method="POST">
                                        <div class="card card-primary">
                                            <input type="hidden" name="_method" value="PUT">
                                            <input type="hidden" name="configTipe" value="<?= getConfigSet($configSet, 'getDefaultDosen')['configTipe']; ?>">
                                            <div class="card-header">
                                                <h4><?= getConfigSet($configSet, 'getDefaultDosen')['configDeskripsi']; ?></h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <input name="configValue" value="<?= getConfigSet($configSet, 'getDefaultDosen')['configValue']; ?>" type="text" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-primary float-right">Save Changes</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-4">
                                    <form action="configSet/<?= getConfigSet($configSet, 'getDefaultMhs')['configId']; ?>" method="POST">
                                        <div class="card card-primary">
                                            <input type="hidden" name="_method" value="PUT">
                                            <input type="hidden" name="configTipe" value="<?= getConfigSet($configSet, 'getDefaultMhs')['configTipe']; ?>">
                                            <div class="card-header">
                                                <h4><?= getConfigSet($configSet, 'getDefaultMhs')['configDeskripsi']; ?></h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <input name="configValue" value="<?= getConfigSet($configSet, 'getDefaultMhs')['configValue']; ?>" type="text" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-primary float-right">Save Changes</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-4">
                                    <form action="configSet/<?= getConfigSet($configSet, 'getNilaiMax')['configId']; ?>" method="POST">
                                        <div class="card card-primary">
                                            <input type="hidden" name="_method" value="PUT">
                                            <input type="hidden" name="configTipe" value="<?= getConfigSet($configSet, 'getNilaiMax')['configTipe']; ?>">
                                            <div class="card-header">
                                                <h4><?= getConfigSet($configSet, 'getNilaiMax')['configDeskripsi']; ?></h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <input name="configValue" value="<?= getConfigSet($configSet, 'getNilaiMax')['configValue']; ?>" type="text" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-primary float-right">Save Changes</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <form action="configSet/<?= getConfigSet($configSet, 'getTulisanHeader')['configId']; ?>" method="POST">
                                        <div class="card card-primary">
                                            <input type="hidden" name="_method" value="PUT">
                                            <input type="hidden" name="configTipe" value="<?= getConfigSet($configSet, 'getTulisanHeader')['configTipe']; ?>">
                                            <div class="card-header">
                                                <h4><?= getConfigSet($configSet, 'getTulisanHeader')['configDeskripsi']; ?></h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <input name="configValue" value="<?= getConfigSet($configSet, 'getTulisanHeader')['configValue']; ?>" type="text" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-primary float-right">Save Changes</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-6">
                                    <form action="configSet/<?= getConfigSet($configSet, 'getGambarHeader')['configId']; ?>" method="POST" enctype="multipart/form-data">
                                        <div class="card card-primary">
                                            <input type="hidden" name="_method" value="PUT">
                                            <input type="hidden" name="configTipe" value="<?= getConfigSet($configSet, 'getGambarHeader')['configTipe']; ?>">
                                            <input type="hidden" name="gambarLama" value="<?= getConfigSet($configSet, 'getGambarHeader')['configValue']; ?>">
                                            <div class="card-header">
                                                <h4><?= getConfigSet($configSet, 'getGambarHeader')['configDeskripsi']; ?></h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <div class="custom-file">
                                                        <input name="getGambar" type="file" accept="image/*" class="custom-file-input" value="<?= getConfigSet($configSet, 'getGambarHeader')['configValue']; ?>" id="gambarHeader" onchange="labelGambarHeader()">
                                                        <label class="custom-file-label gambarHeaderLabel" for="customFile"><?= getConfigSet($configSet, 'getGambarHeader')['configValue']; ?></label>
                                                    </div>
                                                </div>
                                                <div style="text-align:center">
                                                    <img src="<?= base_url() ?>/assets/img/<?= getConfigSet($configSet, 'getGambarHeader')['configValue'] ?>" alt="gambarHeader" id="previewGambarHeader" height="40%" width="40%">
                                                </div>
                                            </div>
                                            <div class="card-footer" id="dimGambarHeader">
                                                <p><strong>Dimension: 512px X 512px</strong></p>
                                            </div>
                                        </div>
                                    </form>
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