<?php

/* 
    Define FilePendukung Routes
*/
$routes->get('filePendukung', '\Modules\FilePendukung\Controllers\FilePendukung::index', ['filter' => 'penilaian']);
