<?php

/* 
    Define Krs Routes
*/
$routes->get('pertanyaan', '\Modules\Pertanyaan\Controllers\Pertanyaan::index');
$routes->get('pertanyaan/(:num)', '\Modules\Pertanyaan\Controllers\Pertanyaan::getById/$1');
$routes->post('pertanyaan', '\Modules\Pertanyaan\Controllers\Pertanyaan::add');
$routes->put('pertanyaan/(:num)', '\Modules\Pertanyaan\Controllers\Pertanyaan::edit/$1');
$routes->put('pertanyaan/cetak/(:num)', '\Modules\Pertanyaan\Controllers\Pertanyaan::print/$1');
$routes->delete('pertanyaan/(:num)', '\Modules\Pertanyaan\Controllers\Pertanyaan::delete/$1');
