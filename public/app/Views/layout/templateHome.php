<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title><?= $title . " | " . getNamaApp(); ?></title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?= base_url('/template/node_modules/bootstrap/dist/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('/template/node_modules/@fortawesome/fontawesome-free/css/all.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('/template/node_modules/@fortawesome/fontawesome-free/css/all.css') ?>">
  <!-- CSS Libraries -->
  <link rel="stylesheet" href="<?= base_url('/template/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('/template/node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('/template/node_modules/select2/dist/css/select2.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('/template/node_modules/bootstrap-daterangepicker/daterangepicker.css') ?>">
  <link rel="stylesheet" href="<?= base_url('/template/node_modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('/template/node_modules/selectric/public/selectric.css') ?>">
  <link rel="stylesheet" href="<?= base_url('/template/node_modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('/template/node_modules/summernote/dist/summernote-bs4.css') ?>">
  <link rel="stylesheet" href="<?= base_url('/template/node_modules/bootstrap-social/bootstrap-social.css') ?>">
  <link rel="stylesheet" href="<?= base_url('/template/node_modules/izitoast/dist/css/iziToast.min.css') ?>">


  <!-- Template CSS -->
  <link rel="stylesheet" href="<?= base_url('/template/assets/css/style.css') ?>">
  <link rel="stylesheet" href="<?= base_url('/template/assets/css/components.css') ?>">


  <!-- for plugin notification -->
  <link rel="stylesheet" href="<?= base_url('/css/toastr.min.css') ?>" />
  <style>
    #loading {
      /* width: 100%;
      height: 100%;
      top: 30%;
      left: 30%;
      position: fixed;
      display: block;
      opacity: 0.7;
      background-color: #fff;*/
      z-index: 99;
      text-align: center;
    }

    #loading-image {
      /*position: absolute;
      top: 100px;
      left: 240px;*/
      z-index: 100;
    }

    .ft12 {
      font-size: 12px;
    }

    .ft10 {
      font-size: 10px;
    }

    .ft8 {
      font-size: 8px;
    }

    .frezz {
      position: sticky;
      left: 0px;
      background-color: white;
    }
  </style>
</head>


<body>

  <div id="app">
    <div class="main-wrapper">

      <?= $this->renderSection('content'); ?>

    </div>
  </div>
  <!-- General JS Scripts -->
  <?= script_tag('template/node_modules/jquery/dist/jquery.min.js') ?>
  <?= script_tag('template/node_modules/moment/min/moment.min.js') ?>
  <?= script_tag('https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js') ?>
  <?= script_tag('template/node_modules/bootstrap/dist/js/bootstrap.min.js') ?>
  <?= script_tag('template/node_modules/jquery.nicescroll/dist/jquery.nicescroll.min.js') ?>
  <?= script_tag('template/assets/js/stisla.js') ?>

  <!-- JS Libraies -->
  <?= script_tag('template/node_modules/datatables/media/js/jquery.dataTables.min.js') ?>
  <?= script_tag('template/node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') ?>
  <?= script_tag('template/node_modules/datatables.net-select-bs4/js/select.bootstrap4.min.js') ?>
  <?= script_tag('template/node_modules/select2/dist/js/select2.full.min.js') ?>
  <?= script_tag('template/node_modules/bootstrap-daterangepicker/daterangepicker.js') ?>
  <?= script_tag('template/node_modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') ?>
  <?= script_tag('template/node_modules/selectric/public/jquery.selectric.min.js') ?>
  <?= script_tag('template/node_modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js') ?>
  <?= script_tag('template/node_modules/cleave.js/dist/cleave.min.js') ?>
  <?= script_tag('template/node_modules/cleave.js/dist/addons/cleave-phone.us.js') ?>
  <?= script_tag('template/node_modules/summernote/dist/summernote-bs4.js') ?>
  <?= script_tag('template/node_modules/izitoast/dist/js/iziToast.min.js') ?>

  <!-- Template JS File -->
  <?= script_tag('https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js') ?>

  <!-- Page Specific JS File -->
  <?= script_tag('template/assets/js/page/modules-datatables.js') ?>


  <?= script_tag('js/osce.js') ?>
  <?= script_tag('template/assets/js/scripts.js') ?>
  <?= script_tag('template/assets/js/custom.js') ?>

</body>

</html>