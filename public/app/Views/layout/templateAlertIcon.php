<div class="alert alert-<?= $msg[0] ?> alert-has-icon alert-dismissible show fade">
    <div class="alert-icon"><i class="<?= $msg[1] ?>"></i></div>
    <div class="alert-body">
        <button class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
        <div class="alert-title"><?= $msg[2] ?></div>
        <?= $msg[3] ?>
    </div>
</div>