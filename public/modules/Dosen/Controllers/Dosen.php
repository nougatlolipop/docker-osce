<?php

/* 
This is Controller Krs
 */

namespace Modules\Dosen\Controllers;

use App\Controllers\BaseController;
use Modules\Dosen\Models\DosenModel;
use App\Models\ApiModel;

class Dosen extends BaseController
{
    protected $dosenModel;
    protected $apiModel;

    public function __construct()
    {
        $this->dosenModel = new DosenModel();
        $this->apiModel = new ApiModel();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page_dosen') ? $this->request->getVar('page_dosen') : 1;
        $keyword = $this->request->getVar('keyword');
        $dosen = $this->dosenModel->getDosenPenguji($keyword);
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Dosen",
            'breadcrumb' => ['Data', 'Dosen'],
            'dosen' =>  $dosen->paginate($this->numberPage, 'dosen'),
            'apiDosen' => $this->apiModel->getDosen(),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $dosen->pager,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\Dosen\Views\dosen', $data);
    }

    public function add()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->request->getVar('dosen') == 'internal') {
            $rules = [
                'dataDosen' => rv('required', ['required' => 'Data Dosen Harus Dipilih']),
            ];
            if (!$this->validate($rules)) {
                return redirect()->to($url)->withInput();
            };
            $dataDosen = $this->request->getVar('dataDosen');
            $dtDosen = [];

            foreach ($dataDosen as $dosen) {
                $dosenId = $this->dosenModel->cekDosen(['pengujiPegawaiId' => explode('#', $dosen)[1], 'pengujiDeletedDate' => null,])->findAll();
                $idDosen = $this->dosenModel->cekDosen(['pengujiPegawaiId' => explode('#', $dosen)[1], 'pengujiDeletedDate' => null,])->findAll();
                $id = [];
                foreach ($dosenId as $key => $value) {
                    $id[] = $value->pengujiPegawaiId;
                }
                $dsn = '';
                foreach ($idDosen as $key => $value) {
                    $dsn = $value->pengujiId;
                }
                if ($id == null) {
                    $akun = 'Insert New';
                } else {
                    $akun = 'No Action';
                }
                array_push($dtDosen, [
                    'pengujiNama' => trim(explode('#', $dosen)[0]),
                    'pengujiStatus' => 1,
                    'pengujiAkun' => $akun,
                    'pengujiId' => $dsn,
                    'pengujiPegawaiId' => trim(explode('#', $dosen)[1]),
                ]);
            };
            $dataSession = ['dtDosen' => $dtDosen];
            session()->set('dataSession', $dataSession);
        } else {
            $rules = [
                'pengujiNama' => rv('required', ['required' => 'Nama Dosen Harus Diisi']),
            ];
            if (!$this->validate($rules)) {
                return redirect()->to($url)->withInput();
            };
            $dataDosen = $this->request->getVar('pengujiNama');
            $dtDosen = [];
            foreach ($dataDosen as $dosen) {
                $pengujiPegawaiId = md5($dosen);
                $dosenId = $this->dosenModel->cekDosen(['pengujiPegawaiId' => $pengujiPegawaiId, 'pengujiDeletedDate' => null,])->findAll();
                $idDosen = $this->dosenModel->cekDosen(['pengujiPegawaiId' => $pengujiPegawaiId, 'pengujiDeletedDate' => null,])->findAll();
                $id = [];
                foreach ($dosenId as $key => $value) {
                    $id[] = $value->pengujiPegawaiId;
                }
                $dsn = '';
                foreach ($idDosen as $key => $value) {
                    $dsn = $value->pengujiId;
                }
                if ($id == null) {
                    $akun = 'Insert New';
                } else {
                    $akun = 'No Action';
                }
                array_push($dtDosen, [
                    'pengujiNama' => $dosen,
                    'pengujiStatus' => 0,
                    'pengujiAkun' => $akun,
                    'pengujiId' => $dsn,
                    'pengujiPegawaiId' => $pengujiPegawaiId,
                ]);
            }
            $dataSession = ['dtDosen' => $dtDosen];
            session()->set('dataSession', $dataSession);
        }
        return redirect()->to($url);
    }

    public function abort()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        session()->remove('dataSession');
        session()->setFlashdata('abort', 'Pembatalan Berhasil!');
        return redirect()->to($url);
    }

    public function save()
    {
        $dosenId = $this->request->getVar('pengujiId');
        $pengujiPegawaiId = $this->request->getVar('pengujiPegawaiId');
        $pengujiNama = $this->request->getVar('pengujiNama');
        $pengujiStatus = $this->request->getVar('pengujiStatus');
        $pengujiAkun = $this->request->getVar('pengujiAkun');
        $counts['inserted'] = 0;
        $counts['noaction'] = 0;
        $counts['error'] = 0;
        $dataEktract = [];
        foreach ($pengujiPegawaiId as $key => $data) {
            $dataEktract[] = [
                'dosenId' => $dosenId[$key],
                'pengujiPegawaiId' => $pengujiPegawaiId[$key],
                'pengujiNama' => $pengujiNama[$key],
                'pengujiStatus' => $pengujiStatus[$key],
                'pengujiAkun' => $pengujiAkun[$key],
            ];
        }

        foreach ($dataEktract as $key => $value) {
            if ($value['pengujiAkun'] == 'Insert New') {
                $data = [
                    'pengujiPegawaiId' => $value['pengujiPegawaiId'],
                    'pengujiNama' => $value['pengujiNama'],
                    'pengujiStatus' => ($value['pengujiStatus'] == 'Internal') ? 1 : 0,
                    'pengujiCreatedBy' => user()->email,
                ];
                if ($this->dosenModel->insert($data)) {
                    $counts['inserted']++;
                } else {
                    $counts['error']++;
                }
            } else {
                $counts['noaction']++;
            }
        }
        $url = $this->request->getServer('HTTP_REFERER');
        session()->remove('dataSession');
        session()->setFlashdata('counts', $counts);
        session()->setFlashdata('success', 'Perintah Berhasil Dijalankan');
        return redirect()->to($url);
    }

    public function delete($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->dosenModel->delete($id)) {
            session()->setFlashdata('update', 'Data Dosen Berhasil Dihapus');
        };
        return redirect()->to($url);
    }
}
