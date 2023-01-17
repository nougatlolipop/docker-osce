<?php

/* 
This is Controller Krs
 */

namespace Modules\ConfigSet\Controllers;

use App\Controllers\BaseController;
use Modules\ConfigSet\Models\ConfigSetModel;


class ConfigSet extends BaseController
{
    protected $configSetModel;

    public function __construct()
    {
        $this->configSetModel = new ConfigSetModel();
    }
    public function index()
    {
        $configSet = $this->configSetModel->findAll();
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Setting",
            'breadcrumb' => ['General Setting', 'Setting'],
            'configSet' => $configSet,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\ConfigSet\Views\configSet', $data);
    }

    public function edit($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $configTipe = $this->request->getVar('configTipe');
        if ($configTipe == 1) {
            $configValue = $this->request->getVar('configValue');
            $data = [
                'configValue' => $configValue,
                'configModifiedBy' => user()->email
            ];
        } else {
            $gambar = $this->request->getFile('getGambar');
            if ($gambar->getError() == 4) {
                $namaGambar = $this->request->getVar('gambarLama');
            } else {
                $gambar->move('assets');
                $namaGambar = $gambar->getName();
                unlink('assets/' . $this->request->getVar('gambarLama'));
            }
            $data = [
                'configValue' => $namaGambar,
                'configModifiedBy' => user()->email
            ];
        }
        $configDeskripsi = $this->configSetModel->getWhere(['configId' => $id])->getResult()[0]->configDeskripsi;
        if ($this->configSetModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data <strong>' . $configDeskripsi . '</strong> Berhasil Diupdate');
        }
        return redirect()->to($url);
    }
}
