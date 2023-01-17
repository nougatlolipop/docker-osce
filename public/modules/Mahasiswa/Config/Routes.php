<?php

/* 
    Define Krs Routes
*/
$routes->get('mahasiswa', '\Modules\Mahasiswa\Controllers\Mahasiswa::index');
$routes->post('mahasiswa/tambah', '\Modules\Mahasiswa\Controllers\Mahasiswa::add');
$routes->delete('mahasiswa/hapus/(:any)', '\Modules\Mahasiswa\Controllers\Mahasiswa::delete/$1');
$routes->get('/mahasiswa/batal', '\Modules\Mahasiswa\Controllers\Mahasiswa::abort');
$routes->post('/mahasiswa/simpan', '\Modules\Mahasiswa\Controllers\Mahasiswa::save');
