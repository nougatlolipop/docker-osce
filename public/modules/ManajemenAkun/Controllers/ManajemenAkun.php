<?php

/* 
This is Controller ManajemenAkun
 */

namespace Modules\ManajemenAkun\Controllers;

use App\Controllers\BaseController;
use Modules\ManajemenAkun\Models\ManajemenAkunModel;
use App\Models\AuthGroupsModel;
use App\Models\AuthGroupsUsersModel;


class ManajemenAkun extends BaseController
{
    protected $manajemenAkunModel;
    protected $authGroupsUsersModel;
    protected $authGroupsModel;
    protected $validation;

    public function __construct()
    {
        $this->manajemenAkunModel = new ManajemenAkunModel();
        $this->authGroupsModel = new AuthGroupsModel();
        $this->authGroupsUsersModel = new AuthGroupsUsersModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page_akun') ? $this->request->getVar('page_akun') : 1;
        $keyword = $this->request->getVar('keyword');
        $manajemenAkun = $this->manajemenAkunModel->getManajemenAkun($keyword);
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Manajemen Akun",
            'breadcrumb' => ['User', 'Manajemen Akun'],
            'manajemenAkun' => $manajemenAkun->paginate($this->numberPage, 'manajemenAkun'),
            'currentPage' => $currentPage,
            'pager' => $manajemenAkun->pager,
            'numberPage' => $this->numberPage,
            'authGroups' =>  $this->authGroupsModel->findAll(),
            'validation' => \Config\Services::validation(),
        ];

        return view('Modules\ManajemenAkun\Views\manajemenAkun', $data);
    }

    public function edit($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'userEmail' => rv('required', ['required' => 'Email Harus Diisi']),
            'userName' => rv('required', ['required' => 'Nama Harus Diisi']),
            'userRole' => rv('required', ['required' => 'Role Harus Dipilih']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };

        $data = array(
            'email' => trim($this->request->getPost('userEmail')),
            'username' => trim($this->request->getPost('userName')),
            'active' => trim($this->request->getPost('userActive')) == null ? 0 : 1
        );

        $data_user_group = array('group_id' => trim($this->request->getPost('userRole')));

        if ($this->manajemenAkunModel->update($id, $data)) {
            if ($this->authGroupsUsersModel->update($id, $data_user_group)) {
                session()->setFlashdata('success', 'Data Akun Berhasil Diupdate !');
                return redirect()->to($url);
            }
        }
    }
}
