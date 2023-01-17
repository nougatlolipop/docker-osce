<?php

/* 
This is Controller Krs
 */

namespace Modules\FilePendukung\Controllers;

use Modules\Penilaian\Models\PenilaianModel;

use App\Controllers\BaseController;

class FilePendukung extends BaseController
{
    protected $penilaianModel;

    public function __construct()
    {
        $this->penilaianModel = new PenilaianModel();
    }

    public function index()
    {
        $id = session()->get('setId');
        $station = session()->get('stationId');
        $attach = $this->penilaianModel->getAllAttachment($id, $station)->getResult();
        $setNama = $attach[0]->setDeskripsi;
        $filePendukung = $attach[0]->filePendukung;

        $data = [
            'title' => 'File Pendukung',
            'file' => ($filePendukung != null) ? 'file/' . subfolder($setNama, $id) . '/pendukung/' . strtolower(str_replace(' ', '', session()->get('stationNama'))) . '/' . $filePendukung : '',
        ];

        return view('Modules\FilePendukung\Views\filePendukung', $data);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/pengawas');
    }
}
