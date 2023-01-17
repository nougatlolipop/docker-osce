<?php

/* 
This is Controller Krs
 */

namespace Modules\Your_Module\Controllers;

use App\Controllers\BaseController;
use Modules\Your_Module\Models\Your_Model;


class Your_Module extends BaseController
{
    protected $your_Model;

    public function __construct()
    {
        $this->your_Model = new Your_Model();
    }
    public function index()
    {
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Your_Module",
            'breadcrumb' => ['Home', 'Your_Module'],
        ];
        return view('Modules\Your_Module\Views\your_Module', $data);
    }
}
