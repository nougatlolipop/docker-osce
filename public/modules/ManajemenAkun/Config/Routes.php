<?php

/* 
    Define ManajemenAkun Routes
*/
$routes->get('manajemenAkun', '\Modules\ManajemenAkun\Controllers\ManajemenAkun::index');
$routes->add('manajemenAkun/ubah/(:num)', '\Modules\ManajemenAkun\Controllers\ManajemenAkun::edit/$1');
