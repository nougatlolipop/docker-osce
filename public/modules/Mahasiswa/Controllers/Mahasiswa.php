<?php

/* 
This is Controller Krs
 */

namespace Modules\Mahasiswa\Controllers;

use App\Controllers\BaseController;
use Modules\Mahasiswa\Models\MahasiswaModel;
use App\Models\ApiModel;

class Mahasiswa extends BaseController
{
    protected $mahasiswaModel;
    protected $apiModel;

    public function __construct()
    {
        $this->mahasiswaModel = new MahasiswaModel();
        $this->apiModel = new ApiModel();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page_mahasiswa') ? $this->request->getVar('page_mahasiswa') : 1;
        $keyword = $this->request->getVar('keyword');
        $mahasiswa = $this->mahasiswaModel->getMhs($keyword);
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Mahasiswa",
            'breadcrumb' => ['Data', 'Mahasiswa'],
            'mahasiswa' =>  $mahasiswa->paginate($this->numberPage, 'mahasiswa'),
            'apiMahasiswa' => $this->apiModel->getMahasiswa(),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $mahasiswa->pager,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\Mahasiswa\Views\mahasiswa', $data);
    }

    public function add()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'dataMahasiswa' => rv('required', ['required' => 'Data Mahasiswa Harus Dipilih']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };
        $dataMahasiswa = $this->request->getVar('dataMahasiswa');
        $dtMahasiswa = [];

        foreach ($dataMahasiswa as $mahasiswa) {
            $mahasiswaNpm = $this->mahasiswaModel->cekMahasiswa(['mahasiswaNpm' => explode('#', $mahasiswa)[0], 'mahasiswaDeletedDate' => null,])->findAll();
            $npm = [];
            foreach ($mahasiswaNpm as $key => $value) {
                $npm[] = $value->mahasiswaNpm;
            }
            if ($npm == null) {
                $akun = 'Insert New';
            } else {
                $akun = 'No Action';
            }
            array_push($dtMahasiswa, [
                'mahasiswaNpm' => trim(explode('#', $mahasiswa)[0]),
                'mahasiswaNama' => trim(explode('#', $mahasiswa)[1]),
                'mahasiswaAkun' => $akun,
            ]);
        };
        $dataSession = ['dtMahasiswa' => $dtMahasiswa];
        session()->set('dataSession', $dataSession);
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
        $mahasiswaNpm = $this->request->getVar('mahasiswaNpm');
        $mahasiswaNama = $this->request->getVar('mahasiswaNama');
        $mahasiswaAkun = $this->request->getVar('mahasiswaAkun');
        $counts['inserted'] = 0;
        $counts['noaction'] = 0;
        $counts['error'] = 0;
        $dataEktract = [];
        foreach ($mahasiswaNpm as $key => $data) {
            $dataEktract[] = [
                'mahasiswaNpm' => $mahasiswaNpm[$key],
                'mahasiswaNama' => $mahasiswaNama[$key],
                'mahasiswaAkun' => $mahasiswaAkun[$key],
            ];
        }

        foreach ($dataEktract as $key => $value) {
            if ($value['mahasiswaAkun'] == 'Insert New') {
                $data = [
                    'mahasiswaNpm' => $value['mahasiswaNpm'],
                    'mahasiswaNama' => $value['mahasiswaNama'],
                    'mahasiswaCreatedBy' => user()->email,
                ];
                if ($this->mahasiswaModel->insert($data)) {
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

    // public function edit($npm)
    // {
    //     $url = $this->request->getServer('HTTP_REFERER');
    //     $rules = [
    //         'mahasiswaNpm' => rv('required', ['required' => 'NPM Mahasiswa Harus Diisi']),
    //         'mahasiswaNama' => rv('required', ['required' => 'Nama Mahasiswa Harus Diisi']),
    //     ];
    //     if (!$this->validate($rules)) {
    //         return redirect()->to($url)->withInput();
    //     };
    //     $jumlah = $this->mahasiswaModel->dataExist(
    //         [
    //             'mahasiswaNpm' => trim($this->request->getVar('mahasiswaNpm')),
    //             'mahasiswaDeletedDate' => null,
    //         ]
    //     );
    //     if ($jumlah == 0) {
    //         $data = [
    //             'mahasiswaNpm' => trim($this->request->getVar('mahasiswaNpm')),
    //             'mahasiswaNama' => trim($this->request->getVar('mahasiswaNama')),
    //             'pengujiModifiedBy' => user()->email,
    //         ];
    //         if ($this->mahasiswaModel->update($npm, $data)) {
    //             session()->setFlashdata('update', 'Data Mahasiswa Berhasil Diupdate');
    //         }
    //     } else {
    //         session()->setFlashdata('danger', 'Data Mahasiswa Sudah Terdaftar');
    //     }
    //     return redirect()->to($url);
    // }

    public function delete($npm)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->mahasiswaModel->delete($npm)) {
            session()->setFlashdata('update', 'Data Mahasiswa Berhasil Dihapus');
        };
        return redirect()->to($url);
    }
}
