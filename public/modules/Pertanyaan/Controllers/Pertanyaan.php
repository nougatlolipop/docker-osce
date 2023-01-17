<?php

/* 
This is Controller Krs
 */

namespace Modules\Pertanyaan\Controllers;

use App\Controllers\BaseController;
use Modules\Kompetensi\Models\KompetensiModel;
use Modules\Lokasi\Models\LokasiModel;
use Modules\Pertanyaan\Models\PertanyaanModel;
use Modules\Setting\Models\SettingModel;

class Pertanyaan extends BaseController
{
    protected $pertanyaanModel;
    protected $lokasiModel;
    protected $kompetensiModel;
    protected $spreadsheet;
    protected $ReaderHtml;

    public function __construct()
    {
        $this->pertanyaanModel = new PertanyaanModel();
        $this->lokasiModel = new LokasiModel();
        $this->kompetensiModel = new KompetensiModel();
        $this->settingModel = new SettingModel();
    }
    public function index()
    {
        $currentPage = $this->request->getVar('page_pertanyaan') ? $this->request->getVar('page_pertanyaan') : 1;
        $keyword = $this->request->getVar('keyword');
        $pertanyaan = $this->pertanyaanModel->getPertanyaan($keyword);
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Pertanyaan",
            'breadcrumb' => ['Setting Test', 'Pertanyaan'],
            'pertanyaan' => $pertanyaan->paginate($this->numberPage, 'pertanyaan'),
            'lokasi' => $this->lokasiModel->findAll(),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $pertanyaan->pager,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\Pertanyaan\Views\pertanyaan', $data);
    }

    public function getById($id)
    {
        $pertanyaan = $this->pertanyaanModel->getPertanyaanById($id)->getResult();
        echo json_encode($pertanyaan);
    }

    public function edit($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $key = array_keys($_POST);
        $setting = $this->settingModel->getSettingById($id)->findAll();
        $namaSetting = $setting[0]->setDeskripsi;
        $station = [];

        $datalama = json_decode($setting[0]->setStation);

        $stationStatusLama = [];

        foreach ($datalama->data as $stKey => $value) {
            foreach ($value->detail as $s => $st) {
                $stationStatusLama[$st->station] = $st->stationStatus;
            }
        }

        foreach ($key as $val) {
            if (count(explode(',', $val)) > 1) {
                if (explode(',', $val)[0] == 'tugas') {
                    $station[] = explode(',', $val)[1];
                }
            }
        }
        $station = array_unique($station);
        $station = array_values($station);

        $kompetensi = [];
        foreach ($key as $val) {
            if (count(explode(',', $val)) > 1) {
                if (explode(',', $val)[0] == 'tugas') {
                    $kompetensi[] = explode(',', $val)[2];
                }
            }
        }
        $kompetensi = array_unique($kompetensi);

        $skenario = [];
        foreach ($key as $val) {
            if (count(explode(',', $val)) > 1) {
                if (explode(',', $val)[0] == 'skenario') {
                    $skenario[] = [explode(',', $val)[1] => $_POST['skenario,' . explode(',', $val)[1]]];
                }
            }
        }

        $dtPertanyaan = json_decode($setting[0]->setPertanyaan)->data;

        $fileLama = [];
        foreach ($dtPertanyaan as $key => $pert) {
            $attachment = $pert->attachment;
            $instruksi = $attachment[0];
            $rubrik = $attachment[1];
            $pendukung = $pert->pendukung;
            $fileLama[] = ['instruksi' => $instruksi, 'rubrik' => $rubrik, 'pendukung' => $pendukung];
        }

        $data = [];
        foreach ($station as $keyS => $stat) {
            $detail = [];
            foreach ($kompetensi as $keyK => $komp) {
                $detail[] = [
                    'kompetensi' => $komp,
                    'pertanyaan' => ($_POST["tugas," . $stat . "," . $komp] == "") ? null : $_POST["tugas," . $stat . "," . $komp],
                    'bobot' => ($_POST["bobot," . $stat . "," . $komp] == "") ? 0 : $_POST["bobot," . $stat . "," . $komp]
                ];
            }

            $fileInstruksi = $this->request->getFile('instruksi,' . $stat);
            $fileRubrik = $this->request->getFile('rubrik,' . $stat);
            $filePendukung = $this->request->getFile('pendukung,' . $stat);

            $namaInstruksi = ($fileInstruksi != null) ? filePertanyaan([$namaSetting, $stat, 'instruksi', $fileInstruksi,  $fileLama[$keyS]['instruksi'], $id]) : null;
            $namaRubrik = ($fileRubrik != null) ? filePertanyaan([$namaSetting, $stat, 'rubrik', $fileRubrik,  $fileLama[$keyS]['rubrik'], $id]) : null;
            $namaPendukung = ($filePendukung != null) ? filePertanyaan([$namaSetting, $stat, 'pendukung', $filePendukung,  $fileLama[$keyS]['pendukung'], $id]) : null;

            $data[] = [
                'station' => $stat,
                'status' => $stationStatusLama[$stat],
                'attachment' => [$namaInstruksi, $namaRubrik],
                'pendukung' => $namaPendukung,
                'skenario' => $_POST['skenario,' . $stat],
                'detail' => $detail
            ];
        }
        // dd($data);
        $data = array(
            'setPertanyaan' => json_encode(['data' => $data]),
            'setModifiedBy' => user()->email
        );

        if ($this->pertanyaanModel->updateData(['setId' => $id], $data)) :
            session()->setFlashdata('success', 'Berhasil Generate Pertanyaan');
        else :
            session()->setFlashdata('error', 'Gagal Generate Station');
        endif;
        return redirect()->to($url);
    }

    public function print($id)
    {
        $data = $this->pertanyaanModel->getWhere(['setId' => $id])->getResult()[0];
        $pertanyaan = $data->setPertanyaan;
        $nama = $data->setDeskripsi;
        $dataCetak = ['nama' => $nama, 'pertanyaan' => json_decode($pertanyaan)->data];

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
        $mpdf->WriteHTML(view('Modules\Pertanyaan\Views\cetakPertanyaan', $dataCetak));
        return redirect()->to($mpdf->Output('Skenario dan Tugas ' . $nama . '.pdf', 'I'));
    }
}
