<?php

/* 
    Define Krs Routes
*/
$routes->get('configSet', '\Modules\ConfigSet\Controllers\ConfigSet::index');
$routes->put('configSet/(:any)', '\Modules\ConfigSet\Controllers\ConfigSet::edit/$1');
