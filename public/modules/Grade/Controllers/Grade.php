<?php

/* 
This is Controller Krs
 */

namespace Modules\Grade\Controllers;

use App\Controllers\BaseController;
use Modules\Grade\Models\GradeModel;
use Modules\Setting\Models\SettingModel;
use Modules\Kompetensi\Models\KompetensiModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class Grade extends BaseController
{
    protected $gradeModel;
    protected $settingModel;
    protected $kompetensiModel;
    protected $spreadsheet;
    protected $ReaderHtml;

    public function __construct()
    {
        $this->gradeModel = new GradeModel();
        $this->settingModel = new SettingModel();
        $this->kompetensiModel = new KompetensiModel();
        $this->spreadsheet = new Spreadsheet();
        $this->ReaderHtml = new \PhpOffice\PhpSpreadsheet\Reader\Html();
    }

    public function index()
    {
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Hasil Test",
            'breadcrumb' => ['Laporan', 'Hasil Test'],
            'setting' => $this->settingModel->findAll(),
            'testNama' => '',
            'grade' => [],
            'dataFilter' => [null],
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\Grade\Views\grade', $data);
    }

    public function load()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        if (!$this->validate([
            'test' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Test Harus Dipilih!',
                ]
            ],
        ])) {
            return redirect()->to($url)->withInput();
        }

        $test = trim($this->request->getVar('test'));
        $grade = $this->gradeModel->getWhere(['grade.gradeSetId' => $test])->getResult();
        $dataTest = $this->settingModel->getWhere(['setId' => $test])->getResult()[0];

        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Hasil Test",
            'breadcrumb' => ['Laporan', 'Hasil Test'],
            'setting' => $this->settingModel->findAll(),
            'kompetensi' => $this->kompetensiModel->findAll(),
            'testNama' => $dataTest->setDeskripsi,
            'testPertanyaan' => $dataTest->setPertanyaan,
            'grade' => $grade,
            'dataFilter' => [$test],
            'validation' => \Config\Services::validation(),
        ];

        if ($grade == null) {
            session()->setFlashdata('danger', 'Hasil Test <strong>' . $dataTest->setDeskripsi . '</strong> Belum Ada, Coba Lagi Nanti!');
            session()->remove('success');
        } else {
            session()->setFlashdata('success', 'Hasil Test <strong>' . $dataTest->setDeskripsi . '</strong> Sudah Ditemukan!');
            session()->remove('danger');
        }
        return view('Modules\Grade\Views\grade', $data);
    }

    public function print()
    {
        $test = trim($this->request->getVar('test'));
        $grade = $this->gradeModel->getWhere(['grade.gradeSetId' => $test])->getResult();
        $dataTest = $this->settingModel->getWhere(['setId' => $test])->getResult()[0];
        $kompetensi = $this->kompetensiModel->findAll();
        $testNama = $dataTest->setDeskripsi;
        $testPertanyaan = $dataTest->setPertanyaan;

        $this->spreadsheet = new Spreadsheet();

        $htmlString = '';
        $htmlString .= '<table style="border: 1px solid black">';
        $gradeDetail = json_decode($grade[0]->gradeNilai);
        $station = [];
        foreach ($gradeDetail->data as $key => $dt) {
            array_push($station, $dt->station);
        };
        $span = count($kompetensi);
        $htmlString .= '<thead>';
        $htmlString .= '<tr>';
        $htmlString .= '<th align="center" valign="center" style="font-weight: bold;border:solid black" rowspan="2" colspan="3">' . $testNama . '</th>';
        foreach ($gradeDetail->data as $key => $dtDetail) {
            $htmlString .= '<th align="center" valign="center" style="font-weight: bold;border:solid black" rowspan="2">GR</th>';
            $htmlString .= '<th align="center" style="font-weight: bold;border:solid black;" bgcolor="#e4e6f9" colspan="' . $span . '">Station';
            sort($station);
            $jml = count($station);
            for ($i = 0; $i < count($station); $i++) {
                $htmlString .= ($i == $key) ? $station[$i] : '';
            }
            $htmlString .= '</th>';
            $htmlString .= ' <th align="center" valign="center" style="font-weight: bold;border:solid black" rowspan="2">AM</th>';
            $htmlString .= ' <th align="center" valign="center" style="font-weight: bold;border:solid black" rowspan="2"></th>';
        }
        $htmlString .= ' <th align="center" valign="center" style="font-weight: bold;border:solid black" rowspan="2">Rerata AM</th>';
        $htmlString .= '</tr>';
        $htmlString .= '<tr>';
        foreach ($gradeDetail->data as $dtDetail) {
            foreach ($kompetensi as $dtKompetensi) {
                $htmlString .= '<th align="center" style="font-weight: bold;border:solid black;" bgcolor="#e4e6f9">' . $dtKompetensi->kompetensiSingkatan . '</th>';
            }
        }
        $htmlString .= '</thead>';
        $htmlString .= '<tbody>';
        $no = 1;
        foreach ($grade as $dtGrade) {
            $htmlString .= '<tr>';
            $htmlString .= '<td align="center" style="border:solid black"  width="50%">' . $no++ . '</td>';
            $htmlString .= '<td align="left" style="border:solid black" width="150%">' . $dtGrade->gradeMahasiswa . '</td>';
            $htmlString .= '<td style="border:solid black" width="350%">' . getMahasiswaNama($dtGrade->gradeMahasiswa) . '</td>';
            $rerata = [];
            foreach ($gradeDetail->data as $key => $dtDetail) {
                $htmlString .= '<td align="center" style="border:solid black">';
                sort($station);
                for ($i = 0; $i < count($station); $i++) {
                    $htmlString .= ($i == $key) ? getGradeGr($dtGrade->gradeNilai, $station[$i]) : '';
                }
                $htmlString .= '</td>';
                $akhir = [];
                $max = [];
                foreach ($kompetensi as $dtKompetensi) {
                    $htmlString .= '<td align="center" style="border:solid black">';
                    sort($station);
                    for ($i = 0; $i < count($station); $i++) {
                        $nilai = ($i == $key) ? getGrade($dtGrade->gradeNilai, $station[$i], $dtKompetensi->kompetensiId, 'nilai') : '';
                        $htmlString .= $nilai;
                        $nilaiMax = ($i == $key) ? getGrade($dtGrade->gradeNilai, $station[$i], $dtKompetensi->kompetensiId, 'nilaiMax') : '';
                        $bobot = ($i == $key) ? getBobot($testPertanyaan, $station[$i], $dtKompetensi->kompetensiId) : '';
                        $hasil = ($i == $key) ? $nilai * $bobot : '';
                        $nilaiT = ($i == $key) ? $nilaiMax * $bobot : '';
                        array_push($akhir, $hasil);
                        array_push($max, $nilaiT);
                    }
                    $htmlString .= '</td>';
                }
                $persen = (array_sum($akhir) == 0) ? 0 : (array_sum($akhir) / array_sum($max)) * 100;
                $am = array_sum($akhir);
                array_push($rerata, $am);
                $htmlString .= '<td align="center" style="border:solid black">' . $am . '</td>';
                $htmlString .= '<td align="center" style="border:solid black">' . round($persen, 2) . '</td>';
            }
            $rerataT = array_sum($rerata) / $jml;
            $htmlString .= '<td align="center" style="border:solid black">' . round($rerataT, 2) . '</td>';
            $htmlString .= '</tr>';
        }
        $htmlString .= '</tbody>';
        $htmlString .= '</table>';

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Html($this->spreadsheet);
        $this->spreadsheet = $reader->loadFromString($htmlString);

        $writer = new Xls($this->spreadsheet);
        $fileName = 'Hasil OSCE ' . $testNama;
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '.xls"');
        header('Cache-Control: max-age=0');

        ob_end_clean();
        $writer->save('php://output');
    }
}
