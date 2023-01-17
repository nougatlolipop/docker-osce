<?php

function getDosen()
{
    $configSet = new \Modules\ConfigSet\Models\ConfigSetModel;
    $result = $configSet->getWhere(['configNama' => 'getDosen'])->getResult()[0]->configValue;
    return $result;
}

function getMahasiswa()
{
    $configSet = new \Modules\ConfigSet\Models\ConfigSetModel;
    $result = $configSet->getWhere(['configNama' => 'getMahasiswa'])->getResult()[0]->configValue;
    return $result;
}

function getNamaApp()
{
    $configSet = new \Modules\ConfigSet\Models\ConfigSetModel;
    $result = $configSet->getWhere(['configNama' => 'getNamaApp'])->getResult()[0]->configValue;
    return $result;
}

function getGambarApp()
{
    $configSet = new \Modules\ConfigSet\Models\ConfigSetModel;
    $result = $configSet->getWhere(['configNama' => 'getGambarApp'])->getResult()[0]->configValue;
    return $result;
}

function getTulisanHeader()
{
    $configSet = new \Modules\ConfigSet\Models\ConfigSetModel;
    $result = $configSet->getWhere(['configNama' => 'getTulisanHeader'])->getResult()[0]->configValue;
    return $result;
}

function getGambarHeader()
{
    $configSet = new \Modules\ConfigSet\Models\ConfigSetModel;
    $result = $configSet->getWhere(['configNama' => 'getGambarHeader'])->getResult()[0]->configValue;
    return $result;
}

function getDefaultMhs()
{
    $configSet = new \Modules\ConfigSet\Models\ConfigSetModel;
    $result = $configSet->getWhere(['configNama' => 'getDefaultMhs'])->getResult()[0]->configValue;
    return $result;
}

function getDefaultDosen()
{
    $configSet = new \Modules\ConfigSet\Models\ConfigSetModel;
    $result = $configSet->getWhere(['configNama' => 'getDefaultDosen'])->getResult()[0]->configValue;
    return $result;
}

function getNilaiMax()
{
    $configSet = new \Modules\ConfigSet\Models\ConfigSetModel;
    $result = $configSet->getWhere(['configNama' => 'getNilaiMax'])->getResult()[0]->configValue;
    return $result;
}

function getConfigSet($data, $nama)
{
    foreach ($data as $key => $value) {
        if ($nama == $value->configNama) {
            $result = ['configId' => $value->configId, 'configValue' => $value->configValue, 'configDeskripsi' => $value->configDeskripsi, 'configTipe' => $value->configTipe];
        }
    }
    return $result;
}

function getDetailSet($id)
{
    $penguji = new \Modules\Penguji\Models\PengujiModel;
    $result = $penguji->getPengujiById($id)->getResult();
    return $result;
}

function getDosenNama($id)
{
    $dosen = new \Modules\Dosen\Models\DosenModel;
    $result = $dosen->getWhere(['pengujiId' => $id])->getResult()[0]->pengujiNama;
    return $result;
}

function getMahasiswaNama($npm)
{
    $mahasiswa = new \Modules\Mahasiswa\Models\MahasiswaModel;
    $result = $mahasiswa->getWhere(['mahasiswaNpm' => $npm])->getResult()[0]->mahasiswaNama;
    return $result;
}

function getGradeGr($data, $sts)
{
    $data = json_decode($data)->data;
    foreach ($data as $key => $value) {
        if ($sts == $value->station) {
            $gr = $value->globalRate;
        }
    }
    return $gr;
}

function getGrade($data, $sts, $kmp, $type)
{
    $nilai = 0;
    $data = json_decode($data)->data;
    foreach ($data as $key => $value) {
        if ($sts == $value->station) {
            foreach ($value->detail as $dtNilai) {
                foreach ($dtNilai->nilai as $key => $grade) {
                    if ($grade->kompetensi == $kmp) {
                        if ($type == 'nilai') {
                            $nilai = $grade->value;
                        } else {
                            $nilai = 3;
                        }
                    }
                }
            }
        }
    }
    return $nilai;
}

// function getAmMax($data, $sts, $kmp)
// {
//     $nilai = '';
//     foreach ($data as $key => $value) {
//         if ($sts == $value->station) {
//             foreach ($value->detail as $dtNilai) {
//                 foreach ($dtNilai->nilai as $key => $grade) {
//                     if ($grade->kompetensi == $kmp) {
//                         $nilai = 3;
//                     }
//                 }
//             }
//         }
//     }
//     return $nilai;
// }

function getBobot($data, $sts, $kmp)
{
    $bobot = 0;
    $data = json_decode($data)->data;
    foreach ($data as $key => $dtPerny) {
        if ($sts == $dtPerny->station) {
            foreach ($dtPerny->detail as $key => $detail) {
                if ($detail->kompetensi == $kmp) {
                    $bobot = $detail->bobot;
                }
            }
        }
    }
    return $bobot;
}

function removeSpecialChar($st)
{
    $st = str_replace(' ', '-', $st);
    return preg_replace('/[^A-Za-z0-9\-]/', '', $st);
}

function filePertanyaan($param)
{
    $main = subfolder($param[0], $param[5]);
    if ($param[3]->getError() == 4) {
        $nama = $param[4];
    } else {
        if (!file_exists((FCPATH . 'file/' . $main . '/' . $param[2] . '/station' . $param[1]))) {
            mkdir(FCPATH . 'file/' . $main . '/' . $param[2] . '/station' . $param[1], '0777', true);
        }
        $nama = $param[2] . '.pdf';
        if ($param[4] != null) {
            unlink('file/' . $main . '/' . $param[2] . '/station' . $param[1] . '/' . $nama);
        }
        $param[3]->move('file/' . $main . '/' . $param[2] . '/station' . $param[1], $nama);
    }
    return $nama;
}
