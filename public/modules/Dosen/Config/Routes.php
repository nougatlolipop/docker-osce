<?php

/* 
    Define Krs Routes
*/
$routes->get('dosen', '\Modules\Dosen\Controllers\Dosen::index');
$routes->post('dosen/tambah/internal', '\Modules\Dosen\Controllers\Dosen::add');
$routes->post('dosen/tambah/eksternal', '\Modules\Dosen\Controllers\Dosen::add');
$routes->delete('dosen/hapus/(:num)', '\Modules\Dosen\Controllers\Dosen::delete/$1');
$routes->get('/dosen/batal', '\Modules\Dosen\Controllers\Dosen::abort');
$routes->post('/dosen/simpan', '\Modules\Dosen\Controllers\Dosen::save');
