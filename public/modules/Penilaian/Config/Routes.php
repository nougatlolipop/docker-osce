<?php

/* 
    Define Krs Routes
*/
$routes->get('penilaian', '\Modules\Penilaian\Controllers\Penilaian::index', ['filter' => 'penilaian']);
$routes->get('penilaianLogout', '\Modules\Penilaian\Controllers\Penilaian::logout');
$routes->post('penilaian/save', '\Modules\Penilaian\Controllers\Penilaian::add');
