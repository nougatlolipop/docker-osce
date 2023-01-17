<?php

/* 
    Define Krs Routes
*/
$routes->get('lokasi', '\Modules\Lokasi\Controllers\Lokasi::index');
$routes->post('lokasi', '\Modules\Lokasi\Controllers\Lokasi::add');
$routes->put('lokasi/(:any)', '\Modules\Lokasi\Controllers\Lokasi::edit/$1');
$routes->delete('lokasi/(:any)', '\Modules\Lokasi\Controllers\Lokasi::delete/$1');
