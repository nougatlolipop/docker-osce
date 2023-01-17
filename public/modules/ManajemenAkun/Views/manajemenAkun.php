<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>
<!-- Wrapper Start -->
<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Manajemen Akun</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="/dashboard"><?= $breadcrumb[0]; ?></a></div>
                <div class="breadcrumb-item active"><?= $breadcrumb[1]; ?></div>
            </div>
        </div>
        <div class="section-body">
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
                    <?php if (!empty(session()->getFlashdata('success'))) : ?>
                        <?= view('layout/templateAlertIcon', ['msg' => ['success', 'fas fa-check', 'Sukses!', session()->getFlashdata('success')]]); ?>
                    <?php endif; ?>
                    <?php if ($validation->hasError('userEmail')) : ?>
                        <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', $validation->getError('userEmail')]]); ?>
                    <?php endif; ?>
                    <?php if ($validation->hasError('userName')) : ?>
                        <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', $validation->getError('userName')]]); ?>
                    <?php endif; ?>
                    <?php if ($validation->hasError('userRole')) : ?>
                        <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', $validation->getError('userRole')]]); ?>
                    <?php endif; ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="text-align:center" scope="col">No.</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Role</th>
                                    <th style="text-align:center" scope="col">Status</th>
                                    <th width="20%" style="text-align:center" scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($manajemenAkun)) : ?>
                                    <?php
                                    $no = 1 + ($numberPage * ($currentPage - 1));
                                    foreach ($manajemenAkun as $user) : ?>
                                        <tr>
                                            <td style="text-align:center" scope="row"><?= $no++; ?></td>
                                            <td><?= $user->email; ?></td>
                                            <td><?= $user->username; ?></td>
                                            <td><?= $user->name; ?></td>
                                            <td style="text-align:center"><span class="badge <?= $user->active == 1 ? "badge-success" : "badge-danger"; ?>"><?= $user->active == 1 ? "Aktif" : "Tidak Aktif"; ?></span></td>
                                            <td style="text-align:center">
                                                <button class="btn btn-icon icon-left btn-info" data-toggle="modal" data-target="#editAkun<?= $user->user_id; ?>" <?= ($user->user_id == user()->id) ? 'disabled' : ''; ?>><i class="fas fa-edit"></i></button>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <?= view('layout/templateEmpty', ['jumlahSpan' => 6]); ?>
                                <?php endif ?>
                            </tbody>
                        </table>
                        <?= $pager->links('manajemenAkun', 'pager') ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- start modal edit  -->
<?php foreach ($manajemenAkun as $edit) : ?>
    <?php if ($edit->user_id != user()->id) : ?>
        <div class="modal fade" tabindex="-1" role="dialog" id="editAkun<?= $edit->user_id; ?>">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data<strong> <?= $title; ?></strong></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/manajemenAkun/ubah/<?= $edit->user_id; ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Email</label>
                                <input name="userEmail" type="text" class="form-control" value="<?= $edit->email; ?>">
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input name="userName" type="text" class="form-control" value="<?= $edit->username; ?>">
                            </div>
                            <div class="form-group">
                                <label>Role</label>
                                <select name="userRole" class="form-control select2">
                                    <?php foreach ($authGroups as $groups) : ?>
                                        <option value="<?= $groups->id; ?>" <?php if ($groups->id == $edit->id) echo "selected" ?>><?= $groups->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="control-label">Status</div>
                                <label style="display: inline-block; padding-left: 0 !important;" class="custom-switch mt-2">
                                    <input type="checkbox" name="userActive" <?= ($edit->active == 1) ? "checked" : ""; ?> value="<?= $edit->active; ?>" class=" custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                </label>
                                <span style="display: inline-block; margin-top: 0 !important;" class="custom-switch-description">(Aktif/Tidak Aktif)</span>
                            </div>
                            <div class="modal-footer bg-whitesmoke br">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif ?>
<?php endforeach ?>
<!-- end modal Edit -->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>