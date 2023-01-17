<?php

/* 
    Define Krs Routes
*/
$routes->get('kompetensi', '\Modules\Kompetensi\Controllers\Kompetensi::index');
$routes->post('kompetensi', '\Modules\Kompetensi\Controllers\Kompetensi::add');
$routes->put('kompetensi/(:any)', '\Modules\Kompetensi\Controllers\Kompetensi::edit/$1');
$routes->delete('kompetensi/(:any)', '\Modules\Kompetensi\Controllers\Kompetensi::delete/$1');
