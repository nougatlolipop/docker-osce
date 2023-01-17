<?php

/* 
This is Controller Krs
 */

namespace Modules\Penguji\Controllers;

use App\Controllers\BaseController;
use Modules\Kompetensi\Models\KompetensiModel;
use Modules\Lokasi\Models\LokasiModel;
use Modules\Penguji\Models\PengujiModel;


class Penguji extends BaseController
{
    protected $pengujiModel;
    protected $lokasiModel;
    protected $kompetensiModel;

    public function __construct()
    {
        $this->pengujiModel = new PengujiModel();
        $this->lokasiModel = new LokasiModel();
        $this->kompetensiModel = new KompetensiModel();
    }
    public function index()
    {
        $currentPage = $this->request->getVar('page_penguji') ? $this->request->getVar('page_penguji') : 1;
        $keyword = $this->request->getVar('keyword');
        $penguji = $this->pengujiModel->getPenguji($keyword);
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Penguji",
            'breadcrumb' => ['Setting Test', 'Penguji'],
            'penguji' => $penguji->paginate($this->numberPage, 'penguji'),
            'lokasi' => $this->lokasiModel->findAll(),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $penguji->pager,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\Penguji\Views\penguji', $data);
    }

    public function getById($id)
    {
        $penguji = $this->pengujiModel->getPengujiById($id)->getResult();
        echo json_encode($penguji);
    }

    public function getMahasiswa()
    {
        $mahasiswa = $this->pengujiModel->getMahasiwa()->getResult();
        echo json_encode(["status" => true, "data" => $mahasiswa]);
    }

    public function getPenguji()
    {
        $penguji = $this->pengujiModel->getDosen()->getResult();
        echo json_encode(["status" => true, "data" => $penguji]);
    }

    public function edit($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');

        // proses pengolahan data baru
        $datalama = $this->pengujiModel->where(['setId' => $id])->findAll()[0];
        $datalama = json_decode($datalama->setStation);

        $stationDataLama = [];
        $stationStatusLama = [];
        $stationDataActiveLama = [];

        foreach ($datalama->data as $key => $value) {
            $lok = $value->lokasi;
            foreach ($value->detail as $s => $st) {
                $stationDataLama[$lok . ',' . $st->station] = $st->stationKey;
                $stationStatusLama[$lok . ',' . $st->station] = $st->stationStatus;
                $stationDataActiveLama[$lok . ',' . $st->station] = $st->stationActiveKey;
            }
        }

        // proses pengolahan data baru
        $key = array_keys($_POST);
        $peserta = [];
        $lokasi = [];
        $station = [];
        foreach ($key as $val) {
            if (count(explode(',', $val)) > 1) {
                if (explode(',', $val)[0] == 'peserta') {
                    $peserta[explode(',', $val)[1]][] = $_POST[$val];
                    $lokasi[] = explode(',', $val)[1];
                    $station[] = explode(',', $val)[2];
                }
            }
        }

        $penguji = [];
        foreach ($key as $val) {
            if (count(explode(',', $val)) > 1) {
                if (explode(',', $val)[0] == 'penguji') {
                    $penguji[] = $_POST[$val];
                }
            }
        }
        $lokasi = array_unique($lokasi);
        $station = array_unique($station);
        // dd($peserta[1]);
        // dd(susunpeserta($peserta[1], 2));

        $json = [];
        foreach ($lokasi as $l => $lok) {
            $detail = [];
            foreach ($station as $s => $sta) {
                $mahasiswaDataBaru = susunpeserta($peserta[$lok], $sta);
                $detail[] = [
                    'station' => $sta,
                    'stationNama' => 'Station ' . $sta,
                    'stationStatus' => $stationStatusLama[$lok . ',' . $sta],
                    'stationActiveKey' => $stationDataActiveLama[$lok . ',' . $sta],
                    'stationKey' => $stationDataLama[$lok . ',' . $sta],
                    'penguji' => ($_POST['penguji,' . $lok . ',' . $sta] == "") ? null : $_POST['penguji,' . $lok . ',' . $sta],
                    'mahasiswa' => $mahasiswaDataBaru
                ];
            }
            $json[] = [
                'lokasi' => $lok,
                'detail' => $detail
            ];
        }

        $data = array(
            'setStation' => json_encode(['data' => $json]),
            'setModifiedBy' => user()->email
        );

        if ($this->pengujiModel->updateData(['setId' => $id], $data)) :
            session()->setFlashdata('success', 'Setting Berhasil Diupdate');
        else :
            session()->setFlashdata('error', 'Setting Gagal Diupdate');
        endif;
        return redirect()->to($url);
    }

    public function print($id)
    {
        $data = $this->pengujiModel->getWhere(['setId' => $id])->getResult()[0];
        $nama = $data->setDeskripsi;
        $penguji = json_decode($data->setStation)->data[0]->detail;
        $dataCetak = ['id' => $id, 'nama' => $nama, 'penguji' => $penguji];
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
        $mpdf->WriteHTML(view('Modules\Penguji\Views\cetakPenguji', $dataCetak));
        return redirect()->to($mpdf->Output('Penguji ' . $nama . '.pdf', 'I'));
    }
}
