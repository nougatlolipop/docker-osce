<?php

/* 
This is Controller Krs
 */

namespace Modules\Setting\Controllers;

use App\Controllers\BaseController;
use Modules\Kompetensi\Models\KompetensiModel;
use Modules\Lokasi\Models\LokasiModel;
use Modules\Setting\Models\SettingModel;


class Setting extends BaseController
{
    protected $settingModel;
    protected $lokasiModel;
    protected $kompetensiModel;

    public function __construct()
    {
        $this->settingModel = new SettingModel();
        $this->lokasiModel = new LokasiModel();
        $this->kompetensiModel = new KompetensiModel();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page_setting') ? $this->request->getVar('page_setting') : 1;
        $keyword = $this->request->getVar('keyword');
        $setting = $this->settingModel->getSetting($keyword);
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Penjadwalan Test",
            'breadcrumb' => ['Setting Test', 'Penjadwalan Test'],
            'setting' => $setting->paginate($this->numberPage, 'setting'),
            'lokasi' => $this->lokasiModel->findAll(),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $setting->pager,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\Setting\Views\setting', $data);
    }

    public function add()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'setDeskripsi' => rv('required', ['required' => 'Nama Setting Harus Diisi']),
            'jmlStation' => rv('required', ['required' => 'Jumlah Station Harus Diisi']),
            'tanggalMulai' => rv('required', ['required' => 'Tanggal Tes Harus Diisi']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };
        $lok = [];
        if ($this->request->getVar('lokasi') != null) {
            foreach ($this->request->getVar('lokasi') as $key => $lokasi) {
                $lok[] = ['lokasi' => $lokasi];
            }
        } else {
            session()->setFlashdata('error', 'Lokasi Belum Ditentukan');
            return redirect()->to($url);
        }

        $data = [
            'setDeskripsi' => $this->request->getVar('setDeskripsi'),
            'setLokasi' => json_encode(['data' => $lok]),
            'setJumlahStation' => $this->request->getVar('jmlStation'),
            'setStationRest' => json_encode($this->request->getVar('stationRest')),
            'setStartDate' => reformat($this->request->getVar('tanggalMulai')),
            'setCreatedBy' => user()->email
        ];

        if ($this->settingModel->insert($data)) :
            session()->setFlashdata('success', 'Setting Berhasil DiTambah');
        else :
            session()->setFlashdata('error', 'Setting Gagal DiTambah');
        endif;
        return redirect()->to($url);
    }

    public function genStation($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $setting = $this->settingModel->getSettingById($id)->findAll();
        $stationRest = ($setting[0]->setStationRest != null) ? json_decode($setting[0]->setStationRest) : [];
        $lokasiDb = json_decode($setting[0]->setLokasi)->data;
        $jmlStation = $setting[0]->setJumlahStation;
        // dd($stationRest);
        $namaSetting = $setting[0]->setDeskripsi;
        $station = [];
        if (count($lokasiDb) != 0) {
            foreach ($lokasiDb  as $key => $lokasi) {
                $detail = [];
                for ($i = 1; $i <= $jmlStation; $i++) {
                    $genPass = getRandomHex();
                    $genActiveKey = getRandomHex();
                    $mhs = [];
                    for ($j = 1; $j <= $jmlStation; $j++) {
                        $mhs[] = ['urutan' => $j, 'mahasiswa' => null, 'kehadiran' => 1];
                    }

                    if (in_array($i, $stationRest)) {
                        $detail[] = [
                            'station' => $i,
                            'stationNama' => 'Station ' . $i,
                            'stationStatus' => 'Rest',
                            'stationActiveKey' => null,
                            'stationKey' => null,
                            'penguji' => null,
                            'mahasiswa' => $mhs
                        ];
                    } else {
                        $detail[] = [
                            'station' => $i,
                            'stationNama' => 'Station ' . $i,
                            'stationStatus' => 'Act',
                            'stationActiveKey' => $genActiveKey,
                            'stationKey' => $genPass,
                            'penguji' => null,
                            'mahasiswa' => $mhs
                        ];
                        genQr($id, $namaSetting, 'ask', $genActiveKey);
                        genQr($id, $namaSetting, 'sk', $genPass);
                    }
                }
                $station[] = [
                    'lokasi' => $lokasi->lokasi,
                    'skenario' => null,
                    'detail' => $detail
                ];
            }
        }
        $data = array(
            'setStation' => json_encode(['data' => $station]),
            'setModifiedBy' => user()->email
        );

        if ($this->settingModel->updateData(['setId' => $id], $data)) :
            session()->setFlashdata('success', 'Berhasil Generate Station');
        else :
            session()->setFlashdata('error', 'Gagal Generate Station');
        endif;
        return redirect()->to($url);
    }

    public function genPertanyaan($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $setting = $this->settingModel->getSettingById($id)->findAll();
        $stationRest = ($setting[0]->setStationRest != null) ? json_decode($setting[0]->setStationRest) : [];
        $jmlStation = $setting[0]->setJumlahStation;
        $question = [];
        $datalama = json_decode($setting[0]->setStation);

        $stationStatusLama = [];

        foreach ($datalama->data as $key => $value) {
            // $lok = $value->lokasi;
            foreach ($value->detail as $s => $st) {
                $stationStatusLama[$st->station] = $st->stationStatus;
            }
        }

        for ($i = 1; $i <= $jmlStation; $i++) {
            $pertanyaan = [];
            foreach ($this->kompetensiModel->findAll() as $key => $komp) {
                $pertanyaan[] = [
                    'kompetensi' => $komp->kompetensiId,
                    'pertanyaan' => null,
                    'bobot' => 0
                ];
            }
            $question[] = [
                'station' => $i,
                'status' => $stationStatusLama[$i],
                'attachment' => [null, null],
                'pendukung' => null,
                'skenario' => null,
                'detail' => $pertanyaan
            ];
        }

        $data = array(
            'setPertanyaan' => json_encode(['data' => $question]),
            'setModifiedBy' => user()->email
        );
        // dd($data);
        if ($this->settingModel->updateData(['setId' => $id], $data)) :
            session()->setFlashdata('success', 'Berhasil Generate Pertanyaan');
        else :
            session()->setFlashdata('error', 'Gagal Generate Station');
        endif;
        return redirect()->to($url);
    }

    public function edit($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'setDeskripsi' => rv('required', ['required' => 'Nama Setting Harus Diisi']),
            'tanggalMulai' => rv('required', ['required' => 'Tanggal Tes Harus Diisi']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };
        $data = array(
            'setDeskripsi' => $this->request->getVar('setDeskripsi'),
            'setStartDate' => $this->request->getVar('tanggalMulai'),
            'setStationRest' => json_encode($this->request->getVar('stationRest')),
            'setModifiedBy' => user()->email
        );

        if ($this->settingModel->updateData(['setId' => $id], $data)) :
            session()->setFlashdata('success', 'Setting Berhasil Diupdate');
        else :
            session()->setFlashdata('error', 'Setting Gagal Diupdate');
        endif;
        return redirect()->to($url);
    }

    public function delete($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->settingModel->deleteData(['setId' => $id])) :
            session()->setFlashdata('success', 'Setting Berhasil Dihapus');
        else :
            session()->setFlashdata('error', 'Setting Gagal Dihapus');
        endif;
        return redirect()->to($url);
    }
}
