<?php

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Label\Font\NotoSans;

function genQr($id, $nama, $type, $string)
{
    $writer = new PngWriter();

    // Create QR code
    $qrCode = QrCode::create($string)
        ->setEncoding(new Encoding('UTF-8'))
        ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
        ->setSize(300)
        ->setMargin(10)
        ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
        ->setForegroundColor(new Color(0, 0, 0))
        ->setBackgroundColor(new Color(255, 255, 255));

    // Create generic logo
    $logo = Logo::create(FCPATH . 'assets/img/logo-umsu.png')
        ->setResizeToWidth(50);

    // Create generic label
    $label = Label::create($string)
        ->setTextColor(new Color(0, 0, 0))
        ->setFont(new NotoSans(22));

    $main = subfolder($nama, $id);

    if (!file_exists((FCPATH . 'qr/' . $main))) {
        mkdir(FCPATH . 'qr/' . $main, '0777', true);
    }
    if (!file_exists((FCPATH . 'qr/' . $main . '/activateKey'))) {
        mkdir(FCPATH . 'qr/' . $main . '/activateKey', '0777', true);
    }
    if (!file_exists((FCPATH . 'qr/' . $main . '/stationKey'))) {
        mkdir(FCPATH . 'qr/' . $main . '/stationKey', '0777', true);
    }

    $result = $writer->write($qrCode, $logo, $label);
    if ($type == 'ask') {
        $result->saveToFile(FCPATH . 'qr/' . $main . '/activateKey/' . $string . '.png');
    } else {
        $result->saveToFile(FCPATH . 'qr/' . $main . '/stationKey/' . $string . '.png');
    }
}

function subfolder($nama, $id)
{
    $nama = strtolower((strpos($nama, ' ') == true) ? str_replace(' ', '_', $nama) : $nama);
    $id = md5($id);
    $main = removeSpecialChar($nama) . $id;
    return $main;
}

function getFullUrlFromNpm($npm)
{
    $uri = 'https://mahasiswa.umsu.ac.id/FotoMhs/';
    $angkatan = '20' . substr($npm, 0, 2) . '/';

    $uriFoto = $uri . $angkatan . $npm . '.jpg';
    $file_header = @get_headers($uriFoto);
    return (!$file_header || $file_header[0] == 'HTTP/1.1 404 Not Found') ?  base_url("template/assets/img/avatar/avatar-1.png") : $uriFoto;
}
