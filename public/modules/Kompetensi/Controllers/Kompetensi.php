<?php

/* 
This is Controller Krs
 */

namespace Modules\Kompetensi\Controllers;

use App\Controllers\BaseController;
use Modules\Kompetensi\Models\KompetensiModel;


class Kompetensi extends BaseController
{
    protected $kompetensiModel;

    public function __construct()
    {
        $this->kompetensiModel = new KompetensiModel();
    }
    public function index()
    {
        $currentPage = $this->request->getVar('page_kompetensi') ? $this->request->getVar('page_kompetensi') : 1;
        $keyword = $this->request->getVar('keyword');
        $kompetensi = $this->kompetensiModel->getKompetensi($keyword);
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Kompetensi",
            'breadcrumb' => ['Home', 'Kompetensi'],
            'kompetensi' => $kompetensi->paginate($this->numberPage, 'kompetensi'),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $kompetensi->pager,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\Kompetensi\Views\kompetensi', $data);
    }

    public function add()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'kompetensiNama' => rv('required', ['required' => 'Nama Kompetensi Harus Diisi']),
            'kompetensiSingkatan' => rv('required', ['required' => 'Nama Singkatan Harus Diisi']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };
        $data = array(
            'kompetensiNama' => $this->request->getVar('kompetensiNama'),
            'kompetensiSingkatan' => $this->request->getVar('kompetensiSingkatan'),
            'kompetensiCreatedBy' => user()->email
        );

        if ($this->kompetensiModel->insert($data)) :
            session()->setFlashdata('success', 'Kompetensi Berhasil DiTambah');
        else :
            session()->setFlashdata('error', 'Kompetensi Gagal DiTambah');
        endif;
        return redirect()->to($url);
    }

    public function edit($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'kompetensiNama' => rv('required', ['required' => 'Nama Kompetensi Harus Diisi']),
            'kompetensiSingkatan' => rv('required', ['required' => 'Nama Singkatan Harus Diisi']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };
        $data = array(
            'kompetensiNama' => $this->request->getVar('kompetensiNama'),
            'kompetensiSingkatan' => $this->request->getVar('kompetensiSingkatan'),
            'kompetensiModifiedBy' => user()->email
        );

        if ($this->kompetensiModel->updateData(['kompetensiId' => $id], $data)) :
            session()->setFlashdata('success', 'Kompetensi Berhasil Diupdate');
        else :
            session()->setFlashdata('error', 'Kompetensi Gagal Diupdate');
        endif;
        return redirect()->to($url);
    }

    public function delete($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->kompetensiModel->deleteData(['kompetensiId' => $id])) :
            session()->setFlashdata('success', 'Kompetensi Berhasil Dihapus');
        else :
            session()->setFlashdata('error', 'Kompetensi Gagal Dihapus');
        endif;
        return redirect()->to($url);
    }
}
