<?php

/* 
    Define Krs Routes
*/
$routes->get('grade', '\Modules\Grade\Controllers\Grade::index');
$routes->get('grade/proses', '\Modules\Grade\Controllers\Grade::load');
$routes->post('grade/cetak', '\Modules\Grade\Controllers\Grade::print');
