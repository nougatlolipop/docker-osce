<?php

/* 
This is Controller Krs
 */

namespace Modules\Pengawas\Controllers;

use App\Controllers\BaseController;
use Modules\Pengawas\Models\PengawasModel;
use Modules\Setting\Models\SettingModel;

class Pengawas extends BaseController
{
    protected $your_Model;

    public function __construct()
    {
        $this->pengawasModel = new PengawasModel();
        $this->setting = new SettingModel();
    }
    public function index()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/penilaian');
        }
        return view('Modules\Pengawas\Views\pengawas');
    }

    public function login()
    {
        $stationKey = $this->request->getVar('password');
        $status = $this->request->getVar('kondisiStation');

        if ($status == 'non-aktif') {
            $result = $this->setting->getSettingWhere(['0', $stationKey])->getResult();

            if (count($result) < 1) :
                return redirect()->back()->withInput()->with('error', lang('Auth.badAttempt') ?? lang('Auth.badAttempt'));
            endif;

            $dataSesi = [
                'statusStation' => true,
                'stationId' => $result[0]->stationId,
                'stationNama' => $result[0]->stationNama
            ];
            session()->set($dataSesi);

            return redirect()->to('/pengawas');
        } elseif ($status == 'aktif') {
            $result = $this->setting->getSettingWhere(['1', $stationKey, session('stationId')])->getResult();

            if (count($result) < 1) :
                return redirect()->back()->withInput()->with('error', lang('Auth.badAttempt') ?? lang('Auth.badAttempt'));
            endif;

            $dataSesi = [
                'setId' => $result[0]->setId,
                'lokasiId' => $result[0]->lokasiId,
                'lokasiNama' => $result[0]->lokasiNama,
                'stationId' => $result[0]->stationId,
                'stationNama' => $result[0]->stationNama,
                'logged_in' => TRUE,
            ];
            session()->set($dataSesi);

            return redirect()->to('/penilaian');
        }
    }

    public function nonaktif()
    {
        // dd($_GET);
        // session()->destroy();
        // return redirect()->to('/pengawas');
    }
}
