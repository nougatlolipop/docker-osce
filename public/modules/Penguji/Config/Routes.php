<?php

/* 
    Define Krs Routes
*/
$routes->get('penguji', '\Modules\Penguji\Controllers\Penguji::index');
$routes->get('penguji/mahasiswa', '\Modules\Penguji\Controllers\Penguji::getMahasiswa');
$routes->get('penguji/penguji', '\Modules\Penguji\Controllers\Penguji::getPenguji');
$routes->get('penguji/(:num)', '\Modules\Penguji\Controllers\Penguji::getById/$1');
$routes->post('penguji', '\Modules\Penguji\Controllers\Penguji::add');
$routes->put('penguji/genstation/(:num)', '\Modules\Penguji\Controllers\Penguji::genStation/$1');
$routes->put('penguji/genpertanyaan/(:num)', '\Modules\Penguji\Controllers\Penguji::genPertanyaan/$1');
$routes->put('penguji/(:num)', '\Modules\Penguji\Controllers\Penguji::edit/$1');
$routes->put('penguji/cetak/(:num)', '\Modules\Penguji\Controllers\Penguji::print/$1');
$routes->delete('penguji/(:num)', '\Modules\Penguji\Controllers\Penguji::delete/$1');
