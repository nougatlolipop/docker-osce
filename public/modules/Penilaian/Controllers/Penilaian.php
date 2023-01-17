<?php

/* 
This is Controller Krs
 */

namespace Modules\Penilaian\Controllers;

use App\Controllers\BaseController;
use Modules\Penilaian\Models\PenilaianModel;
use Modules\Setting\Models\SettingModel;
use Modules\Penguji\Models\PengujiModel;
use Modules\Grade\Models\GradeModel;
use Modules\Kompetensi\Models\KompetensiModel;

class Penilaian extends BaseController
{
    protected $penilaianModel;
    protected $setting;
    protected $pengujiModel;
    protected $gradeModel;
    protected $kompetensiModel;

    public function __construct()
    {
        $this->penilaianModel = new PenilaianModel();
        $this->setting = new SettingModel();
        $this->pengujiModel = new PengujiModel();
        $this->gradeModel = new GradeModel();
        $this->kompetensiModel = new KompetensiModel();
    }

    public function index()
    {
        $id = session()->get('setId');
        $lokasi = session()->get('lokasiId');
        $station = session()->get('stationId');

        $grInit = [
            ['title' => 'Tidak Lulus', 'nilai' => 0],
            ['title' => 'Borderline', 'nilai' => 1],
            ['title' => 'Lulus', 'nilai' => 2],
            ['title' => 'Superior', 'nilai' => 3],
        ];
        $peserta = $this->penilaianModel->getPeserta(
            [
                'peserta."setId"' => $id,
                'peserta."lokasiId"' => $lokasi,
                'peserta."stationId"' => $station
            ],
            [
                'nilai."setId"' => $id,
                'nilai."stationId"' => $station
            ]
        )->getResult();
        $pesertaAll = $this->penilaianModel->getAllPeserta(
            [
                'peserta."setId"' => $id,
                'peserta."lokasiId"' => $lokasi,
                'peserta."stationId"' => $station
            ]
        )->getResult();
        $grade = $this->gradeModel->getWhere(['grade.gradeSetId' => $id])->getResult();
        $dataTest = $this->setting->getWhere(['setId' => $id])->getResult()[0];
        $attach = $this->penilaianModel->getAllAttachment($id, $station)->getResult();
        $attachement = json_decode($attach[0]->attachment);
        $filePendukung = $attach[0]->filePendukung;
        $setNama = $attach[0]->setDeskripsi;
        $instruksi = array_search('instruks2.pdf', $attachement);
        $rubrik = array_search('rubrik.pdf', $attachement);

        $data = [
            'title' => 'Penilaian',
            'skenario' => $this->penilaianModel->getSkenario($id, $station)->getResult(),
            'globalrate' => $grInit,
            'peserta' => $peserta,
            'pesertaAll' => $pesertaAll,
            'grade' => $grade,
            'kompetensi' => $this->kompetensiModel->findAll(),
            'station' => $station,
            'testNama' => $dataTest->setDeskripsi,
            'testPertanyaan' => $dataTest->setPertanyaan,
            'filePendukung' => $filePendukung,
            'instruksi' => ($instruksi !== null) ? 'file/' . subfolder($setNama, $id) . '/instruksi/' . strtolower(str_replace(' ', '', session()->get('stationNama'))) . '/' . $attachement[$instruksi] : null,
            'rubrik' => ($rubrik !== null) ? 'file/' . subfolder($setNama, $id) . '/rubrik/' . strtolower(str_replace(' ', '', session()->get('stationNama'))) . '/' . $attachement[$rubrik] : null
        ];

        return view('Modules\Penilaian\Views\penilaian', $data);
    }

    public function add()
    {
        $setId = (int)session()->get('setId');
        $npm = $this->request->getVar('mahasiswaNpm');
        $station = (int)session()->get('stationId');
        $absen = $this->request->getVar('kehadiran');

        if ($absen) {
            $data = $this->setting->getSettingById($setId)->findAll();
            $data = json_decode($data[0]->setStation)->data;
            $dataubahkehadiran = [];
            foreach ($data as $idx => $dt) {
                $dataubahkehadiran['lokasi'] = $dt->lokasi;
                foreach ($dt->detail as $idxdet => $det) {
                    $mahasiswa = $det->mahasiswa;
                    $data_mhs = [];
                    foreach ($mahasiswa as $imhs => $mhs) {
                        $data_mhs[] = [
                            'urutan' => $mhs->urutan,
                            'mahasiswa' => $mhs->mahasiswa,
                            'kehadiran' => ($npm == $mhs->mahasiswa) ? 0 : $mhs->kehadiran,
                        ];
                    }
                    $dataubahkehadiran['detail'][] = [
                        "station" => $det->station,
                        "stationNama" => $det->stationNama,
                        "stationStatus" => $det->stationStatus,
                        "stationActiveKey" => $det->stationActiveKey,
                        "stationKey" => $det->stationKey,
                        "penguji" => $det->penguji,
                        "mahasiswa" => $data_mhs
                    ];
                }
            }

            $data = array(
                'setStation' => json_encode(['data' => [$dataubahkehadiran]]),
                'setModifiedBy' => 'penguji'
            );

            $this->pengujiModel->updateData(['setId' => $setId], $data);
        }


        $key = array_keys($_POST);
        $nilai = [];

        foreach ($key as $val) {
            if (count(explode(',', $val)) > 1) {
                if (explode(',', $val)[0] == 'nilai') {
                    $nilai[] = [
                        'kompetensi' => (int)explode(',', $val)[1],
                        'value' => (int)$_POST['nilai,' . explode(',', $val)[1]]
                    ];
                }
            }
        }
        $grade = [];
        $grade[] = ['nilai' => $nilai];
        if ($absen) {
            $result[] = [
                'station' => $station,
                'globalRate' => isset($_POST['gr']) ? (int)$_POST['gr'] : 0,
                'detail' => []
            ];
        } else {
            $result[] = [
                'station' => $station,
                'globalRate' => isset($_POST['gr']) ? (int)$_POST['gr'] : 0,
                'detail' => $grade
            ];
        }

        $result = json_encode(['data' => $result]);
        $cekGrade = $this->penilaianModel->where([
            'gradeSetId' => $setId,
            'gradeMahasiswa' => $npm
        ])->first();


        if ($cekGrade == null) {

            $data = [
                'gradeSetId' => $setId,
                'gradeMahasiswa' => $npm,
                'gradeNilai' => $result
            ];

            $this->penilaianModel->insert($data);
            return redirect()->to('/penilaian');
        }
        $dataEdit = [];
        foreach (json_decode($cekGrade->gradeNilai)->data as $key => $value) {
            $dataEdit[] = [
                'station' => $value->station,
                'globalRate' => $value->globalRate,
                'detail' => $value->detail,
            ];
        }

        foreach (json_decode($result)->data as $key => $value) {
            $dataEdit[] = [
                'station' => $value->station,
                'globalRate' => $value->globalRate,
                'detail' => $value->detail,
            ];
        }

        $data = [
            'gradeNilai' => json_encode(['data' => $dataEdit])
        ];

        $this->penilaianModel->updateData([
            'gradeSetId' => $setId,
            'gradeMahasiswa' => $npm
        ], $data);
        return redirect()->to('/penilaian');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/pengawas');
    }
}
