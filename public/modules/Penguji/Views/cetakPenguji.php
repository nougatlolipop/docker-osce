<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= 'Penguji ' . $nama; ?></title>
    <style>
        /* div.row {
            width: 100%;
        } */

        div.kartu-penguji {
            float: left;
            position: relative;
            width: 295px;
            height: 185px;
            border: 1px solid #000;
        }

        div.body {
            margin: 20px 0px 10px 35px;
        }

        div.qr {
            float: left;
            width: 80px;
            height: 85px;
        }

        div.data {
            margin: 0px 0px 0px 15px;
            float: right;
        }

        p.info {
            font-size: 13px;
            margin: 0px 0px 5px 10px;
        }

        p.bold {
            font-size: 13px;
            font-weight: bold;
            margin: 0px 0px 5px 10px;
        }

        div.header {
            margin: 10px 0px 0px 15px;
        }

        div.logo-umsu {
            float: left;
            width: 50px;
            height: 50px;
        }

        div.umsu {
            float: right;
            padding-bottom: -15px;
            padding-top: -10px;
            font-size: 12px;
            text-align: center;
            font-weight: bold;
        }

        div.kartu-it {
            float: right;
            position: relative;
            width: 295px;
            height: 185px;
            border: 1px solid #000;
        }
    </style>
</head>

<body>
    <?php $dataPenguji = array_combine(range(1, count($penguji)), array_values($penguji)); ?>
    <?php foreach ($dataPenguji as $dtKey => $data) : ?>
        <?php if ($data->stationStatus == 'Act') : ?>
            <div class="row">
                <div class="kartu-penguji">
                    <div class="header">
                        <div class="logo-umsu">
                            <img src="<?= FCPATH . 'assets/img/' . getGambarHeader() ?>" alt="logo-umsu">
                        </div>
                        <div class="umsu">
                            <p>FAKULTAS KEDOKTERAN<br><?= getTulisanHeader() ?></p>
                        </div>
                    </div>
                    <div class="body">
                        <div class="qr">
                            <img src="<?= FCPATH . 'qr/' . subfolder($nama, $id) . '/stationKey/' . $data->stationKey . '.png' ?>" alt="qr">
                        </div>
                        <div class="data">
                            <p class="info"><?= $nama ?></p>
                            <p class="info"><?= $data->stationNama; ?></p>
                            <p class="bold">Penguji</p>
                        </div>
                    </div>
                </div>
                <div class="kartu-it">
                    <div class="header">
                        <div class="logo-umsu">
                            <img src="<?= FCPATH . 'assets/img/' . getGambarHeader() ?>" alt="logo-umsu">
                        </div>
                        <div class="umsu">
                            <p>FAKULTAS KEDOKTERAN<br><?= getTulisanHeader() ?></p>
                        </div>
                    </div>
                    <div class="body">
                        <div class="qr">
                            <img src="<?= FCPATH . 'qr/' . subfolder($nama, $id) . '/activateKey/' . $data->stationActiveKey . '.png' ?>" alt="qr">
                        </div>
                        <div class="data">
                            <p class="info"><?= $nama; ?></p>
                            <p class="info"><?= $data->stationNama; ?></p>
                            <p class="bold">IT Officer</p>
                        </div>
                    </div>
                </div>
            </div>
            <?php end($dataPenguji) ?>
            <?php $key = key($dataPenguji) ?>
            <?php if ($key != $dtKey) : ?>
                <p <?= ($dtKey % 4 == 0) ? 'style="page-break-after: always;"' : '' ?>>&nbsp;</p>
            <?php endif ?>
        <?php endif ?>
    <?php endforeach ?>
</body>

</html>