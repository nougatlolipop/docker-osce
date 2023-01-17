<?php

/* 
This is Controller Krs
 */

namespace Modules\Lokasi\Controllers;

use App\Controllers\BaseController;
use Modules\Lokasi\Models\LokasiModel;


class Lokasi extends BaseController
{
    protected $lokasiModel;

    public function __construct()
    {
        $this->lokasiModel = new LokasiModel();
    }
    public function index()
    {
        $currentPage = $this->request->getVar('page_lokasi') ? $this->request->getVar('page_lokasi') : 1;
        $keyword = $this->request->getVar('keyword');
        $lokasi = $this->lokasiModel->getLokasi($keyword);
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Lokasi",
            'breadcrumb' => ['Home', 'Lokasi'],
            'lokasi' => $lokasi->paginate($this->numberPage, 'lokasi'),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $lokasi->pager,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\Lokasi\Views\lokasi', $data);
    }

    public function add()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'lokasiNama' => rv('required', ['required' => 'Nama Lokasi Harus Diisi']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };
        $data = array(
            'lokasiNama' => $this->request->getVar('lokasiNama'),
            'lokasiCreatedBy' => user()->email
        );

        if ($this->lokasiModel->insert($data)) :
            session()->setFlashdata('success', 'Lokasi Berhasil DiTambah');
        else :
            session()->setFlashdata('error', 'Lokasi Gagal DiTambah');
        endif;
        return redirect()->to($url);
    }

    public function edit($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'lokasiNama' => rv('required', ['required' => 'Nama Lokasi Harus Diisi']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };
        $data = array(
            'lokasiNama' => $this->request->getVar('lokasiNama'),
            'lokasiModifiedBy' => user()->email
        );

        if ($this->lokasiModel->updateData(['lokasiId' => $id], $data)) :
            session()->setFlashdata('success', 'Lokasi Berhasil Diupdate');
        else :
            session()->setFlashdata('error', 'Lokasi Gagal Diupdate');
        endif;
        return redirect()->to($url);
    }

    public function delete($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->lokasiModel->deleteData(['lokasiId' => $id])) :
            session()->setFlashdata('success', 'Lokasi Berhasil Dihapus');
        else :
            session()->setFlashdata('error', 'Lokasi Gagal Dihapus');
        endif;
        return redirect()->to($url);
    }
}
