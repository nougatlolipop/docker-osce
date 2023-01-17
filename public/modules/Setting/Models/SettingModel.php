<?php

namespace Modules\Setting\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table = 'settingtes';
    protected $tablebantuan = 'function_tampil_setting()';
    protected $primaryKey = 'setId';
    protected $allowedFields = ['setDeskripsi', 'setLokasi', 'setJumlahStation', 'setStationRest', 'setStation', 'setPertanyaan', 'setStartDate', 'setCreatedBy', 'setCreatedDate', 'setModifiedBy', 'setModifiedDate', 'setDeletedDate'];
    protected $useTimestamps = 'false';
    protected $useSoftDeletes = 'true';
    protected $createdField = 'setCreatedDate';
    protected $updatedField = 'setModifiedDate';
    protected $deletedField = 'setDeletedDate';
    protected $returnType = 'object';

    public function getSetting($keyword = null)
    {
        $builder = $this->table($this->table);
        if ($keyword) {
            $builder->like($this->table . '.setDeskripsi', $keyword)->where($this->table . '.setDeletedDate', null);
        }
        $builder->orderBy($this->table . '.setId', 'DESC');
        return $builder;
    }

    public function getSettingById($id)
    {
        $builder = $this->table($this->table);
        $builder->where([$this->table . '.setId' => $id]);
        return $builder;
    }

    public function getSettingDetail($keyword = null)
    {
        $builder = $this->db->table($this->tablebantuan . ' as setting');
        if ($keyword) {
            $builder->like('setting.setDeskripsi', $keyword)->where('setting.setDeletedDate', null);
        }
        $builder->orderBy('setting.setId', 'DESC');
        return $builder;
    }

    public function getSettingWhere($where)
    {
        if ($where[0] == '0') {
            $builder = $this->db->table("function_aktif_station('" . $where[1] . "')");
        } elseif ($where[0] == '1') {
            $builder = $this->db->table("function_login_station('" . $where[1] . "','" . $where[2] . "')");
        }
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
