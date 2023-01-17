<?php

/* 
    Define Krs Routes
*/
$routes->get('setting', '\Modules\Setting\Controllers\Setting::index');
$routes->post('setting', '\Modules\Setting\Controllers\Setting::add');
$routes->put('setting/genstation/(:any)', '\Modules\Setting\Controllers\Setting::genStation/$1');
$routes->put('setting/genpertanyaan/(:any)', '\Modules\Setting\Controllers\Setting::genPertanyaan/$1');
$routes->put('setting/(:any)', '\Modules\Setting\Controllers\Setting::edit/$1');
$routes->delete('setting/(:any)', '\Modules\Setting\Controllers\Setting::delete/$1');
