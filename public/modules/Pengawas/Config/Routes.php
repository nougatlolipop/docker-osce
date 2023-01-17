<?php

/* 
    Define Krs Routes
*/
$routes->get('pengawas', '\Modules\Pengawas\Controllers\Pengawas::index');
$routes->post('pengawas', '\Modules\Pengawas\Controllers\Pengawas::login');
$routes->get('pengawas/logout', '\Modules\Pengawas\Controllers\Pengawas::nonaktif');
