<?php

namespace Modules\Penguji\Models;

use CodeIgniter\Model;

class PengujiModel extends Model
{
    protected $table = 'settingtes';
    protected $primaryKey = 'setId';
    protected $allowedFields = ['setDeskripsi', 'setLokasi', 'setJumlahStation', 'setStation', 'setPertanyaan', 'setStartDate', 'setCreatedBy', 'setCreatedDate', 'setModifiedBy', 'setModifiedDate', 'setDeletedDate'];
    protected $useTimestamps = 'false';
    protected $useSoftDeletes = 'true';
    protected $createdField = 'setCreatedDate';
    protected $updatedField = 'setModifiedDate';
    protected $deletedField = 'setDeletedDate';
    protected $returnType = 'object';

    public function getPenguji($keyword = null)
    {
        $builder = $this->table($this->table);
        if ($keyword) {
            $builder->like($this->table . '.setDeskripsi', $keyword)->where($this->table . '.setDeletedDate', null);
        }
        $builder->orderBy($this->table . '.setId', 'DESC');
        return $builder;
    }

    public function getPengujiById($id)
    {
        $builder = $this->db->table("function_tampil_setting_penguji_peserta('" . $id . "')");
        return $builder->get();
    }

    public function getMahasiwa()
    {
        $builder = $this->db->table("mahasiswa");
        return $builder->get();
    }

    public function getDosen()
    {
        $builder = $this->db->table("penguji");
        return $builder->get();
    }

    public function updateData($where, $data)
    {
        $builder = $this->table($this->table);
        return $builder->set($data)
            ->where($where)
            ->update();
    }

    public function deleteData($where)
    {
        $builder = $this->table($this->table);
        return $builder->where($where)
            ->delete();
    }
}
