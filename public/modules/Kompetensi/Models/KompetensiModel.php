<?php

namespace Modules\Kompetensi\Models;

use CodeIgniter\Model;

class KompetensiModel extends Model
{
    protected $table = 'kompetensi';
    protected $primaryKey = 'kompetensiId';
    protected $allowedFields = ['kompetensiNama', 'kompetensiSingkatan', 'kompetensiCreatedBy', 'kompetensiCreatedDate', 'kompetensiModifiedBy', 'kompetensiModifiedDate', 'kompetensiDeletedDate'];
    protected $useTimestamps = 'false';
    protected $useSoftDeletes = 'true';
    protected $createdField = 'kompetensiCreatedDate';
    protected $updatedField = 'kompetensiModifiedDate';
    protected $deletedField = 'kompetensiDeletedDate';
    protected $returnType = 'object';

    public function getKompetensi($keyword = null)
    {
        $builder = $this->table($this->table);
        if ($keyword) {
            $builder->like($this->table . '.kompetensiNama', $keyword)->where($this->table . '.kompetensiDeletedDate', null);
        }
        $builder->orderBy($this->table . '.kompetensiId', 'DESC');
        return $builder;
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
